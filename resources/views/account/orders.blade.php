@extends('layouts.portal')
@section('title','My orders')
@section('heading','Your order history.')
@section('subtitle','Follow each order from placement to delivery.')
@section('content')<section class="workspace-panel"><x-order-table :orders="$orders"/>{{ $orders->links() }}</section>@endsection
