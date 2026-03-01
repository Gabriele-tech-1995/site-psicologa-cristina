<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;

class ContactRequestController extends Controller
{
    public function index()
    {
        $requests = ContactRequest::latest()->paginate(10);

        return view('admin.index', compact('requests'));
    }

    public function show(ContactRequest $contactRequest)
    {
        return view('admin.show', compact('contactRequest'));
    }
}
