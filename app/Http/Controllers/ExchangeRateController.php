<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExchangeRate;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $exchangeRates = ExchangeRate::orderBy('effective_date', 'desc')->paginate(10);
        return view('exchange_rates.index', compact('exchangeRates'));
    }

    public function create()
    {
        return view('exchange_rates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'exchange_rate' => 'required|numeric|min:0',
            'effective_date' => 'required|date',
        ]);

        ExchangeRate::create([
            'exchange_rate' => $request->exchange_rate,
            'effective_date' => $request->effective_date,
        ]);

        return redirect()->route('exchange-rates.index')->with('success', 'Exchange rate updated successfully.');
    }
}
