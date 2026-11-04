<?php

namespace App\Mcp;

use Laravel\Mcp\Server;

/**
 * MCP server for the mypos.pk marketing website. Only website content: pages, sections, pricing, FAQs,
 * testimonials, client logos, downloads, blog, media, SEO, schema, links, redirects, settings, and read-only
 * website enquiries. There is no tool for SQL, shell, files outside public/uploads, .env, or POS data.
 */
class SiteServer extends Server
{
    protected string $name = 'mypos.pk website';

    protected string $version = '1.0.0';

    protected string $instructions = <<<'MARKDOWN'
        Manage the content and SEO of mypos.pk, the marketing website of myPOS (POS software for Pakistan:
        retail, restaurant, salon, laundry, tailor; FBR digital invoicing and PRA / KPRA / SRB integration).

        How the site is built:
        - Pages have sections. "html" sections hold HTML; "component" sections hold a component name and its
          attributes. Read before you write: get_page_sections returns each section with an `updated_at` stamp;
          pass it back as `expected_updated_at` to update tools so newer edits are never overwritten.
        - Every section change keeps a revision (list_section_revisions / restore_section_revision).
        - Content may contain placeholders filled in at render time. Keep them; only these are allowed:
          {{base}} (site root, use for internal links: {{base}}/pricing), {{demo_url}}, {{wa_link}}, {{phone}},
          {{phone_raw}}, {{email}}, {{address}}, {{hours}}, {{register_url}}, {{whatsapp}}, {{rating_value}},
          {{rating_count}}, {{rating_source}}, {{price:key}} / {{price_plain:key}} (pricing_plans plan_key),
          {{download:key.field}} (downloads), {{embed:N}} (the section's N-th embedded component).
        - Prices live once in pricing_plans and downloads facts once in downloads: change them there, not in text.
        - HTML is sanitized (no scripts, event handlers, forms or javascript: links). The response says what was
          removed, if anything. Every page has exactly one H1.
        - Deletions are soft (list_trash / restore_item); purge_item needs confirm=true.
        - While the site setting SITE_NOINDEX is on (pre-launch), every page is noindex whatever robots you set.
        - Enquiries (leads) are read-only.
        MARKDOWN;

    public int $defaultPaginationLength = 200;

    public int $maxPaginationLength = 200;

    protected function boot(): void
    {
        $this->tools = ToolRegistry::all();
    }
}
