@extends('layouts.portal')
@section('title','Profile & security')
@section('heading','Your account details.')
@section('subtitle','Keep your profile current and your account secure.')
@section('content')<section class="workspace-panel form-measure"><h2>Profile & password</h2><p>Verified email: {{ auth()->user()->email }}. Contact support if it needs to change.</p><form method="post" action="{{ route('account.profile.update') }}" class="form-stack">@csrf @method('patch')<x-field name="name" label="Full name" :value="auth()->user()->name" required/><x-field name="current_password" label="Current password" type="password" required autocomplete="current-password"/><x-field name="password" label="New password (optional)" type="password" autocomplete="new-password" minlength="12"/><x-field name="password_confirmation" label="Confirm new password" type="password" autocomplete="new-password"/><button class="button">Save changes</button></form></section>@endsection
