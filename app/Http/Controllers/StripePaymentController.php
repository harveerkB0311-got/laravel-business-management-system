<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripePaymentController extends Controller
{
    public function checkout(Invoice $invoice)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'cad',
                    'product_data' => [
                        'name' => 'Invoice ' . $invoice->invoice_number,
                    ],
                    'unit_amount' => (int) ($invoice->total * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?invoice_id=' . $invoice->id,
            'cancel_url' => route('stripe.cancel'),
        ]);

        return response()->json(['checkout_url' => $session->url]);
    }

    public function success()
    {
        $invoice = Invoice::find(request('invoice_id'));

        if ($invoice) {
            $invoice->update(['status' => 'paid']);
        }

        return response()->json(['message' => 'Payment successful']);
    }

    public function cancel()
    {
        return response()->json(['message' => 'Payment cancelled']);
    }
}
