<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
		{
		// 他のSeederもここで呼び出します
		
		    $this->call(EmployeesTableSeeder::class);
		
		    // \App\Models\User::factory(10)->create(); // ダミーユーザーをファクトリで作る場合の例
		    // $this->call(OtherSeeder::class);


        // User::factory(10)->create();
    }
}
