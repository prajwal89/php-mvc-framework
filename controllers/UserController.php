<?php

namespace App\Controllers;

use App\Core\Request;

class UserController
{
    public function dashboard(Request $request)
    {
        return view('user.dashboard')->render();
    }
}
