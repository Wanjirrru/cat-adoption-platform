<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentsController extends Controller
{
    public function initiatePayment($adoptionId)
    {
        $adoption = Adoption::with('cat')->findOrFail($adoptionId);
        $payment = $adoption->payment;

        // M-PESA API Credentials
        $consumerKey = config('mpesa.consumer_key');
        $consumerSecret = config('mpesa.consumer_secret');
        $shortCode = config('mpesa.shortcode');
        $passKey = config('mpesa.passkey');

        // Generate timestamp and password
        $timestamp = now()->format('YmdHis');
        $password = base64_encode($shortCode . $passKey . $timestamp);

        // Initiate the STK Push
        $response = Http::withToken($this->generateAccessToken())->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
            'BusinessShortCode' => $shortCode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $payment->amount,
            'PartyA' => 'USER_PHONE_NUMBER', // Replace with user phone from request
            'PartyB' => $shortCode,
            'PhoneNumber' => 'USER_PHONE_NUMBER', // Replace with user phone from request
            'CallBackURL' => route('payments.callback'),
            'AccountReference' => 'Adoption-' . $adoptionId,
            'TransactionDesc' => 'Cat Adoption Payment',
        ]);

        if ($response->successful()) {
            return redirect()->route('adoptions.index')->with('success', 'STK Push sent to your phone. Complete the payment to proceed.');
        }

        return redirect()->route('adoptions.index')->with('error', 'Failed to initiate payment. Please try again.');
    }

    public function handleCallback(Request $request)
    {
        $data = $request->all();

        // Process M-PESA callback
        $payment = Payment::where('adoption_id', $data['AccountReference'])->first();

        if ($payment && $data['ResultCode'] == 0) {
            $payment->update(['payment_status' => Payment::STATUS_COMPLETED]);
            $payment->adoption->update(['status' => Adoption::STATUS_COMPLETED]);
        }

        return response()->json(['status' => 'success']);
    }

    private function generateAccessToken()
    {
        $response = Http::withBasicAuth(config('mpesa.consumer_key'), config('mpesa.consumer_secret'))
            ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        return $response->json()['access_token'];
    }
}