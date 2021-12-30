<?php

namespace App\Console\Commands;

use App\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Exception;


class GetCurrenciesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pobiera wartości walut eur, usd, chf w 3 wersjach (kurs średni, sprzedaży i kupna)
    oraz zapisuje je w bazie.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $codes = ['USD', 'EUR', 'CHF'];
        foreach($codes as $code){
            try {
                $this->getAndSaveCurrencyRates($code, 'a');
                $this->getAndSaveCurrencyRates($code, 'c');

                echo "Poprawnie zapisano kursy dla waluty $code." ;
            } catch (Exception $e) {
                echo "Exception " . $e->getMessage();
            }
        }
    }

    public function getAndSaveCurrencyRates(string $code, string $table)
    {
        $url = 'https://api.nbp.pl/api/exchangerates/rates/'.$table.'/'. $code;

        $response = Http::withOptions([
            'verify' => false
        ])->get($url);

        $currency = Currency::where('code', 'LIKE', $code)->first();
        if(empty($currency)){
            $currency = new Currency();
            $currency->code = $code;
        }

        if($table == 'a') {
            $currency->mid = $response['rates'][0]['mid'];
        }
        if($table == 'c') {
            $currency->bid = $response['rates'][0]['bid'];
            $currency->ask = $response['rates'][0]['ask'];
        }

        return $currency->save();
    }
}
