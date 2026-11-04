<?php

namespace Tests\Feature\Mcp;

use App\Mcp\ToolRegistry;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

/** Every MCP tool is exercised by at least one feature test. */
class CoverageTest extends TestCase
{
    public function test_every_tool_is_called_in_a_test(): void
    {
        $source = '';
        foreach (File::files(__DIR__) as $f) {
            if ($f->getFilename() !== 'CoverageTest.php') {
                $source .= File::get($f->getPathname());
            }
        }
        $untested = [];
        foreach (ToolRegistry::all() as $tool) {
            if (! preg_match("/(tool|toolError)\('" . preg_quote($tool->name(), '/') . "'|\['" . preg_quote($tool->name(), '/') . "',/", $source)) {
                $untested[] = $tool->name();
            }
        }

        $this->assertSame([], $untested, 'Tools without a test: ' . implode(', ', $untested));
    }
}
