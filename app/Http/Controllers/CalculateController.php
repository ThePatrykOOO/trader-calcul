<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CalculateController extends Controller
{
    public function index(Request $request)
    {
        $items = 30;

        $symbol = $request->get('symbol');
        $interval = $request->get('interval');

        $data = Http::get("https://api.binance.com/api/v3/klines?symbol={$symbol}&interval={$interval}&limit={$items}")->json();
        $data = collect($data)->pluck(4)->values()->toArray();
        $rsi14 = collect(trader_rsi($data, 14))->values()->slice(-2,1)->last();
        $ema9 = collect(trader_ema($data, 9))->values()->slice(-2,1)->last();
        $ema26 = collect(trader_ema($data, 26))->values()->slice(-2,1)->last();

        return response()->json([
            'rsi_14' => $rsi14,
            'ema_9' => $ema9,
            'ema_26' => $ema26
        ]);
    }


}
