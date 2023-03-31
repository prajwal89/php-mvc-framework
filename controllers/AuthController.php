<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\User;
use App\Core\Facades\Hash;

class AuthController
{
    public function loginPage(Request $request)
    {
        if ($request->getMethod() == 'post') {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if ($validated) {
                if (User::attempt([
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password'])
                ])) {
                    session()->setFlash('message', 'User Login successful');
                    session()->setFlash('class', 'success');
                } else {
                    session()->setFlash('message', 'Incorrect credentials');
                    session()->setFlash('class', 'danger');
                };
            }
        }

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
                $validated['password'] = Hash::make($validated['password']);
                $user = User::create($validated);
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
