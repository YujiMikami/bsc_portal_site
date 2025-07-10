<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function username()
    {
        return 'user_id'; // または username, login_id など任意のカラム名
    }
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string', // 'user_id' が required
            'password' => 'required|string',
        ]);
    }
}
