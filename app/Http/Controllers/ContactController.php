<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.index', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        try {
            $contact = Contact::findOrFail($id);
            $contact->update([
                'address' => $request->address ?? null,
                'phone' => $request->phone ?? null,
                'email' => $request->email ?? null,
                'website' => $request->website ?? null,
            ]);
            return redirect()->back()->with('success', 'Contact updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update contact.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
