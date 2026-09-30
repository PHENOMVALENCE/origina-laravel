@extends('layouts.portal')
@section('workspace','Operations')
@section('eyebrow','ORIGINA / Operations')
@section('title','Audit trail')
@section('heading','A record of responsibility.')
@section('subtitle','Operational changes are recorded with their actor and time.')
@section('content')<section class="workspace-panel"><div class="table-scroll"><table class="data-table"><thead><tr><th>Time (UTC)</th><th>Actor ID</th><th>Action</th><th>Record</th><th>Details</th></tr></thead><tbody>@forelse($logs as $log)<tr><td>{{ $log->created_at->format('d M Y H:i:s') }}</td><td>{{ $log->user_id??'System' }}</td><td>{{ $log->action }}</td><td>{{ class_basename($log->subject_type) }} #{{ $log->subject_id }}</td><td><details><summary>View changes</summary><pre>{{ json_encode($log->changes,JSON_PRETTY_PRINT) }}</pre></details></td></tr>@empty<tr><td colspan="5">No operational changes recorded yet.</td></tr>@endforelse</tbody></table></div>{{ $logs->links() }}</section>@endsection
