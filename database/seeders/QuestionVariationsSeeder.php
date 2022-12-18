<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionVariationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_variations')->insert([
            'id' => uniqid(),
            'name' => 'one correct'
        ]);

        DB::table('question_variations')->insert([
            'id' => uniqid(),
            'name' => 'multiple correct'
        ]);
    }
}
