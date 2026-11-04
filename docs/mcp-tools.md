# MCP tools

All 97 tools of the mypos.pk MCP server, generated from `App\Mcp\ToolRegistry`.
**R** = read-only. **W** = changes the site (saves revisions, writes the activity log, clears caches). **D** = deletes (moves to the trash; `restore_item` brings it back, `purge_item` removes it for good).

## Pages & sections

| Tool | | What it does |
|---|---|---|
| `list_pages` | R | List all pages of the website with their URL path, status, SEO title and section count. |
| `get_page` | R | Get one page: details, SEO fields, structured data blocks and a summary of its sections. |
| `create_page` | W | Create a page (saved as a draft unless status=published). Optionally copy all sections of an existing page as a starting point. New pages need exactly one <h1>. |
| `update_page` | W | Change a page's URL path, name or status (published / draft). Changing the path of a published page adds a 301 redirect from the old URL. |
| `delete_page` | D | Move a page to the trash (restore with restore_item). The URL then answers 404. The home page cannot be deleted. |
| `get_page_sections` | R | Get a page's sections in order with their full content (HTML or component attributes) and updated_at stamps. |
| `list_components` | R | List the components a "component" section (or an embed) can use, with the attributes each accepts. |
| `add_page_section` | W | Add a section to a page: type "html" with HTML, or type "component" with a component name and its attributes. Placed after `after` (a section key) or at the end. |
| `update_page_section` | W | Replace a section's HTML (html sections) or attributes / slot HTML (component sections). The previous version is kept as a revision. Keep {{embed:N}} placeholders that the section already has. |
| `delete_page_section` | D | Move a section to the trash (restore with restore_item). |
| `reorder_page_sections` | W | Set the order of a page's sections. List every section key in the new order. |
| `toggle_section_visibility` | W | Show or hide a section without deleting it. |
| `list_section_revisions` | R | List the saved earlier versions of a section (newest first). |
| `restore_section_revision` | W | Bring back an earlier version of a section. The current version is saved as a revision first, so this can be undone. |
| `search_content` | R | Search the visible text of all pages, FAQs, pricing, settings and blog posts. Returns where each match is. |
| `replace_text` | W | Find and replace visible text across pages (sections, including component text), FAQs, pricing features and blog posts. Never touches tags, attributes or links. dry_run (default true) only shows what would change. |

## Headings & content structure

| Tool | | What it does |
|---|---|---|
| `get_page_outline` | R | The H1–H6 outline of the rendered page or blog post (including headings inside components, header and footer): level, text, section and position, plus word counts per section and in total. |
| `update_heading` | W | Change the text and/or level (1–6) of a heading inside one section. Classes, attributes and inline markup around the changed words are kept. Headings that come from a component attribute (e.g. a FAQ title) can change text but not level. |
| `audit_headings` | R | Check headings: missing H1, more than one H1, skipped levels (H2 → H4), empty or duplicate headings, headings over 70 characters. For one page/post or the whole site. |

## Internal links

| Tool | | What it does |
|---|---|---|
| `get_internal_links` | R | Internal links of a page or post: outbound (URL, anchor text, section, nofollow) and inbound (which pages link to it, with anchors). Header/footer links are marked as such. Without `page`, a per-page summary for the whole site. |
| `find_orphan_pages` | R | Published pages and posts that no other page links to from its content. Links from the site header/footer are counted separately. |
| `add_internal_link` | W | Turn the FIRST occurrence of exact anchor_text in a section into a link. Fails if the text is not found or is already a link, or if the page already links to that URL from its content. |
| `update_internal_link` | W | Change the target and/or the anchor text of the links to `url` in a section. |
| `remove_internal_link` | D | Unlink the links to `url` in a section, keeping their text. |
| `replace_link_sitewide` | W | Point every link to old_url at new_url across pages, components, blog posts, header/footer menus, pricing buttons and redirect targets. dry_run (default true) lists what would change; dry_run=false applies it. |
| `anchor_text_report` | R | Every anchor text pointing to a URL, with counts and where it appears; flags generic anchors ("click here", "read more") and heavy exact-match repetition. |
| `check_broken_links` | R | Find broken links, with the page and section where each appears. Internal links are checked against the site (404, 410, redirects); external links with a live HTTP request. |

## Product content (pricing, FAQs, testimonials, client logos, downloads)

