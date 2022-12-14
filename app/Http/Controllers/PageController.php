<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __invoke($page) {
        return view('pages.' . $page,  ['metaTitle' => ucwords($page)]);
    }
}
