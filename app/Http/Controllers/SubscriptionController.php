<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    public function subscriptionStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscriptions,email',
        ]);

        try {
            // Store the subscription
            Subscription::create([
                'email' => $request->email,
            ]);

            // Send blank subscription confirmation email
            Mail::raw('Thank you for subscribing to GDRI newsletter!', function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Subscription Confirmation - GDRI');
            });

            return response()->json([
                'status' => 'success', 
                'message' => 'Thank you! You have been successfully subscribed to our newsletter.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
