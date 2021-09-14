<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('apps')->delete();

        $items = [
            ['title' => 'Hello Kitty App', 'status' => '1'],
            ['title' => 'Dating App', 'status' => '1'],
            ['title' => 'E-commerce App', 'status' => '1']
        ];
        foreach($items as $item)
        DB::table('apps')->insert($item);        
    }
}
