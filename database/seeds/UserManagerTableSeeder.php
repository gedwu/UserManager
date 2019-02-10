<?php

use Illuminate\Database\Seeder;

class UserManagerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\UserManager\UserManager::class, 10)->create();
    }
}
