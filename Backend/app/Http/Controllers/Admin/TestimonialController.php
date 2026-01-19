<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function toggleStatus(Testimonial $testimonial)
    {
        $newStatus = $testimonial->status == 'approved' ? 'pending' : 'approved';
        $testimonial->update(['status' => $newStatus]);
        return back()->with('success', 'Testimonial status updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted.');
    }
}
