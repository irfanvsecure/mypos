<?php

namespace Tests\Feature\Mcp;

use App\Mcp\ToolError;
use App\Mcp\ToolRegistry;
use App\Site\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

/**
 * Base for MCP tool tests: an in-memory database loaded with the real site content
 * (database/data/site-content.json), and helpers to call a tool the way the server does.
 */
abstract class McpTestCase extends TestCase
{
    use RefreshDatabase;

    protected const SECRET = 'test-secret-0123456789abcdef0123456789abcdef';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\ContentSeeder::class);   // blog posts and client portfolio
        $this->artisan('site:import')->assertSuccessful();
        Settings::apply();
        config(['mcp_site.secret' => self::SECRET, 'mcp_site.require_https' => false, 'mcp_site.cloudflare.token' => null]);
    }

    /** Call a tool and return its result (fails the test on any error). */
    protected function tool(string $name, array $args = []): mixed
    {
        try {
            return ToolRegistry::find($name)->call($args);
        } catch (ValidationException $e) {
            $this->fail("$name: invalid input: " . implode(' ', $e->validator->errors()->all()));
        } catch (ToolError $e) {
            $this->fail("$name: " . $e->getMessage());
        }
    }

    /** Call a tool that must fail; returns the error message. */
    protected function toolError(string $name, array $args = []): string
    {
        try {
            ToolRegistry::find($name)->call($args);
        } catch (ToolError $e) {
            return $e->getMessage();
        } catch (ValidationException $e) {
            return implode(' ', $e->validator->errors()->all());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return 'not found';
        }
        $this->fail("$name should have failed");
    }

    /** Rendered HTML of a path, as a visitor gets it. */
    protected function html(string $path): string
    {
        return $this->get('/' . ltrim($path, '/'))->assertOk()->getContent();
    }
}
