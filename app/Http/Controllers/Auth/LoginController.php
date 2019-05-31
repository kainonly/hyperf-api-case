<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

//        if (Auth::attempt($credentials)) {
//            // 身份验证通过...
//            return redirect()->intended('dashboard');
//        }
        return [
            'status' => Auth::attempt($credentials)
        ];
    }
}
