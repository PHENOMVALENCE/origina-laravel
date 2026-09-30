@extends('layouts.portal')
@section('workspace','Operations')
@section('eyebrow','ORIGINA / Operations')
@section('title','Enquiries')
@section('heading','Conversations worth following.')
@section('subtitle','Review incoming enquiries and keep their progress visible.')
@section('content')@forelse($enquiries as $enquiry)<article class="workspace-panel"><div class="section-top"><div><p class="eyebrow">{{ $enquiry->topic }}</p><h2>{{ $enquiry->name }}</h2><p>{{ $enquiry->email }} · {{ $enquiry->created_at->format('d M Y') }}</p></div><span class="badge">{{ str_replace('_',' ',$enquiry->status) }}</span></div><p class="preserve-lines">{{ $enquiry->message }}</p><form method="post" action="{{ route('admin.enquiries.update',$enquiry) }}" class="inline-form">@csrf @method('patch')<select name="status" aria-label="Status for enquiry from {{ $enquiry->name }}">@foreach(['new','in_progress','closed'] as $status)<option @selected($enquiry->status===$status)>{{ $status }}</option>@endforeach</select><button class="button">Save progress</button></form></article>@empty<div class="workspace-panel empty-state">No enquiries received yet.</div>@endforelse{{ $enquiries->links() }}@endsection
