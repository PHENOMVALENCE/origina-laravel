@extends('layouts.portal')
@section('workspace','Operations')
@section('eyebrow','ORIGINA / Operations')
@section('title','API laboratory')
@section('heading','Explore the API.')
@section('subtitle','Test catalogue, account, order and administrator endpoints against this environment.')
@section('content')<div class="notice">Requests change real records in this environment. Use a staging database for testing. Obtain a short-lived token using POST /api/v1/tokens, then paste it into Authorize. Tokens are not saved by this interface.</div><div id="swagger-ui" data-spec-url="{{ route('admin.openapi') }}"></div>@push('head')@vite(['resources/js/swagger.js'])@endpush
@endsection
