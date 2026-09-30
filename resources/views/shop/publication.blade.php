@extends('layouts.site')
@section('title',$publication->title.' — ORIGINA')
@section('description',Str::limit($publication->summary,155))
@section('content')<article class="site-shell commerce-page form-measure"><a href="{{ route('updates') }}">← Updates</a><p class="eyebrow">{{ $publication->type }} · {{ $publication->published_at->format('d M Y') }}</p><h1>{{ $publication->title }}</h1><p><strong>{{ $publication->summary }}</strong></p><div class="preserve-lines">{{ $publication->body }}</div></article>@endsection
