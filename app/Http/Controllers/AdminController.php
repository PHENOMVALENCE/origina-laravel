<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\AuditLog;
use App\Models\Enquiry;
use App\Models\ManufacturingBatch;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\User;
use App\Services\Audit;
use App\Services\OrderWorkflow;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminController
{
    public function dashboard(): View
    {
        return view('admin.dashboard', ['revenue' => Order::where('payment_status', 'paid')->sum('total'), 'pending' => Order::where('status', 'pending')->count(), 'customerCount' => User::where('role', 'customer')->count(), 'lowStock' => Product::where('published', true)->where('stock', '<=', 5)->orderBy('stock')->limit(8)->get(), 'orders' => Order::with('user')->latest()->limit(7)->get(), 'enquiryCount' => Enquiry::where('status', 'new')->count(), 'stages' => Order::selectRaw('status, COUNT(*) AS aggregate')->groupBy('status')->pluck('aggregate', 'status')]);
    }

    public function products(Request $request): View
    {
        return view('admin.products', ['products' => Product::query()->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->string('q').'%'))->latest()->paginate(20)->withQueryString()]);
    }

    public function productForm(?Product $product = null): View
    {
        return view('admin.product-form', ['product' => $product ?? new Product]);
    }

    public function productSave(ProductRequest $request, ?Product $product = null): RedirectResponse
    {
        $data = $request->validated();
        unset($data['image']);
        if (empty($data['image_path'])) {
            unset($data['image_path']);
        }
        if (! empty($data['image_path']) && ! is_file(public_path($data['image_path']))) {
            throw ValidationException::withMessages(['image_path' => 'Select an existing product image.']);
        }
        if ($request->hasFile('image')) {
            $data['image_path'] = 'storage/'.$request->file('image')->store('products', 'public');
        }
        DB::transaction(function () use ($product, $data): void {
            // Lock inventory edits against checkout; stock is available stock, not ordered stock.
            if ($product?->exists) {
                $product = Product::whereKey($product->id)->lockForUpdate()->firstOrFail();
                $product->update($data);
            } else {
                $product = Product::create($data);
            }
            Audit::record('product.saved', $product, ['price' => $product->price, 'stock' => $product->stock, 'published' => $product->published]);
        });

        return redirect()->route('admin.products')->with('status', 'Catalogue record saved.');
    }

    public function archive(Product $product): RedirectResponse
    {
        DB::transaction(function () use ($product): void {
            $product = Product::whereKey($product->id)->lockForUpdate()->firstOrFail();
            $product->update(['published' => false]);
            Audit::record('product.archived', $product);
        });

        return back()->with('status', 'Product removed from sale. Historical orders are preserved.');
    }

    public function orders(Request $request): View
    {
        $request->validate(['status' => 'nullable|in:pending,confirmed,processing,shipped,delivered,cancelled']);

        return view('admin.orders', ['orders' => Order::with('user')->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))->latest()->paginate(20)->withQueryString()]);
    }

    public function order(Order $order): View
    {
        return view('admin.order', ['order' => $order->load('items', 'user')]);
    }

    public function transition(Request $request, Order $order, OrderWorkflow $workflow): RedirectResponse
    {
        $data = $request->validate(['status' => 'required|in:confirmed,processing,shipped,delivered,cancelled', 'tracking_reference' => 'nullable|string|max:150']);
        $workflow->transition($order, $data['status'], $data['tracking_reference'] ?? null);

        return back()->with('status', 'Order status updated.');
    }

    public function payment(Request $request, Order $order, OrderWorkflow $workflow): RedirectResponse
    {
        $data = $request->validate(['payment_reference' => 'required|string|max:150|unique:orders,payment_reference', 'confirm' => 'accepted']);
        $workflow->confirmPayment($order, $data['payment_reference']);

        return back()->with('status', 'Payment receipt recorded.');
    }

    public function customers(Request $request): View
    {
        return view('admin.customers', ['users' => User::query()->when($request->filled('q'), fn ($q) => $q->where(function ($q) use ($request): void {
            $q->where('name', 'like', '%'.$request->string('q').'%')->orWhere('email', 'like', '%'.$request->string('q').'%');
        }))->latest()->paginate(20)->withQueryString()]);
    }

    public function user(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate(['role' => 'required|in:customer,admin', 'active' => 'required|boolean']);
        abort_if($user->id === $request->user()->id, 422, 'You cannot change your own access.');
        DB::transaction(function () use ($user, $data): void {
            // Serialize access edits across all administrator accounts.
            User::where('role', 'admin')->orderBy('id')->lockForUpdate()->get();
            $user = User::whereKey($user->id)->lockForUpdate()->firstOrFail();
            $user->forceFill($data)->save();
            if (! $user->active || $user->role !== 'admin') {
                $user->tokens()->delete();
            }
            Audit::record('user.access_updated', $user, $data);
        }, 3);

        return back()->with('status', 'Account access updated.');
    }

    public function enquiries(): View
    {
        return view('admin.enquiries', ['enquiries' => Enquiry::latest()->paginate(20)]);
    }

    public function enquiry(Request $request, Enquiry $enquiry): RedirectResponse
    {
        $data = $request->validate(['status' => 'required|in:new,in_progress,closed']);
        DB::transaction(function () use ($enquiry, $data): void {
            $enquiry->update($data);
            Audit::record('enquiry.updated', $enquiry, $data);
        });

        return back()->with('status', 'Enquiry updated.');
    }

    public function audit(): View
    {
        return view('admin.audit', ['logs' => AuditLog::latest()->paginate(30)]);
    }

    public function batches(): View
    {
        return view('admin.batches', ['batches' => ManufacturingBatch::with('product')->latest()->paginate(20), 'products' => Product::orderBy('name')->get()]);
    }

    public function batch(ManufacturingBatch $batch): View
    {
        return view('admin.batch', ['batch' => $batch->load('product'), 'units' => ProductUnit::where('manufacturing_batch_id', $batch->id)->paginate(50)]);
    }
}
