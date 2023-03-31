<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\User;

class AuthController
{
    public function loginPage(Request $request)
    {
        return view('auth.login')->layout('layouts.app')->render();
    }

    public function registerPage(Request $request)
    {
        if ($request->getMethod() == 'post') {
            $validated = $request->validate([
                'name' => 'required|min:4',
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if ($validated) {
                $validated['password'] = password_hash($validated['password'], PASSWORD_DEFAULT);
                $user = User::create($validated);
                print("<pre>" . print_r($user, true) . "</pre>");
                session()->setFlash('message', 'User registration successful');
                session()->setFlash('class', 'success');
            } else {
                session()->setFlash('message', 'Cannot create user');
                session()->setFlash('class', 'danger');
            }
        }

        return view('auth.register')->layout('layouts.app')->render();
    }
}
