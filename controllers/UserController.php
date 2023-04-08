<?php

namespace App\Controllers;

use App\Core\Request;

class UserController
{
    public function dashboard(Request $request)
    {
        session()->setFlash('message', 'User Login successful');
        session()->setFlash('class', 'success');
        dump($_SESSION);

        return view('user.dashboard')->layout('layouts.app')->render();
    }
}
