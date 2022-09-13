<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
	public function getCurrencyList()
	{
		// set API Endpoint and API key
		$url = 'http://api.exchangeratesapi.io/v1/';
		$endpoint = 'latest';
		$access_key = '4c18227860dfc05382d280d0906552c9';

		// Initialize CURL:
		$ch = curl_init($url . $endpoint . '?access_key=' . $access_key . '&format=1');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Store the data:
		$json = curl_exec($ch);
		curl_close($ch);

		// Decode JSON response:
		$exchangeRates = json_decode($json, true);

		// Access the exchange rate values, e.g. GBP:
		return response()->json($exchangeRates);
	}
}
