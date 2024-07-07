<?php

namespace Database\Seeders;

use Brick\Math\BigNumber;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class studentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('student')->insert([
            'name' => Str::random(10),
            'acadimc_year' =>random_int(1,4),
            'type'=>'student',
            'department'=>'cs',
        ]);
    }
}
