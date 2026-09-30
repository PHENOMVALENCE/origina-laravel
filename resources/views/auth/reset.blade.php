@extends('layouts.auth')
@section('title','Choose password — ORIGINA')
@section('heading','A fresh start.')
@section('intro','Choose a strong password to protect your account.')
@section('form')<h2>Set a new password</h2><form method="post" action="{{ route('password.update') }}" class="form-stack">@csrf<input type="hidden" name="token" value="{{ $token }}"><x-field name="email" label="Email address" type="email" :value="$email" required autocomplete="email"/><x-field name="password" label="New password" type="password" required minlength="12" autocomplete="new-password"/><x-field name="password_confirmation" label="Confirm password" type="password" required autocomplete="new-password"/><button class="button">Reset password</button></form>@endsection
