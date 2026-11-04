<?php

namespace App\Mcp;

/** A problem the caller can fix; its message is returned to Claude as the tool error. */
class ToolError extends \RuntimeException
{
}
