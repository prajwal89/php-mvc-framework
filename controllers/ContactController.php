<?php

namespace App\Controllers;


class ContactController
{
    public function getPage()
    {
        return view('contact')->render();
    }

    public function submit()
    {
        echo 'Submitted';
        // return view('contact')->render();
    }
}
