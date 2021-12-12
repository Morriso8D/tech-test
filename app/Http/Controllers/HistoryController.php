<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;


class HistoryController extends Controller
{
    public function index(Request $request)
    {

        $transactions = Transaction::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return Inertia::render('History', [
            'transactions' => $transactions
        ]);
    }
}
