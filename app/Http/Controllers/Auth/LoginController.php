<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function index()
    {
        return view("login");
    }

    public function doLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        $response = [];
        if ($validator->fails()) {
            $response['status'] = 2;
        } else {
            $status = Auth::attempt(['username' => $username, 'password' => $password], $request->has('remember'));
            if ($status) {
                $response['status'] = 1;
                $response['url'] = route('admin.dashboard.index');
            } else {
                $response['status'] = 0;
            }
        }

        return response($response);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
