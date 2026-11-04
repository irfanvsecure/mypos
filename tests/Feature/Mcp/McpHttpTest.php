<?php

namespace Tests\Feature\Mcp;

use App\Mcp\ToolRegistry;

/** The /mcp endpoint: authentication, HTTPS rule, JSON-RPC handshake, tool listing and errors. */
class McpHttpTest extends McpTestCase
{
    private function rpc(string $uri, array $body, array $headers = [])
    {
        return $this->withHeaders($headers + ['Accept' => 'application/json, text/event-stream', 'MCP-Protocol-Version' => '2025-06-18'])
            ->postJson($uri, $body);
    }

    private function list(array $headers = [], string $uri = '/mcp')
    {
        return $this->rpc($uri, ['jsonrpc' => '2.0', 'id' => 1, 'method' => 'tools/list'], $headers);
    }

    public function test_no_secret_configured_switches_the_endpoint_off(): void
    {
        config(['mcp_site.secret' => '']);
        $this->list(['Authorization' => 'Bearer ' . self::SECRET])->assertStatus(503);
    }

    public function test_missing_or_wrong_secret_is_rejected(): void
    {
        $this->list()->assertStatus(401);
        $this->list(['Authorization' => 'Bearer wrong-secret-0123456789abcdef0123456789'])->assertStatus(401);
        $this->list([], '/mcp/wrong-secret-0123456789abcdef0123456789abc')->assertStatus(401);
    }

    public function test_bearer_and_path_secret_both_work(): void
    {
        $count = count(ToolRegistry::all());
        $this->list(['Authorization' => 'Bearer ' . self::SECRET])->assertOk()->assertJsonCount($count, 'result.tools');
        $this->list([], '/mcp/' . self::SECRET)->assertOk()->assertJsonCount($count, 'result.tools');
    }

    public function test_plain_http_is_refused_when_https_is_required(): void
    {
        config(['mcp_site.require_https' => true]);
        $this->list(['Authorization' => 'Bearer ' . self::SECRET])->assertStatus(403);
    }

    public function test_initialize_and_call_a_tool(): void
    {
        $auth = ['Authorization' => 'Bearer ' . self::SECRET];
        $this->rpc('/mcp', ['jsonrpc' => '2.0', 'id' => 1, 'method' => 'initialize',
            'params' => ['protocolVersion' => '2025-06-18', 'capabilities' => [], 'clientInfo' => ['name' => 'test', 'version' => '1']]], $auth)
            ->assertOk()->assertJsonPath('result.serverInfo.name', 'mypos.pk website');

        $res = $this->rpc('/mcp', ['jsonrpc' => '2.0', 'id' => 2, 'method' => 'tools/call',
            'params' => ['name' => 'get_page', 'arguments' => ['page' => 'car-wash-pos']]], $auth)->assertOk();
        $this->assertFalse($res->json('result.isError'));
        $this->assertStringContainsString('"path":"car-wash-pos"', $res->json('result.content.0.text'));
    }

    public function test_invalid_input_and_unknown_items_give_clear_errors(): void
    {
        $auth = ['Authorization' => 'Bearer ' . self::SECRET];
        $call = fn ($name, $args) => $this->rpc('/mcp', ['jsonrpc' => '2.0', 'id' => 3, 'method' => 'tools/call', 'params' => ['name' => $name, 'arguments' => $args]], $auth);

        $r = $call('get_page_sections', [])->assertOk();
        $this->assertTrue($r->json('result.isError'));
        $this->assertStringContainsString('page field must be present', $r->json('result.content.0.text'));

        $r = $call('get_page', ['page' => 'no-such-page'])->assertOk();
        $this->assertTrue($r->json('result.isError'));
        $this->assertStringContainsString('No page at /no-such-page', $r->json('result.content.0.text'));
    }

    public function test_every_tool_has_a_description_and_schema(): void
    {
        foreach (ToolRegistry::all() as $tool) {
            $a = $tool->toArray();
            $this->assertMatchesRegularExpression('/^[a-z_]+$/', $a['name']);
            $this->assertGreaterThan(40, strlen($a['description']), "{$a['name']} needs a real description");
            $this->assertSame('object', $a['inputSchema']['type']);
        }
    }

    public function test_calls_are_logged(): void
    {
        \Illuminate\Support\Facades\Log::shouldReceive('channel')->with('mcp')->andReturnSelf()->atLeast()->once();
        \Illuminate\Support\Facades\Log::shouldReceive('info')->withArgs(fn ($tool, $ctx) => $tool === 'list_pages' && $ctx['status'] === 'ok')->once();
        $this->rpc('/mcp', ['jsonrpc' => '2.0', 'id' => 4, 'method' => 'tools/call', 'params' => ['name' => 'list_pages', 'arguments' => []]],
            ['Authorization' => 'Bearer ' . self::SECRET])->assertOk();
    }
}
