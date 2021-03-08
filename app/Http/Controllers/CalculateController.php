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
        $ema5 = collect(trader_ema($data, 5))->values()->last();
        $ema8 = collect(trader_ema($data, 8))->values()->last();
        $ema13 = collect(trader_ema($data, 13))->values()->last();

        return response()->json([
            'rsi_14' => $rsi14,
            'ema_9' => $ema9,
            'ema_26' => $ema26,
            'ema_5' => $ema5,
            'ema_8' => $ema8,
            'ema_13' => $ema13,
        ]);
    }


}
