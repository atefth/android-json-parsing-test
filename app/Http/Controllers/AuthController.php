<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * Login a user with credentials.
     *
     * @param  Request  $request
     * @return JSON
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
            ]);

        if ($validator->fails()) {
            $status = 'failure';
            $data = $validator->errors();
        }else{
            $email = $request->input('email');
            $password = $request->input('password');
            $users = DB::select(DB::raw("select * from users where email = '$email' and password = '$password'"));
            if (count($users)) {
                $status = 'success';
                $data = $users[0];
            }else{
                $status = 'failure';
                $data = ['exists' => ['Invalid email or password!']];
            }
        }
        $response = [
            'status' => $status,
            'data' => $data
        ];
        return json_encode($response);
    }
}