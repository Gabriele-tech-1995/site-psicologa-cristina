<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function approve(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_approved' => true,
        ]);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('admin_success', 'Testimonianza approvata correttamente.');
    }

    public function unapprove(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_approved' => false,
        ]);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('admin_success', 'Testimonianza rimossa dalla pubblicazione.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('admin_success', 'Testimonianza eliminata correttamente.');
    }
}
