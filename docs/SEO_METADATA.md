# SEO & Metadata

## Server-rendered baseline

All public pages are rendered by Laravel and expose meaningful HTML without requiring client-side JavaScript.

The shared site layout provides:

- page title;
- meta description;
- canonical URL;
- Open Graph title, description, URL, image and site name;
- Twitter summary-large-image metadata;
- favicon;
- robots policy.

Every content definition must include a unique `title` and `description`.

## Canonical URLs

Canonical URLs are derived from `url()->current()`. Production must therefore set `APP_URL` to the canonical public HTTPS origin and configure trusted proxy/host behavior correctly at deployment.

Do not use a CDN asset hostname as the application `APP_URL`.

## Robots

`/robots.txt` is environment-aware:

- production: public crawling allowed and sitemap advertised;
- non-production: crawling disallowed.

Preview/staging systems must remain non-indexable unless explicitly approved.

## Sitemap

`/sitemap.xml` is generated from the actual frontend content registry plus dedicated public views. Adding a config-driven public page therefore updates the sitemap through the same source of truth.

The sitemap must not include admin, health, preview, private or unimplemented backend routes.

## Social sharing image

The shared layout currently uses approved ORIGINA institutional photography as the fallback social image. Pages may override the social image when a route has a more representative approved visual.

Future dynamic OG-image generation is optional and should not be introduced unless it improves a real publishing workflow.

## Structured data

Do not fabricate schema.org claims, awards, medical organization classifications, products, reviews, research results or regulatory status.

Structured data may be introduced later for facts that are documented and stable, such as:

- Organization;
- WebSite;
- BreadcrumbList;
- Article/NewsArticle for published institutional updates;
- Product only after approved product/catalogue data exists.

## Content requirements

SEO never outranks scientific accuracy. Titles and descriptions must not strengthen preliminary research, imply clinical proof, claim patents, or imply regulatory approval beyond available evidence.

## Release checks

- production `APP_URL` is correct and HTTPS;
- canonical URLs use the intended host;
- staging is noindex/disallowed;
- sitemap responds as XML and includes every intended public route;
- robots advertises the production sitemap;
- title/description are unique and useful;
- social images load through the approved asset origin/CDN;
- no placeholder routes are indexable.