| Tool | | What it does |
|---|---|---|
| `list_pricing_plans` | R | List prices and plans. Rows with a plan_key are the single source of a price shown across the site ({{price:key}}); `used_on` lists the pages showing it. |
| `create_pricing_plan` | W | Add a plan or price. Give plan_key to reference the price from page content as {{price:plan_key}}. Cards in plan_group "home" appear in the home page pricing block. |
| `update_pricing_plan` | W | Change a plan or price. Changing price_pkr updates every page that shows this price; a displayed label like "Rs. 2,000" is updated with it. |
| `delete_pricing_plan` | D | Move a plan to the trash. Refused while page content still shows its price ({{price:key}}) unless force=true. |
| `list_faqs` | R | List FAQs by group. Each group is one FAQ block on a page; the FAQPage structured data is generated from these rows automatically. |
| `create_faq` | W | Add a FAQ to a group (shown on the page that uses the group; structured data updates by itself). Plain-text groups take plain text; HTML groups allow simple HTML. |
| `update_faq` | W | Change a FAQ's question, answer, position or visibility. |
| `delete_faq` | D | Move a FAQ to the trash (it disappears from the page and its structured data). |
| `list_testimonials` | R | List customer reviews shown on the home page, sales pages and the thank-you page. |
| `create_testimonial` | W | Add a customer review (plain text). Only add genuine reviews from real customers. |
| `update_testimonial` | W | Change a customer review (name, text, source, rating, order, visibility). |
| `delete_testimonial` | D | Move a customer review to the trash; it disappears from the home page, sales pages and thank-you page (restore with restore_item). |
| `list_client_logos` | R | List client logo strips: group "proof" (the small logo row under calls to action) and the home page marquee rows. |
| `create_client_logo` | W | Add a client logo to a strip. The image must already be uploaded (upload_image) under /uploads. |
| `update_client_logo` | W | Change a client logo (name, image, link, order, visibility). |
| `delete_client_logo` | D | Move a client logo to the trash; it disappears from its logo strip (restore with restore_item). |
| `list_downloads` | R | List the downloadable apps (RetailPro, RestroPro…) with version, size, download count and links. These facts are shown on /downloads and /download/* from one record each. |
| `update_download` | W | Change an app's version, file size, download count, download link, store link, release notes or dates. Every page showing it updates. |

## Blog

| Tool | | What it does |
|---|---|---|
| `list_blogs` | R | List blog posts with status (published / scheduled / draft), category, tags and dates. |
| `get_blog` | R | Get one blog post with its full HTML content, SEO fields, category and tags. |
| `create_blog` | W | Write a new blog post. Saved as a draft unless status=published (or publish_at schedules it). |
| `update_blog` | W | Edit a blog post. Changing the slug of a published post adds a 301 from the old URL. |
| `delete_blog` | D | Move a blog post to the trash (its URL then answers 404; restore with restore_item). |
| `publish_blog` | W | Publish a draft or scheduled post now: it goes live at its URL, on /blogs and in the sitemap. |
| `unpublish_blog` | W | Take a post offline (back to draft). Its URL answers 404 until published again. |
| `schedule_blog` | W | Schedule a post to go live at a future date-time. |
| `list_stale_posts` | R | Published posts not updated for a while (candidates for a refresh). |
| `list_categories` | R | List blog categories (the blog filter bar) with post counts. |
| `create_category` | W | Add a blog category (shown in the /blogs filter bar; posts are assigned with set_blog_taxonomies). |
| `update_category` | W | Rename a category, change its slug (posts move with it), description or position. |
| `delete_category` | D | Move a category to the trash. If posts use it, give move_posts_to (another category slug). |
| `list_tags` | R | List blog tags with post counts and their /tag/ URLs. |
| `create_tag` | W | Add a blog tag (its archive is /tag/<slug>; posts are tagged with set_blog_taxonomies). |
| `update_tag` | W | Rename a tag or change its slug (adds a 301 from the old /tag/ URL). |
| `delete_tag` | D | Move a tag to the trash (posts keep their other tags). |
| `merge_tags` | W | Merge one tag into another: its posts get the target tag, the old tag goes to the trash, and /tag/<from> redirects (301) to /tag/<into>. |
| `set_blog_taxonomies` | W | Set a post's category and/or tags (tags replace the current list; missing tags are created). |

## Images

| Tool | | What it does |
|---|---|---|
| `list_images` | R | List images in /uploads with size, dimensions, alt text and how many places use each. |
| `upload_image` | W | Upload an image from a public URL or base64 data. It is converted to WebP (max 1600 px wide) with 480/800/1200 px srcset sizes. For base64 the file as sent is kept too. Returns ready-to-use <img> HTML. |
| `upload_image_from_url` | W | Download an image from a public URL server-side and add it to the media library. Use when the client cannot fetch external images. |
| `update_image` | W | Change an image's alt text (applied to every <img> that shows it), title, or file name (the file is renamed, every reference updated, and the old URL redirects). |
| `replace_image` | W | Show a different image everywhere an image is used (pages, components, posts, logos, SEO images, settings). |
| `delete_image` | D | Move an image to the trash. Refused while it is used somewhere unless force=true. The file is removed only when the item is purged. |
| `audit_images` | R | Image SEO check of rendered pages: missing or empty alt, filename-like alt ("IMG_123"), files over 300 KB, missing width/height, no WebP, and images below the fold that are not lazy-loaded. |
| `bulk_update_alt` | W | Set alt text for many images at once: [{image_id, alt}]. Each is applied wherever the image appears. |

## SEO, structured data, redirects, sitemap & robots

| Tool | | What it does |
|---|---|---|
| `get_seo` | R | SEO fields of a page, blog post or blog category, plus the values actually output on the page (and whether site-wide noindex is forcing noindex). |
| `update_seo` | W | Set SEO fields of a page, blog post or blog category. Only the fields you pass change; pass "" to clear one. Returns before / after and length warnings. |
| `bulk_update_seo` | W | Update SEO fields of many pages / posts in one call: [{type?, ref, title?, description?, …}]. Returns before / after for each. |
| `audit_meta` | R | Meta-tag audit of every published page and post: missing / duplicate / too long or short titles (aim 50–60 characters) and descriptions (aim 140–160), missing canonical or OG image, and noindex pages still listed in the sitemap. |
| `audit_seo` | R | Overall SEO audit: meta problems, heading problems, images without alt, thin content (under 300 words) and missing canonical — per page, worst first. |
| `seo_report` | R | Everything about one page in one read-only result: outline, word count, meta tags, structured-data types, internal links in / out, image issues, the first paragraph, and focus-keyword checks. |
| `get_schema` | R | Structured data (JSON-LD) of a page: the editable blocks stored for it, and the types output automatically (site-wide Organization, breadcrumbs, FAQPage from FAQ blocks, Article on posts). |
| `update_schema` | W | Replace the JSON of a stored structured-data block, or switch it on / off. The JSON must be one schema.org object with @context and @type; {{base}} / {{site_url}} placeholders are allowed. |
| `delete_schema` | D | Move a stored structured-data block to the trash. |
| `generate_schema` | W | Build a structured-data block from the site's own data: Organization or LocalBusiness (settings), SoftwareApplication (with PKR offers from pricing_plans), Product, FAQPage, BreadcrumbList or Article. Returns the JSON; save=true stores it on the page. Never adds review / rating markup about our own business. Refuses a type the page already outputs. |
| `list_redirects` | R | List redirects (301 / 302) and gone URLs (410), with hit counts. "auto" ones were added when a slug changed. |
| `save_redirect` | W | Add or change a redirect: 301 (permanent), 302 (temporary) or 410 (gone, no target). Chains are shortened and loops refused. |
| `delete_redirect` | D | Move a redirect to the trash (the old URL then answers normally again, usually 404). |
| `validate_sitemap_robots` | R | Check sitemap.xml and robots.txt: every sitemap URL answers 200 and is indexable, no published page is missing, robots.txt rules, and whether site-wide noindex (SITE_NOINDEX) is on. |
| `update_robots` | W | Set the extra robots.txt lines added after the built-in rules (User-agent: * / Disallow: /enquiry). Only User-agent, Allow, Disallow, Crawl-delay, Sitemap and # comment lines. Empty text removes them. |

## Settings, enquiries & operations

| Tool | | What it does |
|---|---|---|
| `get_settings` | R | Site-wide settings: phone, WhatsApp, email, address, hours, trial sign-up link, header menu, footer columns and legal links, offer bar, default meta, rating, robots extras… with what each controls. |
| `update_settings` | W | Change one or more site settings: {key: value}. Lists (menu, footer, legal, enquiry_types, no_lead_form) must keep their shape — read them with get_settings first. |
| `list_enquiries` | R | Read-only list of website enquiries (demo / free-trial / contact forms): date, name, business, enquiry type, message and the page it came from. Phone numbers, emails and IP addresses are not returned; enquiries cannot be edited, deleted or exported here. |
| `list_trash` | R | Items in the trash (deleted pages, sections, posts, FAQs, images, …) that can be restored or purged. |
| `restore_item` | W | Bring an item back from the trash (page, section, post, FAQ, image, …) exactly as it was before it was deleted. |
| `purge_item` | D | Delete an item from the trash for good (cannot be undone). Images also lose their files. Needs confirm=true. |
| `activity_log` | R | Who changed what and when (newest first), with before / after values. |
| `clear_cache` | W | Clear the site's caches (settings, redirects, page analysis, compiled views) and purge Cloudflare when it is configured. |
| `audit_performance` | R | Page-weight check of a rendered page: HTML size, render time, images (count, total size, not lazy, not WebP, largest files), CSS / JS size and third-party scripts. |
| `get_site_info` | R | Overview: site URL, environment, whether search engines are blocked (SITE_NOINDEX), content counts, Cloudflare purge status, last change, and the number of tools. |
