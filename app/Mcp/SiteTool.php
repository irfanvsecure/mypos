<?php

namespace App\Mcp;

use Closure;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

/**
 * A tool defined by name, description, parameters and a handler closure. Arguments are validated against the
 * declared parameters; the handler gets the validated array and returns data (sent back as JSON). A ToolError,
 * a validation error or "not found" becomes a clear error message for Claude instead of a crash.
 */
class SiteTool extends Tool
{
    /**
     * @param array<string, P> $params
     * @param Closure(array): mixed $handler
     */
    public function __construct(
        private string $toolName,
        private string $toolDescription,
        private array $params,
        private Closure $handler,
        private bool $readOnly = false,
        private bool $destructive = false,
    ) {
    }

    public function name(): string
    {
        return $this->toolName;
    }

    public function title(): string
    {
        return ucfirst(str_replace('_', ' ', $this->toolName));
    }

    public function description(): string
    {
        return $this->toolDescription;
    }

    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    public function schema(JsonSchema $schema): array
    {
        return array_map(fn (P $p) => $p->schema($schema), $this->params);
    }

    public function annotations(): array
    {
        return ['readOnlyHint' => $this->readOnly, 'destructiveHint' => $this->destructive, 'openWorldHint' => false];
    }

    /** @return array<string, array> */
    public function rules(): array
    {
        $rules = [];
        foreach ($this->params as $name => $p) {
            $rules += $p->rules($name);
        }

        return $rules;
    }

    /** Run the handler directly (used by handle() and by tests). */
    public function call(array $args): mixed
    {
        $data = Validator::make($args, $this->rules())->validate();

        return ($this->handler)($data);
    }

    public function handle(Request $request): Response
    {
        $started = microtime(true);
        $args = $request->all();
        $status = 'ok';
        try {
            return Response::json($this->call($args) ?? ['ok' => true]);
        } catch (ValidationException $e) {
            $status = 'invalid';

            return Response::error('Invalid input: ' . implode(' ', $e->validator->errors()->all()));
        } catch (ToolError $e) {
            $status = 'error';

            return Response::error($e->getMessage());
        } catch (ModelNotFoundException $e) {
            $status = 'not_found';

            return Response::error('Not found: no ' . class_basename($e->getModel()) . ' with id ' . implode(', ', (array) $e->getIds()) . '.');
        } catch (\Throwable $e) {
            $status = 'exception';
            report($e);

            return Response::error('The tool failed: ' . (config('app.debug') ? $e->getMessage() : 'unexpected server error (logged).'));
        } finally {
            Log::channel('mcp')->info($this->toolName, [
                'status' => $status,
                'ms' => (int) ((microtime(true) - $started) * 1000),
                'args' => self::summary($args),
                'ip' => request()->ip(),
            ]);
        }
    }

    /** Argument summary for the call log: keys and short values, never whole HTML bodies or base64 data. */
    private static function summary(array $args): array
    {
        return array_map(function ($v) {
            if (is_string($v)) {
                return mb_strlen($v) > 120 ? '[' . mb_strlen($v) . ' chars]' : $v;
            }

            return is_array($v) ? '[array ' . count($v) . ']' : $v;
        }, $args);
    }
}
