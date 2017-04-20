<?php

use Illuminate\Database\Seeder;

class typetravail_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('typetravail')->insert([
            'job' => 'Oil Change',
        ]);
        DB::table('typetravail')->insert([
            'job' => 'Tire Change',
        ]);
        DB::table('typetravail')->insert([
            'job' => 'Brake',
        ]);
        DB::table('typetravail')->insert([
            'job' => 'Suspension',
        ]);
        DB::table('typetravail')->insert([
            'job' => 'Direction',
        ]);
        DB::table('typetravail')->insert([
            'job' => 'Electrical',
        ]);
        DB::table('typetravail')->insert([
            'job' => 'Inspection',
        ]);
        DB::table('typetravail')->insert([
            'job' => 'Charge System',
        ]);
    }
}
