<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'reference' => 'required|string|min:8|max:255',
            'amount' => 'required|numeric',
            'currency' => 'required|in:GBP,EUR,USD'
        ]);

        $checkoutId = app()->make('CopyAndPay\InitCheckout')->send($request);

        if(empty($checkoutId)) abort(500, 'Failed to fetch checkoutId');

        return redirect()->route('dashboard')->with('checkoutId', $checkoutId);
    }

    public function results(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'resourcePath' => 'required',
        ]);

        $paymentStatus = app()->make('CopyAndPay\PaymentStatus')->send($request);

        $transaction = Transaction::create([
            'amount' => $paymentStatus->amount,
            'result_code' => $paymentStatus->result->code, 
            'result_description' => $paymentStatus->result->description, 
            'reference' => $paymentStatus->merchantTransactionId,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('transaction', $transaction);
    }
}
