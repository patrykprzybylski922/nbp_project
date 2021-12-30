<?php

namespace App\Http\Controllers\Api;

use App\Currency;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    public function calcCurrencyRates($code, $value)
    {
        if(!is_numeric($value)){
            return response()->json([
                'error' => 'Niepoprawna wartosc.'
            ], 404);
        }

        $currency = Currency::where('code', $code)->first();

        if(!empty($currency)){
            $mid_value = $currency->mid * $value;
            $bid_value = $currency->bid * $value;
            $ask_value = $currency->ask * $value;

            return response()->json([
                'mid' => number_format((float)$mid_value, 4, '.', '') . ' PLN',
                'bid' => number_format((float)$bid_value, 4, '.', '') . ' PLN',
                'ask' => number_format((float)$ask_value, 4, '.', '') . ' PLN'
            ]);
        }
        else {
            return response()->json([
                'error' =>'Brak danych dla tej waluty.'
            ], 404);
        }
    }
}
