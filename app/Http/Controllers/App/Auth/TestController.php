<?php

namespace App\Http\Controllers\App\Auth;

use App\Helpers\App\Traits\ReCaptchaHelper;
use App\Http\Controllers\Controller;


class TestController extends Controller
{
    use ReCaptchaHelper;

    public function test()
    {
        return  view('page-test.page-test');
    }
}
