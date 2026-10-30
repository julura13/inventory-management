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

            if($response->body() !== '{"result":"NO RECORDS"}')
            {
                $products = $response->json();
            }
        }

        return view('inventory-api.index')
            ->with('products', $products);
    }

    /**
     * @throws ConnectionException
     */
    public function store(Request $request)
    {
        $request->validate([
            'stockCode' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        $message = 'An error occurred while trying to add the product.';

        $response = Http::asForm()->post($this->URL, [
            'STOCK_CODE' => $request->stockCode,
            'DESCRIPTION' => $request->description,
        ]);

        if ($response->successful()) {
            $verifyProduct = Http::get("$this->URL?ITEM=", [
                'ITEM' => $request->stockCode,
            ]);

            if ($verifyProduct->successful() && count($verifyProduct->json()) > 0) {
                $message = 'Product added successfully';
            }

        }

        return redirect()->route('api.index', ['search' => $request->stockCode])->with('message', $message);

    }

    public function update(Request $request)
    {
        $request->validate([
            'description' => 'required|max:255',
        ]);

        $message = 'An error occurred while trying to add the product.';

        $response = Http::asForm()->put($this->URL, [
            'STOCK_CODE' => $request->stockCode,
            'DESCRIPTION' => $request->description,
        ]);

        if ($response->successful()) {
            $verifyProduct = Http::get("$this->URL?ITEM=", [
                'ITEM' => $request->stockCode,
            ]);

            if ($verifyProduct->successful() && count($verifyProduct->json()) > 0) {
                $message = 'Product added successfully';
            }
        }

        return redirect()->route('api.index', ['search' => $request->stockCode])->with('message', $message);

    }

    public function destroy(Request $request)
    {
        $request->validate(['stockCode' => 'required|max:255']);

        $response = Http::asForm()->delete($this->URL, [
            'STOCK_CODE' => $request->stockCode,
        ]);

        return redirect()->route('api.index', ['search' => $request->stockCode]);
    }
}
