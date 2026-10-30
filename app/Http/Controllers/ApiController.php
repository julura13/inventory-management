<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{

    public string $URL = 'http://10.0.0.122:55500/Inventory';

    /**
     * Look up products by stock code / description. Returns null when the API is unreachable.
     */
    private function lookup(string $item): ?array
    {
        try {
            $response = Http::timeout(10)->get($this->URL, ['ITEM' => $item]);
        } catch (ConnectionException) {
            return null;
        }

        $data = $response->json();

        if (! $response->successful() || ! is_array($data) || isset($data['result'])) {
            return [];
        }

        return $data;
    }

    private function productExists(string $stockCode): bool
    {
        return collect($this->lookup($stockCode) ?? [])
            ->contains(fn ($product) => ($product['STOCK_CODE'] ?? null) === $stockCode);
    }

    public function index(Request $request)
    {
        $search = $request->query('search');

        $products = [];

        if (! empty($search)) {
            $products = $this->lookup($search);

            if ($products === null) {
                $products = [];
                session()->now('message', 'Unable to reach the inventory service.');
            }
        }

        return view('inventory-api.index')
            ->with('products', $products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'stockCode' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        $message = 'An error occurred while trying to add the product.';

        try {
            $response = Http::timeout(10)->asForm()->post($this->URL, [
                'STOCK_CODE' => $request->stockCode,
                'DESCRIPTION' => $request->description,
            ]);

            if ($response->successful() && $this->productExists($request->stockCode)) {
                $message = 'Product added successfully';
            }
        } catch (ConnectionException) {
            $message = 'Unable to reach the inventory service.';
        }

        return redirect()->route('api.index', ['search' => $request->stockCode])->with('message', $message);
    }

    public function update(Request $request)
    {
        $request->validate([
            'stockCode' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        $message = 'An error occurred while trying to update the product.';

        try {
            $response = Http::timeout(10)->asForm()->put($this->URL, [
                'STOCK_CODE' => $request->stockCode,
                'DESCRIPTION' => $request->description,
            ]);

            if ($response->successful() && $this->productExists($request->stockCode)) {
                $message = 'Product updated successfully';
            }
        } catch (ConnectionException) {
            $message = 'Unable to reach the inventory service.';
        }

        return redirect()->route('api.index', ['search' => $request->stockCode])->with('message', $message);
    }

    public function destroy(Request $request)
    {
        $request->validate(['stockCode' => 'required|max:255']);

        $message = 'An error occurred while trying to delete the product.';

        try {
            $response = Http::timeout(10)->asForm()->delete($this->URL, [
                'STOCK_CODE' => $request->stockCode,
            ]);

            if ($response->successful() && ! $this->productExists($request->stockCode)) {
                $message = 'Product deleted successfully';
            }
        } catch (ConnectionException) {
            $message = 'Unable to reach the inventory service.';
        }

        return redirect()->route('api.index', ['search' => $request->stockCode])->with('message', $message);
    }
}
