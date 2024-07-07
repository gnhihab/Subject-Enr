<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class subjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subject')->insert([
            'name' => Str::random(10),
            'acadimc_year' =>random_int(1,4),
            'credit' =>random_int(2,3),
            'dr_name'=>Str::random(6),
            'department'=>'cs',
        ]);
    }
}
