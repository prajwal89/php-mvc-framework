<?php

namespace App\Controllers;

use App\Core\Request;

class ArticleController
{
    public function index(Request $request, $slug)
    {
        echo "this is slug $slug";
        return view('article')->layout('layouts.app')->render();
    }
}
