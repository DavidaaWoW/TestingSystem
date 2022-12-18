<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('test_statuses')->insert([
            'id' => uniqid(),
            'name' => 'not available'
        ]);

        DB::table('test_statuses')->insert([
            'id' => uniqid(),
            'name' => 'available'
        ]);

        DB::table('test_statuses')->insert([
            'id' => uniqid(),
            'name' => 'in progress'
        ]);

        DB::table('test_statuses')->insert([
            'id' => uniqid(),
            'name' => 'failed'
        ]);

        DB::table('test_statuses')->insert([
            'id' => uniqid(),
            'name' => 'completed'
        ]);
    }
}
