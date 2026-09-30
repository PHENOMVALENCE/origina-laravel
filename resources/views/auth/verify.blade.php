@extends('layouts.auth')
@section('title','Verify email — ORIGINA')
@section('heading','One final step.')
@section('intro','Verify your email to access checkout and your ORIGINA account.')
@section('form')<h2>Check your inbox</h2><p>Follow the verification link sent to {{ auth()->user()->email }}.</p><form method="post" action="{{ route('verification.send') }}">@csrf<button class="button">Resend verification email</button></form><form method="post" action="{{ route('logout') }}">@csrf<button class="text-button">Sign out</button></form>@endsection
