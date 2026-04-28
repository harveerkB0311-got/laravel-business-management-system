<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        return response()->json(Invoice::with('client', 'items')->latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'due_date' => 'required|date',
            'tax' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0'
        ]);

        return DB::transaction(function () use ($validated) {
            $subtotal = 0;

            foreach ($validated['items'] as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $tax = $validated['tax'] ?? 0;
            $total = $subtotal + $tax;

            $invoice = Invoice::create([
                'client_id' => $validated['client_id'],
                'invoice_number' => 'INV-' . time(),
                'status' => 'unpaid',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'due_date' => $validated['due_date']
            ]);

            foreach ($validated['items'] as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['quantity'] * $item['unit_price']
                ]);
            }

            return response()->json([
                'message' => 'Invoice created successfully',
                'invoice' => $invoice->load('client', 'items')
            ], 201);
        });
    }

    public function show(Invoice $invoice)
    {
        return response()->json($invoice->load('client', 'items'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:unpaid,paid,cancelled',
            'due_date' => 'nullable|date'
        ]);

        $invoice->update($validated);

        return response()->json(['message' => 'Invoice updated successfully', 'invoice' => $invoice]);
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return response()->json(['message' => 'Invoice deleted successfully']);
    }
}
