<?php

namespace App\Http\Controllers;

use DB;

class BandController extends Controller
{
    /**
     * Return json for the given band.
     *
     * @param  int  $id
     * @return JSON
     */
    public function find($id)
    {
        if ($id == 0) {
            $bands = DB::select(DB::raw("select * from bands"));
            if (count($bands)) {
                $status = 'success';
                $data = $bands;
            }else{
                $status = 'failure';
                $data = null;
            }
        }else{
            $band = DB::select(DB::raw("select * from bands where id = $id"));
            if (count($band)) {
                $status = 'success';
                $data = $band[0];
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
}