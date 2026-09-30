<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Services\Audit;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PublicationController
{
    public function index(): View
    {
        return view('shop.updates', ['publications' => Publication::where('status', 'published')->where('published_at', '<=', now())->latest('published_at')->paginate(12)]);
    }

    public function show(Publication $publication): View
    {
        abort_unless($publication->status === 'published' && $publication->published_at?->isPast(), 404);

        return view('shop.publication', compact('publication'));
    }

    public function admin(): View
    {
        return view('admin.publications', ['publications' => Publication::latest()->paginate(20)]);
    }

    public function form(?Publication $publication = null): View
    {
        return view('admin.publication-form', ['publication' => $publication ?? new Publication]);
    }

    public function save(Request $request, ?Publication $publication = null): RedirectResponse
    {
        $data = $request->validate(['title' => 'required|string|max:200', 'slug' => ['required', 'max:220', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('publications', 'slug')->ignore($publication?->id)], 'type' => 'required|in:news,research,update', 'summary' => 'required|string|max:1000', 'body' => 'required|string|max:50000', 'status' => 'required|in:draft,published', 'reviewed' => 'accepted']);
        unset($data['reviewed']);
        $data['editor_id'] = $request->user()->id;
        $data['published_at'] = $data['status'] === 'published' ? (($publication ? $publication->published_at : null) ?? now()) : null;
        DB::transaction(function () use ($publication, $data): void {
            if ($publication?->exists) {
                $publication->update($data);
            } else {
                $publication = Publication::create($data);
            } Audit::record('publication.saved', $publication, ['status' => $publication->status]);
        });

        return redirect()->route('admin.publications')->with('status', 'Publication record saved.');
    }
}
