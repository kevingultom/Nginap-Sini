<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Transaction;
use Twilio\Rest\Client;

// Ambil transaction terakhir
$transaction = Transaction::with('boardingHouse')
    ->where('code', 'NGKBWA-450956')
    ->first();

if (!$transaction) {
    echo "Transaction not found!\n";
    exit;
}

echo "Transaction Code: " . $transaction->code . "\n";
echo "Name: " . $transaction->name . "\n";
echo "Phone: " . $transaction->phone_number . "\n";
echo "Current Status: " . $transaction->payment_status . "\n\n";

// Update status menjadi success
$transaction->update(['payment_status' => 'success']);
echo "Status updated to: success\n\n";

// Kirim WhatsApp
try {
    $sid    = config('services.twilio.sid');
    $token  = config('services.twilio.token');
    $twilio = new Client($sid, $token);

    $messages =
        "Halo, " . $transaction->name . "!" . PHP_EOL . PHP_EOL .
        "Kami telah menerima pembayaran Anda dengan kode booking: " . $transaction->code . "." . PHP_EOL .
        "Total pembayaran: Rp " . number_format($transaction->total_amount, 0, ',', '.') . PHP_EOL . PHP_EOL .
        "Anda bisa datang ke kos: " . $transaction->boardingHouse->name . PHP_EOL .
        "Alamat: " . $transaction->boardingHouse->address . PHP_EOL .
        "Mulai tanggal: " . date('d M Y', strtotime($transaction->start_date)) . PHP_EOL . PHP_EOL .
        "Terima kasih atas kepercayaan Anda! 😊" . PHP_EOL .
        "Kami tunggu kedatangan Anda.";

    // Format nomor telepon
    $phoneNumber = $transaction->phone_number;
    
    echo "Original phone: $phoneNumber\n";
    
    // Jika nomor dimulai dengan 0, ganti dengan 62
    if (substr($phoneNumber, 0, 1) === '0') {
        $phoneNumber = '62' . substr($phoneNumber, 1);
    }
    
    // Pastikan nomor dimulai dengan +
    if (substr($phoneNumber, 0, 1) !== '+') {
        $phoneNumber = '+' . $phoneNumber;
    }

    echo "Formatted phone: $phoneNumber\n";
    echo "Sending WhatsApp...\n";

    $message = $twilio->messages->create(
        "whatsapp:" . $phoneNumber,
        [
            "from" => "whatsapp:+14155238886",
            "body" => $messages
        ]
    );

    echo "\n✅ WhatsApp sent successfully!\n";
    echo "SID: " . $message->sid . "\n";
    echo "Status: " . $message->status . "\n";
    echo "To: " . $phoneNumber . "\n";
    
} catch (Exception $e) {
    echo "\n❌ Error sending WhatsApp:\n";
    echo $e->getMessage() . "\n";
}
