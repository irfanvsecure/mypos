<?php

namespace App\Mcp;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;

/**
 * One tool parameter, declared once: produces both the JSON schema shown to Claude and the Laravel
 * validation rules applied before the handler runs.
 */
final class P
{
    private bool $required = false;

    private ?array $enum = null;

    private function __construct(
        private string $type,
        private string $description,
        private array $rules,
        private ?P $items = null,
    ) {
    }

    public static function str(string $description, string|array $rules = []): self
    {
        return new self('string', $description, array_merge(['string'], (array) $rules));
    }

    public static function int(string $description, string|array $rules = []): self
    {
        return new self('integer', $description, array_merge(['integer'], (array) $rules));
    }

    public static function num(string $description, string|array $rules = []): self
    {
        return new self('number', $description, array_merge(['numeric'], (array) $rules));
    }

    public static function bool(string $description): self
    {
        return new self('boolean', $description, ['boolean']);
    }

    public static function arr(string $description, ?P $items = null, string|array $rules = []): self
    {
        return new self('array', $description, array_merge(['array'], (array) $rules), $items);
    }

    /** Free-form object (checked by the handler). */
    public static function obj(string $description): self
    {
        return new self('object', $description, ['array']);
    }

    public function req(): self
    {
        $this->required = true;

        return $this;
    }

    public function enum(array $values): self
    {
        $this->enum = $values;
        $this->rules[] = 'in:' . implode(',', $values);

        return $this;
    }

    /** @return array<string, array> Laravel rules for this parameter (and its items). */
    public function rules(string $name): array
    {
        $rules = [$name => array_merge([$this->required ? 'required' : 'nullable'], $this->rules)];
        if ($this->items) {
            foreach ($this->items->rules('*') as $k => $r) {
                $rules[$name . '.' . $k] = $r;
            }
        }

        return $rules;
    }

    public function schema(JsonSchema $s): Type
    {
        $t = match ($this->type) {
            'string' => $s->string(),
            'integer' => $s->integer(),
            'number' => $s->number(),
            'boolean' => $s->boolean(),
            'array' => $s->array(),
            default => $s->object(),
        };
        if ($this->type === 'array' && $this->items) {
            $t->items($this->items->schema($s));
        }
        $t->description($this->description);
        if ($this->enum) {
            $t->enum($this->enum);
        }

        return $this->required ? $t->required() : $t;
    }
}
