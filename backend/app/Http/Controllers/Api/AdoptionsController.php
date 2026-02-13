<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Adoption;
use App\Models\Cat;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Mail\AdoptionRequestReceived;
use App\Mail\AdoptionApproved;
use App\Mail\AdoptionDenied;
use Illuminate\Support\Facades\Mail;

class AdoptionsController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole(['admin', 'super-admin'])) {
            $adoptions = Adoption::with(['cat', 'user'])->latest()->get();
        } else {
            $adoptions = Adoption::with(['cat'])->where('user_id', auth()->id())->latest()->get();
        }

        return response()->json(['data' => $adoptions]);
    }

    public function store(Request $request, Cat $cat)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        if ($cat->is_adopted) {
            return response()->json(['error' => 'This cat is already adopted'], 400);
        }

        $adoption = Adoption::create([
            'user_id' => auth()->id(),
            'cat_id'  => $cat->id,
            'status'  => 'pending',
            'message' => $request->message,
        ]);

        // Emails (same as original)
        Mail::to('wanjirumel@icloud.com')->send(new AdoptionRequestReceived($adoption));
        // You can call the static method if it exists, or just send the mailable

        return response()->json([
            'message' => 'Adoption request submitted',
            'data'    => $adoption->load('cat'),
        ], 201);
    }

    public function approve(Adoption $adoption)
    {
        $payment = Payment::where('adoption_id', $adoption->id)->first();

        if (!$payment || $payment->payment_status !== 'confirmed') {
            return response()->json(['error' => 'Payment not confirmed'], 400);
        }

        $adoption->update(['status' => 'approved']);
        $adoption->cat->markAsAdopted();

        Mail::to($adoption->user->email)->send(new AdoptionApproved($adoption));

        return response()->json(['message' => 'Adoption approved']);
    }

    public function deny(Adoption $adoption)
    {
        $adoption->update(['status' => 'declined']);
        Mail::to($adoption->user->email)->send(new AdoptionDenied($adoption));

        return response()->json(['message' => 'Adoption denied']);
    }

    public function payment(Adoption $adoption)
    {
        if ($adoption->status !== 'accepted') {
            return response()->json(['error' => 'Adoption not accepted yet'], 400);
        }
        return response()->json(['data' => $adoption]);
    }

    public function processPayment(Request $request, Adoption $adoption)
    {
        $request->validate(['payment_amount' => 'required|numeric|min:0']);

        if ($request->payment_amount != $adoption->cat->price) {
            return response()->json(['error' => 'Amount does not match cat price'], 400);
        }

        Payment::create([
            'adoption_id' => $adoption->id,
            'amount' => $request->payment_amount,
            'payment_status' => 'confirmed',
        ]);

        $adoption->update(['status' => 'completed']);

        return response()->json(['message' => 'Payment processed successfully']);
    }
}