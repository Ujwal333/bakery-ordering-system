<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactQuery;
use App\Models\Testimonial;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function submitInquiry(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactQuery::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'unread'
        ]);

        return response()->json(['message' => 'Inquiry submitted successfully']);
    }

    public function submitReview(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Authentication required'], 401);
        }

        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create([
            'customer_name' => Auth::user()->name,
            'content' => $request->content,
            'rating' => $request->rating,
            'status' => 'pending'
        ]);

        return response()->json(['message' => 'Review submitted for approval']);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:subscribers,email',
        ], [
            'email.unique' => 'This email is already subscribed!'
        ]);

        Subscriber::create([
            'email' => $request->email,
            'is_active' => true
        ]);

        return response()->json(['message' => 'Subscribed successfully']);
    }
}
