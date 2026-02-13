<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Adoption;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentsController extends Controller
{
    public function initiatePayment(Request $request, $adoptionId)
    {
        $adoption = Adoption::findOrFail($adoptionId);
        $payment = Payment::where('adoption_id', $adoptionId)->firstOrFail();

        // ... (your exact M-PESA STK Push code from original)
        // (I kept it identical, just removed redirect)

        $response = Http::withToken($this->generateAccessToken())->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
            // ... your payload
        ]);

        if ($response->successful()) {
            return response()->json(['message' => 'STK Push sent to phone']);
        }

        return response()->json(['error' => 'Failed to initiate payment'], 500);
    }

    public function handleCallback(Request $request)
    {
        // exact same logic as original
        $data = $request->all();

        $payment = Payment::where('adoption_id', $data['AccountReference'] ?? null)->first();

        if ($payment && ($data['ResultCode'] ?? null) == 0) {
            $payment->update(['payment_status' => 'confirmed']);
            $payment->adoption->update(['status' => 'completed']);
        }

        return response()->json(['status' => 'success']);
    }

    private function generateAccessToken()
    {
        // same as original
        $response = Http::withBasicAuth(config('mpesa.consumer_key'), config('mpesa.consumer_secret'))
            ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        return $response->json()['access_token'];
    }
}