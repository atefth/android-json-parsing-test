<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Return json for the given user.
     *
     * @param  int  $id
     * @return JSON
     */
    public function find($id)
    {
        if ($id == 0) {
            $users = DB::select(DB::raw("select * from users"));
            if (count($users)) {
                $status = 'success';
                $data = $users;
            }else{
                $status = 'failure';
                $data = null;
            }
        }else{
            $user = DB::select(DB::raw("select * from users where id = $id"));
            if (count($user)) {
                $status = 'success';
                $data = $user[0];
            }else{
                $status = 'failure';
                $data = null;
            }
        }
        $response = [
            'status' => $status,
            'data' => $data
        ];
        return json_encode($response);
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return JSON
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required'
            ]);

        if ($validator->fails()) {
            $status = 'failure';
            $data = $validator->errors();
        }else{
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');
            $now = date('Y-m-d H:i:s');
            DB::insert(DB::raw("insert into users (name, email, password, created_at) values ('$name', '$email', '$password', '$now')"));
            $status = 'success';
            $data = DB::getPdo()->lastInsertId();
        }
        $response = [
            'status' => $status,
            'data' => $data
        ];
        return json_encode($response);
    }

    /**
     * Add the given user to the given band.
     *
     * @param  int  $user_id, int $band_id
     * @return JSON
     */
    public function joinBand($user_id, $band_id)
    {
        if ($user_id > 0 && $band_id > 0) {
            $exists = db::select(db::raw("select * from bands_users where user_id = $user_id and band_id = $band_id"));
            if (count($exists)) {
                $status = 'failure';
                $data = ['exists' => ['This user is already a member!']];
            }else{
                DB::insert(DB::raw("insert into bands_users (user_id, band_id) values ($user_id, $band_id)"));
                DB::update(DB::raw("update bands set members = members + 1 where id = $band_id"));
                $status = 'success';
                $data = ['member' => ['This user is now a member!']];
            }
        }else{
            $status = 'failure';
            $data = null;
        }
        $response = [
            'status' => $status,
            'data' => $data
        ];
        return json_encode($response);
    }

    /**
     * Remove the given user from the given band.
     *
     * @param  int  $user_id, int $band_id
     * @return JSON
     */
    public function leaveBand($user_id, $band_id)
    {
        if ($user_id > 0 && $band_id > 0) {
            $exists = db::select(db::raw("select * from bands_users where user_id = $user_id and band_id = $band_id"));
            if (count($exists)) {
                DB::delete(DB::raw("delete from bands_users where user_id = $user_id and band_id = $band_id"));
                DB::update(DB::raw("update bands set members = members - 1 where id = $band_id"));
                $status = 'success';
                $data = ['member' => ['This user is no longer a member!']];
            }else{
                $status = 'failure';
                $data = ['exists' => ['This user is not yet a member!']];
            }
        }else{
            $status = 'failure';
            $data = null;
        }
        $response = [
            'status' => $status,
            'data' => $data
        ];
        return json_encode($response);
    }
}