@extends('layouts.auth')
@section('title','Reset password — ORIGINA')
@section('heading','Restore access.')
@section('intro','We will send a secure reset link to your registered email address.')
@section('form')<h2>Forgot your password?</h2><form method="post" action="{{ route('password.email') }}" class="form-stack">@csrf<x-field name="email" label="Email address" type="email" required autocomplete="email"/><button class="button">Send reset link</button></form><a href="{{ route('login') }}">Return to sign in</a>@endsection
