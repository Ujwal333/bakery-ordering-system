<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactQuery;
use Illuminate\Http\Request;

class ContactQueryController extends Controller
{
    public function index()
    {
        $queries = ContactQuery::latest()->paginate(10);
        return view('admin.queries.index', compact('queries'));
    }

    public function show(ContactQuery $query)
    {
        $query->update(['status' => 'read']);
        return view('admin.queries.show', compact('query'));
    }

    public function updateStatus(Request $request, ContactQuery $query)
    {
        $query->update(['status' => $request->status, 'admin_note' => $request->admin_note]);
        return back()->with('success', 'Query updated.');
    }

    public function destroy(ContactQuery $query)
    {
        $query->delete();
        return back()->with('success', 'Query deleted.');
    }
}
