@extends('layouts.portal')
@section('title','Publications')
@section('heading','The institutional record.')
@section('subtitle','Draft, review and publish news, research and updates.')
@section('content')<div class="section-top"><h2>Publications</h2><a href="{{ route('admin.publications.create') }}" class="button">New record +</a></div><section class="workspace-panel"><div class="table-scroll"><table class="data-table"><thead><tr><th>Title</th><th>Type</th><th>Status</th><th>Manage</th></tr></thead><tbody>@forelse($publications as $publication)<tr><td>{{ $publication->title }}</td><td>{{ $publication->type }}</td><td>{{ $publication->status }}</td><td><a href="{{ route('admin.publications.edit',$publication) }}">Edit →</a></td></tr>@empty<tr><td colspan="4">No publication records yet.</td></tr>@endforelse</tbody></table></div>{{ $publications->links() }}</section>@endsection
