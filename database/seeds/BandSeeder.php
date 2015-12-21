<?php

use Illuminate\Database\Seeder;

class BandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bands = [
            ['name' => 'Band of Brothers', 'members' => 2, 'albums' => 1],
            ['name' => 'Band of Sisters', 'members' => 1, 'albums' => 1],
            ['name' => 'Band of Founders', 'members' => 1, 'albums' => 0]
        ];
        foreach ($bands as $key => $band) {
            $name = $band['name'];
            $members = $band['members'];
            $albums = $band['albums'];
            $now = date('Y-m-d H:i:s');
            DB::insert(DB::raw("insert into bands (name, members, albums, created_at) values ('$name', '$members', '$albums', '$now')"));
        }
    }
}
