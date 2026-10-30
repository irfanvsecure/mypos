<?php

namespace App\Http\Controllers;

use App\Mail\NewEnquiry;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot: bots fill the hidden "website" field — pretend success, store nothing.
        if ($request->filled('website')) {
            return redirect()->route('thank-you');
        }

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'business' => ['nullable', 'string', 'max:160'],
            'phone'    => ['required', 'string', 'max:40', 'regex:/^[0-9+\-\s()]{7,}$/'],
            'email'    => ['nullable', 'email', 'max:160'],
            'type'     => ['nullable', 'string', 'max:60'],
            'message'  => ['nullable', 'string', 'max:3000'],
            'page'     => ['nullable', 'string', 'max:255'],
        ], [
            'phone.regex' => 'Please enter a valid phone number.',
        ]);

        $lead = Lead::create($data + [
            'referrer' => substr((string) $request->headers->get('referer'), 0, 500),
            'ip'       => $request->ip(),
        ]);

        try {
            Mail::to(config('site.leads_email'))->send(new NewEnquiry($lead));
        } catch (\Throwable $e) {
            Log::warning('Enquiry email failed: ' . $e->getMessage(), ['lead' => $lead->id]);
        }

        // The "lead" flash fires the Meta Pixel Lead event once; a refresh or direct visit won't count again.
        return redirect()->route('thank-you')->with('lead', true);
    }
}
