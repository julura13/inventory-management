<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{

    public string $URL = 'http://10.0.0.122:55500/Inventory';

    public function index(Request $request)
    {
        $search = $request->search;

        $products = [];

        if (! empty($search)) {

            $response = Http::get("$this->URL?ITEM=", [
                'ITEM' => $search,
            ]);

            $products = $response->json();
        }

        return view('inventory-api.index')->with('products', $products);
    }

    public function store(Request $request)
    {
        $stockCode = $request->stockCode;
        $description = $request->description;

        if (empty($stockCode) || empty($description)) {
            return response()->json(['error' => 'stockCode or description cannot be empty']);
        }

        $response = Http::asForm()->post($this->URL, [
            'STOCK_CODE' => $stockCode,
            'DESCRIPTION' => $description,
        ]);

    }
}
