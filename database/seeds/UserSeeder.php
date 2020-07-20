<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        		'name' => 'Default Admin',
        		'username' => 'admin',
        		'password' => bcrypt('admin'),
                'is_confidential_accessor' => null,
        		'is_admin' => true,
                'created_at' => date('Y-m-d H:i:s', strtotime('now')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('now'))
        	]);
    }
}
