<?php

namespace Database\Seeders;

use App\Models\Favourite;
use App\Models\User;
use Illuminate\Database\Seeder;
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
        $i = 1;
        while($i<=2){
            $user = User::create([
                'name'=>'Name'.$i,
                'surname'=>'Surname'.$i,
                'middle_name'=>'Lastname'.$i,
                'email'=>'user@user.user'.$i,
                'phone'=>'7902111111'.$i,
                'password'=>Hash::make('11111111')
            ]);
            Favourite::create([
                'user_id'=>$user->id,
                'title'=>'Общее'
            ]);
            $i++;
        }
    }
}
