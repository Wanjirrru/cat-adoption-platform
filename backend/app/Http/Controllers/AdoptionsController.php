<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adoption;
use App\Models\Cat;
use App\Models\Payment;
use App\Mail\AdoptionRequestReceived;
use App\Mail\AdoptionApproved;
use App\Mail\AdoptionDenied;
use Illuminate\Support\Facades\Mail;


class AdoptionsController extends Controller
{

public function index()
{
    if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')) {
        // Admin/Super-admin can view all adoption requests
        $adoptions = Adoption::with(['cat', 'user'])->get();
    } else {
        // Regular users can only see their own adoption requests
        $adoptions = Adoption::with(['cat', 'user'])->where('user_id', auth()->id())->get();
    }

    // Return the view with adoption data
    return view('adoptions.index', compact('adoptions'));
}


public function create($catId)
    {
        // Retrieve the cat details by ID
        $cat = Cat::findOrFail($catId);

        // Return the view with the cat's data to show in the form
        return view('adoptions.create', compact('cat'));
    }
public function store(Request $request, $catId)
{
    $request->validate([
        'message' => 'required|string|max:255',
    ]);

    $cat = Cat::findOrFail($catId);

    // Check if the cat is already adopted
    if ($cat->is_adopted) {
        return redirect()->route('cats.index')->with('error', 'This cat has already been adopted.');
    }

    $adoption = Adoption::create([
        'user_id' => auth()->id(),
        'cat_id' => $catId,
        'status' => Adoption::STATUS_PENDING,
        'message' => $request->message,
    ]);

    // Send confirmation email to the admin
    Mail::to('wanjirumel@icloud.com')->send(new AdoptionRequestReceived($adoption));

    // Send confirmation email to the adopter
    AdoptionRequestReceived::sendAdopterConfirmation($adoption);

    return redirect()->route('adoptions.index')
                     ->with('success', 'Your adoption request has been submitted!');
}

    public function update(Request $request, $adoptionId)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|in:pending,accepted,declined',
        ]);

        // Find the adoption request
        $adoption = Adoption::findOrFail($adoptionId);

        // Ensure the user has the necessary role to update the status
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')) {
            // Update the adoption status
            $adoption->status = $request->status;
            $adoption->save();

            // If the status is 'accepted', check if the user is an admin or super-admin and redirect accordingly
            if ($adoption->status === 'accepted') {
                // Send approval email to the user
                Mail::to($adoption->user->email)->send(new AdoptionApproved($adoption));

                // Redirect based on the user role
                if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')) {
                    // Admin redirects to the adoption requests page
                    return redirect()->route('adoptions.index')->with('success', 'Adoption status updated successfully!');
                }
            }

            // If the status is 'declined', send an email and redirect
            if ($adoption->status === 'declined') {
                // Send denial email to the user
                Mail::to($adoption->user->email)->send(new AdoptionDenied($adoption));
                return redirect()->route('adoptions.index')->with('success', 'Adoption request denied.');
            }

        } else {
            // For regular users, only 'accepted' should trigger a redirect to the payment page
            if ($adoption->status === 'accepted') {
                // Send approval email to the user
                Mail::to($adoption->user->email)->send(new AdoptionApproved($adoption));

                // Redirect to payment screen for users
                return redirect()->route('adoptions.payment',['adoption' => $adoption->id])->with('success', 'Adoption accepted. Proceed to payment.');
            }
        }

        // If no conditions are met, redirect back with an error
        return redirect()->route('adoptions.index')->with('error', 'Unauthorized access or invalid status.');
    }



    public function review(Adoption $adoption)
{
    return view('adoptions.review', compact('adoption'));
}
    // Approve an adoption request
    public function approve($id)
    {
        $adoption = Adoption::findOrFail($id);

        // Check if a payment is associated with this adoption
        $payment = Payment::where('adoption_id', $adoption->id)->first();

        if (!$payment || $payment->status !== 'confirmed') {
            return redirect()->with('error', 'Payment not confirmed. Cannot approve adoption.');
        }

        // Ensure the adoption is not already approved
        if ($adoption->status === 'accepted') {
            return redirect()->with('error', 'Adoption is already approved.');
        }

        // Mark adoption as approved
        $adoption->status = 'approved';
        $adoption->save();

        // Mark the cat as adopted
       $adoption->cat->markAsAdopted();

        // Send approval notification
        Mail::to($adoption->user->email)->send(new AdoptionApproved($adoption));

        return redirect()->route('adoptions.index')
                         ->with('success', 'Adoption approved successfully.');
    }

public function payment($adoptionId)
{
    // Fetch the adoption record by ID
    $adoption = Adoption::find($adoptionId);

    // Check if the adoption exists
    if (!$adoption) {
        return redirect()->route('adoptions.index')->with('error', 'Adoption not found.');
    }

    // Ensure the adoption status is 'accepted' before proceeding
    if ($adoption->status !== 'accepted') {
        return redirect()->route('adoptions.index')->with('error', 'Invalid request. Adoption not accepted.');
    }


    return view('adoptions.payment', compact('adoption'));
}



    public function processPayment(Request $request, $id)
    {
        $request->validate([
            'payment_amount' => 'required|numeric|min:0',
        ]);

        $adoption = Adoption::findOrFail($id);

        // Ensure the status is 'accepted' before processing payment
        if ($adoption->status !== 'accepted') {
            return redirect()->route('adoptions.index')->with('error', 'Invalid request.');
        }

        // Ensure the payment amount matches the cat's price
        $catPrice = $adoption->cat->price;
        if ($request->payment_amount != $catPrice) {
            return redirect()->route('adoptions.payment', $adoption->id)->with('error', 'Payment amount does not match the adoption fee.');
        }

        // Create a payment record with the provided amount
        Payment::create([
            'adoption_id' => $adoption->id,
            'amount' => $request->payment_amount,
            'payment_status' => 'confirmed', // Simulate payment confirmation
        ]);

        // Update the adoption status to 'completed'
        $adoption->status = 'completed';
        $adoption->save();

        return redirect()->route('adoptions.index')->with('success', 'Payment processed successfully.');
    }



    // Deny an adoption request
    public function deny($id)
    {
        $adoption = Adoption::findOrFail($id);

        // Ensure the adoption is not already denied
        if ($adoption->status === 'declined') {
            return redirect()->with('error', 'Adoption is already denied.');
        }

        // Mark adoption as denied
        $adoption->status = 'declined';
        $adoption->save();

        // Send denial notification
        Mail::to($adoption->user->email)->send(new AdoptionDenied($adoption));

        return redirect('adoptions.index')->with('success', 'Adoption denied .');
    }
}