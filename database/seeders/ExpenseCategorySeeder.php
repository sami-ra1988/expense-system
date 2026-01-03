<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['حمل و نقل', 'ایاب ذهاب', 'خرید تجهیزات'];

        foreach ($categories as $title) {
            ExpenseCategory::create(['title' => $title]);
        }

    }
}
