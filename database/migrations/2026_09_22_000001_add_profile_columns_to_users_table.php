<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * เพิ่มเฉพาะคอลัมน์ที่ยังไม่มี — ฐานข้อมูลบน server เดิมมีคอลัมน์เหล่านี้อยู่แล้ว (เพิ่มนอก migration)
     */
    public function up(): void
    {
        $columns = [
            'status' => fn (Blueprint $table) => $table->string('status')->nullable()->after('id'),
            'surname' => fn (Blueprint $table) => $table->string('surname')->nullable()->after('name'),
            'nickname' => fn (Blueprint $table) => $table->string('nickname')->nullable()->after('surname'),
            'phone' => fn (Blueprint $table) => $table->string('phone', 20)->nullable()->after('nickname'),
            'line_id' => fn (Blueprint $table) => $table->string('line_id')->nullable()->after('phone'),
            'dob' => fn (Blueprint $table) => $table->date('dob')->nullable()->after('line_id'),
            'doo' => fn (Blueprint $table) => $table->date('doo')->nullable()->after('dob'),
            'active' => fn (Blueprint $table) => $table->boolean('active')->default(true)->after('password'),
            'avatar' => fn (Blueprint $table) => $table->string('avatar')->nullable()->after('active'),
        ];

        foreach ($columns as $column => $define) {
            if (! Schema::hasColumn('users', $column)) {
                Schema::table('users', $define);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * ไม่ลบคอลัมน์ — บน server เดิมคอลัมน์เหล่านี้มีข้อมูลจริงอยู่ก่อน migration นี้
     */
    public function down(): void
    {
        //
    }
};
