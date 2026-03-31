<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;

class ContactRequestController extends Controller
{
    public function index()
    {
        $requests = ContactRequest::latest()->paginate(20);

        return view('admin.index', compact('requests'));
    }

    public function show(ContactRequest $contactRequest)
    {
        return view('admin.show', compact('contactRequest'));
    }

    public function markAsRead(ContactRequest $contactRequest)
    {
        $contactRequest->update([
            'is_read' => true,
        ]);

        return redirect()
            ->to(url()->previous().'#request-'.$contactRequest->id)
            ->with('admin_success', 'Richiesta segnata come letta.');
    }

    public function destroy(ContactRequest $contactRequest)
    {
        $contactRequest->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('admin_success', 'Richiesta eliminata correttamente.');
    }
}
