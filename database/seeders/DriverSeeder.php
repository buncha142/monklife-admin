<?php

namespace Database\Seeders;

use App\Models\CRS\Driver;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DriverSeeder extends Seeder
{
    /**
     * ข้อมูลคนขับ (คนขับคือ User ที่มี record ในตาราง drivers)
     */
    public function run(): void
    {
        $drivers = [
            ['email' => 'driver1@monklife.test', 'name' => 'สมชาย', 'surname' => 'ใจดี', 'nickname' => 'ชาย', 'phone' => '0810000001', 'is_default' => true],
            ['email' => 'driver2@monklife.test', 'name' => 'สมศักดิ์', 'surname' => 'ขับดี', 'nickname' => 'ศักดิ์', 'phone' => '0810000002', 'is_default' => false],
        ];

        foreach ($drivers as $data) {
            $user = User::updateOrCreate(['email' => $data['email']], [
                'status' => 'อุบาสก',
                'name' => $data['name'],
                'surname' => $data['surname'],
                'nickname' => $data['nickname'],
                'phone' => $data['phone'],
                'active' => true,
                'password' => Hash::make('password'),
            ]);
            $user->forceFill(['email_verified_at' => now()])->save();
            $user->syncRoles('Member');

            Driver::updateOrCreate(['user_id' => $user->id], [
                'is_active' => true,
                'is_default' => $data['is_default'],
            ]);
        }
    }
}
