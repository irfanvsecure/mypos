<?php

namespace App\Mcp;

/** A problem the caller can fix; its message is returned to Claude as the tool error. */
class ToolError extends \RuntimeException
{
    /** Machine-readable error code, when there is one. */
    public ?string $errorCode = null;

    /** An error whose message is JSON: {"error": code, "message": ..., ...details}. */
    public static function coded(string $code, string $message, array $details = []): self
    {
        $e = new self(json_encode(['error' => $code, 'message' => $message] + $details, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        $e->errorCode = $code;

        return $e;
    }
}
