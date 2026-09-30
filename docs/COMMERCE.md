# Shopping and order operations

## Customer journey

1. Explore `/shop`, search by name and filter by division.
2. Read a product's description, ingredients, use guidance and evidence note.
3. Add available quantities to the bag. Adjust or remove with quantity zero.
4. Sign in/register and verify email before checkout.
5. Supply recipient name, phone, address and city. Review delivery fee, total and payment instructions.
6. Accept terms and place an unpaid order. The backend rechecks publication, stock, prices and configured delivery fee.
7. View the recorded order immediately in the customer dashboard. An order-received notification is attempted after commit.
8. Arrange payment under confirmed instructions. An administrator reconciles and records the unique receipt reference.
9. Follow confirmation, preparation, dispatch reference and delivery in order history.

## Order lifecycle

| Current state | Allowed next state | Conditions |
|---|---|---|
| pending | confirmed | payment recorded as paid |
| pending | cancelled | unpaid; reserved stock returned |
| confirmed | processing | paid confirmation already established |
| processing | shipped | dispatch/tracking reference required |
| shipped | delivered | explicit administrator action |
| delivered / cancelled | none | terminal |

Customer cancellation uses the same workflow service as admin/API operations. Paid cancellation is blocked until a proper refund process exists. Do not mark an order cancelled externally without reconciling receipt and stock.

## Money and inventory

Money uses whole Tanzanian shillings (`TZS`) in unsigned integer columns. Product maximum price is TZS 100,000,000; order lines have maximum quantity 99 and checkout has at most 50 products. Client totals are ignored. Order item names, SKUs and prices are snapshots; later product changes do not rewrite history.

Stock is available inventory after reservations. Placing orders reduces available stock immediately. Pending orders do not automatically expire; administrators should review stale unpaid reservations and cancel only after checking payment status. This release does not auto-release potentially paid but unreconciled orders.

Do not publish fabricated products or prices. No production seed creates saleable records. Catalogue visibility and checkout availability are separate: `COMMERCE_CHECKOUT_ENABLED=false` stops placement while allowing discovery.

## Configuration and limitations

`COMMERCE_SHIPPING_FEE` is one nonnegative whole-TZS delivery fee. It is not a carrier estimate or multi-zone tariff. Approve the supported delivery area before enabling checkout. Taxes are not calculated separately; publish only approved final consumer prices and commercial terms.

`COMMERCE_PAYMENT_INSTRUCTIONS` must name actual approved payment steps. Do not publish account information until verified by the business owner. Online payment provider checkout, signed callbacks/webhooks, automated reconciliation, refunds, discounts, variants and carrier APIs are future integrations rather than simulated features.
