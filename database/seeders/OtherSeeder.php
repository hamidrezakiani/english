<?php

namespace Database\Seeders;

use App\Models\Other;
use Illuminate\Database\Seeder;

class OtherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Other::create([
            'key' => 'WordTestHelp',
            'value' => '',
        ]);
        Other::create([
            'key' => 'ReadingTestHelp',
            'value' => '',
        ]);
        Other::create([
            'key' => 'About',
            'value' => '',
        ]);
        Other::create([
            'key' => 'Support',
            'value' => '',
        ]);
        Other::create([
            'key' => 'Planning',
            'value' => '',
        ]);
    }
}
