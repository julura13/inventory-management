<?php

use Illuminate\Support\Facades\Http;

test('flash message shows after create', function () {
    Http::fake(['*' => Http::response([['STOCK_CODE' => 'A1', 'DESCRIPTION' => 'Thing']], 200)]);

    $this->followingRedirects()
        ->post('/api/product', ['stockCode' => 'A1', 'description' => 'Thing'])
        ->assertSee('Product added successfully');
});

test('flash message shows after update', function () {
    Http::fake(['*' => Http::response([['STOCK_CODE' => 'A1', 'DESCRIPTION' => 'Thing']], 200)]);

    $this->followingRedirects()
        ->put('/api/product', ['stockCode' => 'A1', 'description' => 'Thing 2'])
        ->assertSee('Product updated successfully');
});

test('flash message shows after delete', function () {
    Http::fake(['*' => Http::response(['result' => 'NO RECORDS'], 200)]);

    $this->followingRedirects()
        ->delete('/api/product', ['stockCode' => 'A1'])
        ->assertSee('Product deleted successfully');
});

test('login page is reachable', function () {
    $this->get('/login')->assertOk();
});
