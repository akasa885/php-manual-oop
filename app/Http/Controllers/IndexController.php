<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Preps\Components\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title' => [
                'web' => 'Rizki Akbar',
                'page' => 'Home Page',
            ]
        ];
        return view('pages.index', $data);
    }

    public function about()
    {
        return view('pages.about');
    }
}