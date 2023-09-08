<?php

namespace App\Http\Controllers\App\Test;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function test()
    {
        return view('ThanhTest.thanh-test');
    }
}
