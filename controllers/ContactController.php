<?php

namespace App\Controllers;

use App\Core\Request;

class ContactController
{
    public function getPage()
    {
        return view('contact')->layout('layouts.app')->render();
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'min:6', 'email'],
            'password' => 'required|min:6|max:20',
        ]);

        // print("<pre>" . print_r($validated, true) . "</pre>");
        return view('contact')->layout('layouts.app')->render();
    }
}
