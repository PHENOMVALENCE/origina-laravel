# Asset & CDN Delivery

## Principles

ORIGINA owns and serves its approved brand, founder and product media. Production views must not hotlink assets from GitHub or arbitrary third-party image hosts.

Laravel's `asset()` helper is the only public URL boundary for repository-managed static media. This keeps templates independent of the final origin/CDN topology.

## Asset origins

### Vite-managed assets

`resources/css/app.css` and `resources/js/app.js` are built by Vite and loaded with `@vite`. Production output is content-hashed and should receive long-lived immutable caching.

### Public editorial assets

Brand marks, favicon, founder photography and current product imagery live under `public/`.

Templates should reference these through `asset()`, for example:

```blade
<img src="{{ asset('img/brand/origina-mark.png') }}" alt="">
```

Do not hard-code production hostnames.

## CDN support

Laravel reads the optional `ASSET_URL` environment value through `config('app.asset_url')`.

Example:

```dotenv
APP_URL=https://www.origina.example
ASSET_URL=https://cdn.origina.example
```

When `ASSET_URL` is empty, assets are served from the application origin. This is the correct local-development default.

A CDN is an infrastructure optimization, not a code dependency. The frontend must work correctly without one.

## CDN requirements

A production CDN should:

- use HTTPS only;
- preserve correct `Content-Type` headers;
- cache fingerprinted Vite assets for a long duration with `immutable`;
- cache versioned/static public media aggressively while allowing controlled invalidation;
- support Brotli/Gzip for text assets;
- avoid transforming scientific/product photography in ways that alter meaning;
- preserve CORS behavior required by fonts or future media pipelines;
- expose no private origin credentials.

Do not place dynamic authenticated HTML behind a public cache without an explicit caching design.

## Image standards

Use one of the approved structural ratios:

- 16:9 — cinematic;
- 4:3 — editorial;
- 3:4 — portrait;
- 3:2 — feature;
- 1:1 — square.

Rules:

- include intrinsic width and height;
- use accurate alt text;
- captions describe context, not marketing hype;
- hero images may use eager/high fetch priority;
- below-the-fold images use `loading="lazy"`;
- use `decoding="async"`;
- avoid decorative duplication of the same image on one viewport;
- never use remote placeholders in production;
- optimize source files before commit.

For future high-volume media, consider a dedicated image pipeline that creates AVIF/WebP derivatives while retaining an archival original. That pipeline should be introduced as infrastructure, not scattered template logic.

## Fonts

Current public typography uses Source Serif 4 and Source Sans 3 from Google Fonts.

For maximum privacy/performance control, self-hosting approved font files may be evaluated before production launch. Do not commit unlicensed font binaries or redistribute font files through chat/artifacts.

## Cache invalidation

Prefer filename/version changes over blanket CDN purges. Vite already fingerprints bundled assets. For `public/img` files, replace filenames when a materially different asset must coexist with old caches, or issue targeted invalidation at deployment.

## Validation

Before release:

- verify `ASSET_URL` is either empty or the intended HTTPS CDN;
- inspect network requests for mixed content or GitHub hotlinks;
- verify no 404s for favicon, CSS, JS or public imagery;
- verify hero and lazy-image behavior at mobile and desktop widths;
- confirm cache policy at the CDN/origin layer.
