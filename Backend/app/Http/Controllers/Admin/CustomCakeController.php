<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomCake;
use Illuminate\Http\Request;

class CustomCakeController extends Controller
{
    /**
     * Display a listing of custom cake requests.
     */
    public function index(Request $request)
    {
        $query = CustomCake::with('user');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference_number', 'LIKE', "%{$search}%")
                  ->orWhere('cake_name', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        $customCakes = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.custom-cakes.index', compact('customCakes'));
    }

    /**
     * Display the specified custom cake request.
     */
    public function show($id)
    {
        $customCake = CustomCake::with('user')->findOrFail($id);
        return view('admin.custom-cakes.show', compact('customCake'));
    }

    /**
     * Update the status of a custom cake request.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,cancelled',
            'total_price' => 'nullable|numeric',
        ]);

        $customCake = CustomCake::findOrFail($id);
        
        $data = ['status' => $request->status];
        
        if ($request->has('total_price') && $request->total_price != '') {
            $data['total_price'] = $request->total_price;
        }

        $customCake->update($data);

        return redirect()->back()->with('success', 'Custom cake request status updated to ' . ucfirst($request->status));
    }
}
