<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CalculateController extends Controller
{
    public function index(string $symbol, string $interval)
    {
        $items = 50;

        $data = Http::get("https://api.binance.com/api/v3/klines?symbol={$symbol}&interval={$interval}&limit={$items}")->json();
        $data = collect($data)->pluck(4)->values()->toArray();
        $rsi14 = collect(trader_rsi($data, 14))->values()->last();

        return response()->json([
            'rsi_14' => $rsi14
        ]);
    }


}
