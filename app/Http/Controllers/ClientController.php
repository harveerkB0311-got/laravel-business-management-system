<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return response()->json(Client::latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string'
        ]);

        $client = Client::create($validated);

        return response()->json(['message' => 'Client created successfully', 'client' => $client], 201);
    }

    public function show(Client $client)
    {
        return response()->json($client->load('invoices'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string'
        ]);

        $client->update($validated);

        return response()->json(['message' => 'Client updated successfully', 'client' => $client]);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(['message' => 'Client deleted successfully']);
    }
}
