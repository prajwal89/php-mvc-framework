<?php

namespace App\Controllers;


class ContactController
{
    public function getPage()
    {
        return view('contact')->render();
    }
}
