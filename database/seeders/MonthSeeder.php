<?php

namespace Database\Seeders;

use App\Models\Month;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list = ['Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 'July', 'Ogos', 'September', 'Oktober', 'November', 'Disember'];
        foreach($list as $item){
            Month::create(['name' => $item]);
        }
    }
}
