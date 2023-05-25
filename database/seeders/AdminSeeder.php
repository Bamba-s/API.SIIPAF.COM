<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = new User();
        $admin->name = 'Bamba';
        $admin->email = 'bamba.inf@gmail.com';
        $admin->password = Hash::make('0123456789');
        $admin->role = 'admin';
        $admin->save();
    }
}
