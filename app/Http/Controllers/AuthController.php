<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function register(Request $request): RedirectResponse
    {
        $request->merge(['email' => Str::lower($request->string('email')->toString())]);
        $data = $request->validate(['name' => 'required|string|max:100', 'email' => 'required|email|max:254|unique:users,email', 'password' => ['required', 'confirmed', PasswordRule::min(12)->letters()->numbers()], 'consent' => 'accepted']);
        $user = User::create(['name' => $data['name'], 'email' => Str::lower($data['email']), 'password' => $data['password']]);
        event(new Registered($user));
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('verification.notice');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate(['email' => 'required|email', 'password' => 'required|string']);
        if (! Auth::attempt(['email' => Str::lower($data['email']), 'password' => $data['password'], 'active' => true], $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'The supplied credentials are incorrect.']);
        }
        $request->session()->regenerate();

        return redirect()->intended(route('account.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function forgot(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);
        Password::sendResetLink(['email' => Str::lower($request->string('email')->toString())]);

        return back()->with('status', 'If an account exists, a reset link will be sent.');
    }

    public function reset(Request $request): RedirectResponse
    {
        $data = $request->validate(['token' => 'required', 'email' => 'required|email', 'password' => ['required', 'confirmed', PasswordRule::min(12)->letters()->numbers()]]);
        $status = Password::reset($data, function (User $user, string $password): void {
            $user->forceFill(['password' => $password, 'remember_token' => Str::random(60)])->save();
            $user->tokens()->delete();
            event(new PasswordReset($user));
        });
        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages(['email' => __($status)]);
        }

        return redirect()->route('login')->with('status', 'Password reset. Sign in with your new password.');
    }

    public function token(Request $request): JsonResponse
    {
        $data = $request->validate(['email' => 'required|email', 'password' => 'required|string', 'device_name' => 'required|string|max:100']);
        $user = User::where('email', Str::lower($data['email']))->first();
        if (! $user || ! $user->active || ! Hash::check($data['password'], $user->password) || ! $user->hasVerifiedEmail()) {
            throw ValidationException::withMessages(['email' => 'Valid credentials and a verified active account are required.']);
        }

        return response()->json(['token' => $user->createToken($data['device_name'], ['*'], now()->addHours(8))->plainTextToken, 'expires_in' => 28800]);
    }
}
