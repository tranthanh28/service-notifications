<?php

namespace App\Http\Controllers\App\Auth;

use App\Helpers\App\Traits\ReCaptchaHelper;
use App\Http\Controllers\Controller;


class AuthenticateUserController extends Controller
{
    use ReCaptchaHelper;
    public function show()
    {
        return auth()->user()->load('roles:id,name', 'profile:id,user_id,gender,date_of_birth,address,contact', 'profilePicture', 'status:id,name,class', 'socialLinks');
    }

}
