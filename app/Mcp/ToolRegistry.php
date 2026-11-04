<?php

namespace App\Mcp;

/** Every tool the MCP server offers, by group. */
class ToolRegistry
{
    public const GROUPS = [
        Tools\PageTools::class,
        Tools\HeadingTools::class,
        Tools\LinkTools::class,
        Tools\ContentTools::class,
        Tools\BlogTools::class,
        Tools\MediaTools::class,
        Tools\SeoTools::class,
        Tools\SiteTools::class,
    ];

    /** @return SiteTool[] */
    public static function all(): array
    {
        $tools = [];
        foreach (self::GROUPS as $group) {
            foreach ($group::tools() as $tool) {
                $tools[$tool->name()] = $tool;
            }
        }

        return array_values($tools);
    }

    public static function find(string $name): SiteTool
    {
        foreach (self::all() as $t) {
            if ($t->name() === $name) {
                return $t;
            }
        }
        throw new \InvalidArgumentException("No tool $name");
    }
}
