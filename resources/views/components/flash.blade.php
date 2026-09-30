@if(session('status'))<div class="notice notice--success" role="status">{{ session('status') }}</div>@endif
@if($errors->any())<div class="notice notice--error" role="alert"><strong>Please review the following:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
