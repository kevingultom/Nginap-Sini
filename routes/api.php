<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MidtransController; 

// Midtrans callback tidak memerlukan CSRF protection karena dari server eksternal
Route::post('/midtrans-callback', [MidtransController::class, 'callback']); 