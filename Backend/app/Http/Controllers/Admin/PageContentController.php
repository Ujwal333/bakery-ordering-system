<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageContentController extends Controller
{
    public function index()
    {
        // Group content by page_key
        $contents = PageContent::all()->groupBy('page_key');
        return view('admin.page-contents.index', compact('contents'));
    }

    public function update(Request $request, PageContent $pageContent)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->has('remove_image')) {
            if ($pageContent->image_path) {
                Storage::disk('public')->delete($pageContent->image_path);
            }
            $validated['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($pageContent->image_path && !$request->has('remove_image')) {
                Storage::disk('public')->delete($pageContent->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('page-contents', 'public');
        }

        $pageContent->update($validated);

        return back()->with('success', 'Content updated successfully.');
    }
}
