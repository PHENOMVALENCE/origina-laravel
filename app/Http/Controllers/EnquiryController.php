<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Services\Audit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EnquiryController
{
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'name' => trim((string) $request->input('name')),
            'email' => Str::lower(trim((string) $request->input('email'))),
            'topic' => trim((string) $request->input('topic')),
            'message' => trim((string) $request->input('message')),
        ]);

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:254',
            'topic' => 'required|in:Scientific Collaboration,Manufacturing & Development,Investment,Brand & Commercial,Media & Education,Customer Support',
            'message' => 'required|string|min:20|max:5000',
            'consent' => 'accepted',
            'website' => 'nullable|max:0',
        ]);

        DB::transaction(function () use ($data): void {
            $enquiry = Enquiry::create(array_intersect_key($data, array_flip(['name', 'email', 'topic', 'message'])) + ['consented_at' => now()]);
            Audit::record('enquiry.received', $enquiry, ['topic' => $enquiry->topic]);
        });

        return back()->with('status', 'Your enquiry has been received by ORIGINA.');
    }
}
