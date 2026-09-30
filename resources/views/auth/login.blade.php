@extends('layouts.auth')
@section('title','Sign in — ORIGINA')
@section('heading','Welcome back.')
@section('intro','Your orders, product information and account, in one considered space.')
@section('form')<h2>Sign in to your account</h2><form action="{{ route('login') }}" method="post" class="form-stack">@csrf<x-field name="email" label="Email address" type="email" required autocomplete="email"/><x-field name="password" label="Password" type="password" required autocomplete="current-password"/><label class="checkbox"><input type="checkbox" name="remember" value="1">Remember me</label><button class="button">Sign in →</button></form><p><a href="{{ route('password.request') }}">Forgot your password?</a></p><p>New to ORIGINA? <a href="{{ route('register') }}">Create an account</a></p>@endsection
