<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        // Log semua request untuk debugging
        Log::info('Midtrans Callback Received', $request->all());

        $serverKey = config('midtrans.server_key');
        $hashedKey = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($hashedKey !== $request->signature_key) {
            Log::error('Invalid signature key');
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;
        
        // Eager load relasi boardingHouse
        $transaction = Transaction::with('boardingHouse')->where('code', $orderId)->first();

        if (!$transaction) {
            Log::error('Transaction not found: ' . $orderId);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        Log::info('Processing transaction: ' . $orderId . ' with status: ' . $transactionStatus);

        switch ($transactionStatus) {
            case 'capture':
                if ($request->payment_type == 'credit_card') {
                    if ($request->fraud_status == 'challenge') {
                        $transaction->update(['payment_status' => 'pending']);
                    } else {
                        $transaction->update(['payment_status' => 'success']);
                        $this->sendWhatsAppNotification($transaction);
                    }
                }
                break;
            case 'settlement':
                $transaction->update(['payment_status' => 'success']);
                $this->sendWhatsAppNotification($transaction);
                break;
            case 'pending':
                $transaction->update(['payment_status' => 'pending']);
                break;
            case 'deny':
                $transaction->update(['payment_status' => 'failed']);
                break;
            case 'expire':
                $transaction->update(['payment_status' => 'expired']);
                break;
            case 'cancel':
                $transaction->update(['payment_status' => 'canceled']);
                break;
            default:
                $transaction->update(['payment_status' => 'unknown']);
                break;
        }
        
        Log::info('Transaction updated successfully: ' . $orderId);
        return response()->json(['message' => 'Callback received successfully']);
    }

    private function sendWhatsAppNotification($transaction)
    {
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

            // Format nomor telepon dengan benar
            $phoneNumber = $transaction->phone_number;
            
            // Jika nomor dimulai dengan 0, ganti dengan 62
            if (substr($phoneNumber, 0, 1) === '0') {
                $phoneNumber = '62' . substr($phoneNumber, 1);
            }
            
            // Pastikan nomor dimulai dengan +
            if (substr($phoneNumber, 0, 1) !== '+') {
                $phoneNumber = '+' . $phoneNumber;
            }

            Log::info('Sending WhatsApp to: ' . $phoneNumber);

            $message = $twilio->messages->create(
                "whatsapp:" . $phoneNumber,
                [
                    "from" => "whatsapp:+14155238886",
                    "body" => $messages
                ]
            );

            Log::info('WhatsApp sent successfully. SID: ' . $message->sid);
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp: ' . $e->getMessage());
        }
    }
}