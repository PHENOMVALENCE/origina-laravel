<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\Checkout;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopController
{
    public function index(Request $request): View
    {
        $request->validate(['q' => 'nullable|string|max:100', 'division' => 'nullable|string|max:50']);
        $products = Product::query()->where('published', true)->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->string('q').'%'))->when($request->filled('division'), fn ($q) => $q->where('division', $request->string('division')->toString()))->orderBy('name')->paginate(12)->withQueryString();

        return view('shop.index', compact('products'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->published, 404);

        return view('shop.product', compact('product'));
    }

    public function cart(Request $request): View
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();
        $subtotal = $products->sum(fn (Product $p) => $p->price * ($cart[$p->id] ?? 0));

        return view('shop.cart', compact('cart', 'products', 'subtotal'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate(['quantity' => 'required|integer|min:1|max:99']);
        $cart = $request->session()->get('cart', []);
        $quantity = ($cart[$product->id] ?? 0) + (int) $data['quantity'];
        if (! $product->published || $quantity > $product->stock || $quantity > 99 || (! isset($cart[$product->id]) && count($cart) >= 50)) {
            return back()->withErrors(['cart' => 'Requested quantity is not available.']);
        }
        $cart[$product->id] = $quantity;
        $request->session()->put('cart', $cart);

        return redirect()->route('cart')->with('status', 'Product added to your bag.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate(['quantity' => 'required|integer|min:0|max:99']);
        $cart = $request->session()->get('cart', []);
        if ((int) $data['quantity'] === 0) {
            unset($cart[$product->id]);
        } else {
            if (! $product->published || $product->stock < (int) $data['quantity']) {
                return back()->withErrors(['cart' => 'Requested quantity is unavailable.']);
            } $cart[$product->id] = (int) $data['quantity'];
        }
        $request->session()->put('cart', $cart);

        return back()->with('status', 'Bag updated.');
    }

    public function checkout(Request $request): View
    {
        $cart = $request->session()->get('cart', []);
        abort_if(! $cart, 400, 'Your bag is empty.');
        $products = Product::whereIn('id', array_keys($cart))->get();
        $subtotal = $products->sum(fn (Product $p) => $p->price * ($cart[$p->id] ?? 0));
        $key = $request->session()->get('checkout_key', (string) Str::uuid());
        if (Order::where('checkout_key', $key)->exists()) {
            $key = (string) Str::uuid();
        }
        $request->session()->put('checkout_key', $key);

        return view('shop.checkout', compact('cart', 'products', 'subtotal', 'key'));
    }

    public function place(Request $request, Checkout $checkout): RedirectResponse
    {
        $data = $request->validate(['name' => 'required|string|max:100', 'phone' => 'required|string|max:30', 'address' => 'required|string|max:500', 'city' => 'required|string|max:100', 'checkout_key' => 'required|uuid', 'consent' => 'accepted']);
        abort_unless(hash_equals((string) $request->session()->get('checkout_key', ''), $data['checkout_key']), 419);
        /** @var User $user */ $user = $request->user();
        $order = $checkout->place($user, $request->session()->get('cart', []), array_intersect_key($data, array_flip(['name', 'phone', 'address', 'city'])), $data['checkout_key']);
        $request->session()->forget('cart');

        return redirect()->route('account.orders.show', $order)->with('status', 'Order received. Payment is pending.');
    }
}
