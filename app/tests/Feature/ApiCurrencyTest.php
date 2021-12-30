<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ApiCurrencyTest extends TestCase
{
    public function testIfWrongCurrency()
    {
        $currency = Str::random(10);
        $response = $this->get('/api/'.$currency.'/200');

        $response->assertStatus(404);
    }

    public function testIfWrongValue()
    {
        $currency = 'usd';
        $value = Str::random(10);
        $response = $this->get('/api/'.$currency.'/'.$value);

        $response->assertStatus(404);
    }
}
