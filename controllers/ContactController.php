<?php

namespace App\Controllers;

use App\Core\Request;

class ContactController
{
    public function getPage()
    {
        return view('contact')->render();
    }

    public function submit(Request $request)
    {
        print("<pre>" . print_r($request->getBody(), true) . "</pre>");
        echo 'Submitted';
        // return view('contact')->render();
    }
}
