# API testing and Swagger

Contract: [`openapi.json`](openapi.json), OpenAPI 3.0.3. Runtime routes: `routes/api.php`. Swagger UI is a separate local Vite bundle loaded only in `/admin/api-docs`; public shoppers do not download it.

## Authentication

Sign in to the administrator web workspace to open Swagger. Send `POST /api/v1/tokens` with email, password and device_name for a verified active account. The returned token expires after eight hours. Paste it into Authorize as a bearer token. Do not commit or share tokens, and do not save them in Swagger authorization persistence. `DELETE /api/v1/tokens/current` revokes the current token. Password changes/reset and account deactivation revoke existing tokens.

API bearer authentication is independent of the web session. Customer tokens cannot operate administrator routes; administrators do not bypass ownership on customer-specific routes and should use `/admin/orders` to inspect all orders.

## Endpoints

| Method | Path under `/api/v1` | Access |
|---|---|---|
| POST | `/tokens` | credentials, active verified account, identity throttling |
| GET | `/products`, `/products/{id}` | public, published catalogue only |
| GET | `/me` | bearer account |
| DELETE | `/tokens/current` | bearer account |
| GET | `/orders`, `/orders/{id}` | own orders only |
| POST | `/orders` | place unpaid order |
| POST | `/orders/{id}/cancel` | cancel own pending unpaid order |
| GET, POST | `/admin/products` | administrator |
| PUT | `/admin/products/{id}` | administrator |
| GET | `/admin/orders` | administrator |
| PATCH | `/admin/orders/{id}` | administrator lifecycle update |
| POST | `/admin/orders/{id}/payment` | administrator receipt confirmation |

Manufacturing, people, enquiry and publication management additionally have CSRF-protected web forms and integration tests; they are not exposed as generic JSON CRUD endpoints in this release. Test them through the administrator UI. QR print/export routes are private web routes.

## Checkout example

```json
{
  "items": [{"product_id": 1, "quantity": 1}],
  "shipping_address": {"name": "Test Customer", "phone": "+255700000000", "address": "Staging address", "city": "Dar es Salaam"},
  "checkout_key": "ab7ecf94-b6e4-4f87-96a2-7174d26ec6ad",
  "consent": true
}
```

Use existing staging product IDs. Generate a new UUID for each new purchase; reuse the same key only to retry the same purchase. Never supply trusted price/payment/status fields from a client. The response is an unpaid order with server-generated totals.

`401`: no valid token. `403`: insufficient role/inactive/unverified identity. `404`: record missing or not owned/published. `422`: validation, stock or lifecycle failure. `429`: throttled. Lists paginate at 20 records, with `page` navigation.

## Required regression cases

Test expired/revoked tokens, unverified accounts, cross-customer order IDs, unpublished products, insufficient stock, duplicate checkout keys, paid cancellation, invalid status jumps and duplicate receipt references. Automated coverage is in `tests/Feature/PlatformTest.php`; OpenAPI path coverage is checked against the route registry.
