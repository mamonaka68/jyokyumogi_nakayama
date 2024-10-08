<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'category' => '寿司',
        ];
        DB::table('genres')->insert($param);

        $param = [
            'category' => '焼肉',
        ];
        DB::table('genres')->insert($param);

        $param = [
            'category' => '居酒屋',
        ];
        DB::table('genres')->insert($param);

        $param = [
            'category' => 'イタリアン',
        ];
        DB::table('genres')->insert($param);

        $param = [
            'category' => 'ラーメン',
        ];
        DB::table('genres')->insert($param);
    }
}
