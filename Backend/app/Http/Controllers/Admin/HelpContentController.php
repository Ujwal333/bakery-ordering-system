<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpContent;
use Illuminate\Http\Request;

class HelpContentController extends Controller
{
    /**
     * Display a listing of help contents.
     */
    public function index()
    {
        $helpContents = HelpContent::orderBy('type')->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.help-contents.index', compact('helpContents'));
    }

    /**
     * Show the form for creating new help content.
     */
    public function create()
    {
        return view('admin.help-contents.create');
    }

    /**
     * Store newly created help content.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:faq,help_card',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        HelpContent::create($validated);

        return redirect()->route('admin.help-contents.index')
            ->with('success', 'Help content created successfully.');
    }

    /**
     * Show the form for editing the specified help content.
     */
    public function edit(HelpContent $helpContent)
    {
        return view('admin.help-contents.edit', compact('helpContent'));
    }

    /**
     * Update the specified help content.
     */
    public function update(Request $request, HelpContent $helpContent)
    {
        $validated = $request->validate([
            'type' => 'required|in:faq,help_card',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $helpContent->update($validated);

        return redirect()->route('admin.help-contents.index')
            ->with('success', 'Help content updated successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(HelpContent $helpContent)
    {
        $helpContent->update([
            'is_active' => !$helpContent->is_active
        ]);

        return back()->with('success', 'Help content status updated.');
    }

    /**
     * Remove the specified help content.
     */
    public function destroy(HelpContent $helpContent)
    {
        $helpContent->delete();

        return redirect()->route('admin.help-contents.index')
            ->with('success', 'Help content deleted successfully.');
    }
}
