<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = DB::table('roles')->where('name','user')->first();

        $userId = DB::table('users')->insert([
            'name' => 'yones',
            'lastname' => 'yones',
            'email' => 'yones@mail.cc',
            'password' => Hash::make('yones'),
            'wallet_id'=> '2',
            'role_id'=> $role->id,
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        DB::table('wallets')->insert([
            'argent' => 500.00,
            // 'user_id' => $userId,
        ]);
    }
}
