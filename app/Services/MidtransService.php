<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Log; // Import Log facade

class MidtransService
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Menambahkan konfigurasi SSL
        Config::$curlOptions[CURLOPT_CAINFO] = "C:/xampp/php/extras/ssl/cacert.pem";
    }

    // Fungsi untuk membuat transaksi
    public function createTransaction($params)
    {
        try {
            $response = Snap::createTransaction($params);
            
            // Log response dari Midtrans
            Log::info('Midtrans response', ['response' => $response]);

            return $response;
        } catch (\Exception $e) {
            // Jika ada error, log detail errornya
            Log::error('Midtrans transaction error: ' . $e->getMessage(), ['params' => $params]);

            return null; // atau kamu bisa lemparkan exception lagi jika perlu
        }
    }
}
