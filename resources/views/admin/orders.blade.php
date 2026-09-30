@extends('layouts.portal')
@section('workspace','Operations')
@section('eyebrow','ORIGINA / Operations')
@section('title','Orders')
@section('heading','Every order, accounted for.')
@section('subtitle','Monitor payment, preparation and delivery from one place.')
@section('content')<form method="get" class="filter-row"><div class="field"><label for="status">Order status</label><select id="status" name="status"><option value="">All orders</option>@foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $status)<option @selected(request('status')===$status)>{{ $status }}</option>@endforeach</select></div><button class="button">Filter orders</button></form><section class="workspace-panel"><x-order-table :orders="$orders" admin/>{{ $orders->links() }}</section>@endsection
