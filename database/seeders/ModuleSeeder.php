<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Saas\Database\Seeders\SaasDatabaseSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(config('app.mood')==="Saas" && isModuleActive("Saas")){
            $this->call(SaasDatabaseSeeder::class);
        }
    }
}
