<?php

namespace App\Controllers;

use App\Core\Request;

class BlogController
{
    public function index(Request $request, $slug)
    {
        return view('blog.sample-blog')->layout('layouts.app')->render();
    }
}
