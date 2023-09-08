<?php

namespace App\Http\Controllers\Monitaz;

use App\Http\Controllers\Controller;

class ReactionController extends Controller
{
    public function index()
    {
        return view('monitaz.reaction');
    }
}
