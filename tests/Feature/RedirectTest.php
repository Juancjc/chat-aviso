<?php

use Illuminate\Support\Facades\Route;

test('internal redirects preserve the browser host and port', function () {
    config(['app.url' => 'http://161.97.168.36:5488']);

    Route::get(
        '/internal-redirect-test',
        fn () => redirect()->away('http://161.97.168.36/grupos/5/chat'),
    )->middleware('web');

    $response = $this->get('/internal-redirect-test');

    expect($response->headers->get('Location'))->toBe('/grupos/5/chat');
});

test('external redirects remain absolute', function () {
    Route::get(
        '/external-redirect-test',
        fn () => redirect()->away('https://example.com/destination'),
    )->middleware('web');

    $response = $this->get('/external-redirect-test');

    expect($response->headers->get('Location'))->toBe('https://example.com/destination');
});
