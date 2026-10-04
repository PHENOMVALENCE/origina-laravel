<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Audit;
use App\Services\OrderWorkflow;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AccountController
{
    public function dashboard(Request $request): View
    {
        $query = Order::where('user_id', $request->user()->id);

        return view('account.dashboard', ['orders' => (clone $query)->latest()->limit(5)->get(), 'orderCount' => (clone $query)->count(), 'activeCount' => (clone $query)->whereNotIn('status', ['delivered', 'cancelled'])->count(), 'totalSpent' => (clone $query)->where('payment_status', 'paid')->sum('total')]);
    }

    public function orders(Request $request): View
    {
        return view('account.orders', ['orders' => Order::where('user_id', $request->user()->id)->latest()->paginate(15)]);
    }

    public function order(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 404);

        return view('account.order', ['order' => $order->load('items')]);
    }

    public function cancel(Request $request, Order $order, OrderWorkflow $workflow): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 404);
        $workflow->transition($order, 'cancelled');

        return back()->with('status', 'Order cancelled and inventory released.');
    }

    public function profile(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => 'required|string|max:100', 'current_password' => 'required|current_password', 'password' => ['nullable', 'confirmed', Password::min(12)->letters()->numbers()]]);
        $user = $request->user();
        $nameChanged = $user->name !== $data['name'];
        $passwordChanged = ! empty($data['password']);
        $user->name = $data['name'];
        if ($passwordChanged) {
            $user->password = $data['password'];
            $user->tokens()->delete();
        }
        $user->save();
        if ($nameChanged) {
            Audit::record('user.profile_updated', $user, ['name_changed' => true]);
        }
        if ($passwordChanged) {
            Audit::record('user.password_changed', $user, ['api_tokens_revoked' => true]);
        }
        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return back()->with('status', 'Profile updated.');
    }
}
