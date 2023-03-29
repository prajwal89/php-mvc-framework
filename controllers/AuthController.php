<?php

namespace App\Controllers;

use App\Core\Request;

class AuthController
{
    public function loginPage(Request $request)
    {
        return view('auth.login')->layout('layouts.app')->render();
    }

    public function registerPage(Request $request)
    {
        return view('auth.register')->layout('layouts.app')->render();
    }
}
