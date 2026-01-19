<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogisticController extends Controller
{
    public function index()
    {
        $partners = \App\Models\LogisticPartner::withCount('orders')->get();
        return view('admin.logistics.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.logistics.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        \App\Models\LogisticPartner::create($data);
        return redirect()->route('admin.logistics.index')->with('success', 'Logistic partner added successfully.');
    }

    public function edit(\App\Models\LogisticPartner $logistic)
    {
        return view('admin.logistics.edit', compact('logistic'));
    }

    public function update(Request $request, \App\Models\LogisticPartner $logistic)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'required|boolean',
        ]);

        $logistic->update($data);
        return redirect()->route('admin.logistics.index')->with('success', 'Logistic partner updated.');
    }

    public function destroy(\App\Models\LogisticPartner $logistic)
    {
        $logistic->delete();
        return redirect()->route('admin.logistics.index')->with('success', 'Logistic partner removed.');
    }

    public function handover(Request $request, \App\Models\Order $order)
    {
        $request->validate([
            'logistic_partner_id' => 'required|exists:logistic_partners,id',
        ]);

        $order->update([
            'status' => 'with_logistic',
            'logistic_partner_id' => $request->logistic_partner_id,
            'handed_over_at' => now(),
        ]);

        return back()->with('success', 'Order handed over to logistic partner.');
    }
}
