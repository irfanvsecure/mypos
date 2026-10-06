<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('sort')->orderBy('name')->get();

        return view('clients.index', compact('clients'));
    }

    public function show(string $slug)
    {
        $client = Client::where('slug', $slug)->firstOrFail();
        $others = Client::where('id', '!=', $client->id)->inRandomOrder()->limit(6)->get();

        return view('clients.show', compact('client', 'others'));
    }
}
