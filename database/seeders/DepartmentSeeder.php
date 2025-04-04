<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stringable;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
            ],
        [
            'name' => 'Fashion',
            'slug' => 'fashion',
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Home, Garden & Tools',
            'slug' => Str::slug('home, garden & tools'),
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Books & Audible',
            'slug' => Str::slug('books & audible'),
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Health & Beauty',
            'slug' => Str::slug('health & beauty'),
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]];

        DB::table('departments')->insert($departments);
    }
}
