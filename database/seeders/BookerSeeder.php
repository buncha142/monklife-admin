<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BookerSeeder extends Seeder
{
    /**
     * ข้อมูลผู้จอง (สมาชิก role Member)
     */
    public function run(): void
    {
        $bookers = [
            ['email' => 'member1@monklife.test', 'status' => 'พระ', 'name' => 'พระมหาสมปอง', 'surname' => 'ธมฺมวโร', 'nickname' => 'ปอง', 'doo' => '2010-07-15'],
            ['email' => 'member2@monklife.test', 'status' => 'พระ', 'name' => 'พระสมบัติ', 'surname' => 'ปญฺญาวโร', 'nickname' => 'บัติ', 'doo' => '2015-07-20'],
            ['email' => 'member3@monklife.test', 'status' => 'อุบาสก', 'name' => 'ประเสริฐ', 'surname' => 'ศรีสุข', 'nickname' => 'เสริฐ', 'doo' => null],
            ['email' => 'member4@monklife.test', 'status' => 'อุบาสิกา', 'name' => 'สมศรี', 'surname' => 'มีบุญ', 'nickname' => 'ศรี', 'doo' => null],
        ];

        foreach ($bookers as $i => $data) {
            $user = User::updateOrCreate(['email' => $data['email']], $data + [
                'phone' => sprintf('08200000%02d', $i + 1),
                'active' => true,
                'password' => Hash::make('password'),
            ]);
            $user->forceFill(['email_verified_at' => now()])->save();
            $user->syncRoles('Member');
        }
    }
}
