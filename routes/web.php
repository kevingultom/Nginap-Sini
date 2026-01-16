<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BoardingHouseController;
use App\Http\Controllers\CategoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/find-kos', [BoardingHouseController::class, 'find'])->name('find-kos');
Route::get('/find-kos/result', [BoardingHouseController::class, 'findResult'])->name('find-kos.result');

Route::get('/kos/{slug}', [BoardingHouseController::class, 'show'])->name('kos.show');
Route::get('/kos/{slug}/rooms', [BoardingHouseController::class, 'rooms'])->name('kos.rooms');


Route::get('/kos/booking/{slug}', [BookingController::class, 'booking'])->name('booking');

Route::get('/kos/booking/{slug}/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');

// Route untuk test WhatsApp notification
Route::get('/test-whatsapp/{code}', function($code) {
    $transaction = \App\Models\Transaction::with('boardingHouse')->where('code', $code)->first();
    
    if (!$transaction) {
        return 'Transaction not found';
    }
    
    try {
        $sid    = config('services.twilio.sid');
        $token  = config('services.twilio.token');
        $twilio = new \Twilio\Rest\Client($sid, $token);

        $messages =
            "Halo, " . $transaction->name . "!" . PHP_EOL . PHP_EOL .
            "Kami telah menerima pembayaran Anda dengan kode booking: " . $transaction->code . "." . PHP_EOL .
            "Total pembayaran: Rp " . number_format($transaction->total_amount, 0, ',', '.') . PHP_EOL . PHP_EOL .
            "Anda bisa datang ke kos: " . $transaction->boardingHouse->name . PHP_EOL .
            "Alamat: " . $transaction->boardingHouse->address . PHP_EOL .
            "Mulai tanggal: " . date('d M Y', strtotime($transaction->start_date)) . PHP_EOL . PHP_EOL .
            "Terima kasih atas kepercayaan Anda! 😊" . PHP_EOL .
            "Kami tunggu kedatangan Anda.";

        $phoneNumber = $transaction->phone_number;
        
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }
        
        if (substr($phoneNumber, 0, 1) !== '+') {
            $phoneNumber = '+' . $phoneNumber;
        }

        $message = $twilio->messages->create(
            "whatsapp:" . $phoneNumber,
            [
                "from" => "whatsapp:+14155238886",
                "body" => $messages
            ]
        );

        return 'WhatsApp sent successfully to ' . $phoneNumber . ' - SID: ' . $message->sid;
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
Route::post('/kos/booking/{slug}/payment', [BookingController::class, 'payment'])->name('booking.payment');


Route::get('/kos/booking/{slug}/information', [BookingController::class, 'information'])->name('booking.information');
Route::post('/kos/booking/{slug}/information/save', [BookingController::class, 'saveInformation'])->name('booking.information.save');

Route::get('/booking-success', [BookingController::class, 'success'])->name('booking.success');

Route::get('/check-booking', [BookingController::class, 'check'])->name('check-booking');

Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::post('/check-booking', [BookingController::class, 'show'])->name('check-booking.show');








