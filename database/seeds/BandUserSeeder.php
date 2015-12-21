<?php

use Illuminate\Database\Seeder;

class BandUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relationships = [
            ['user' => 1, 'band' => 1],
            ['user' => 3, 'band' => 1],
            ['user' => 2, 'band' => 2],
            ['user' => 4, 'band' => 2],
            ['user' => 4, 'band' => 3]
        ];
        foreach ($relationships as $key => $relationship) {
            $user_id = $relationship['user'];
            $band_id = $relationship['band'];
            DB::insert(DB::raw("insert into bands_users (band_id, user_id) values ('$user_id', '$band_id')"));
        }
    }
}
