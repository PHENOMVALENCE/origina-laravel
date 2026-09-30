<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EnquiryController
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => 'required|string|max:100', 'email' => 'required|email|max:254', 'topic' => 'required|in:Scientific Collaboration,Manufacturing & Development,Investment,Brand & Commercial,Media & Education,Customer Support', 'message' => 'required|string|min:20|max:5000', 'consent' => 'accepted', 'website' => 'nullable|max:0']);
        Enquiry::create(array_intersect_key($data, array_flip(['name', 'email', 'topic', 'message'])) + ['consented_at' => now()]);

        return back()->with('status', 'Your enquiry has been received by ORIGINA.');
    }
}
