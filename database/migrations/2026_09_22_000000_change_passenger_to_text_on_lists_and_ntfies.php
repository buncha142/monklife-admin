<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * passenger เก็บเป็น JSON (array cast) ซึ่ง encode ภาษาไทยเป็น \uXXXX (6 ตัวอักษร/ตัว)
     * varchar(255) จึงเต็มเมื่อเลือกผู้โดยสารเพียง ~4-5 คน → SQLSTATE[22001] Data too long
     */
    public function up(): void
    {
        Schema::table('lists', function (Blueprint $table) {
            $table->text('passenger')->nullable()->change();
        });

        Schema::table('ntfies', function (Blueprint $table) {
            $table->text('passenger')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('lists', function (Blueprint $table) {
            $table->string('passenger')->nullable()->change();
        });

        Schema::table('ntfies', function (Blueprint $table) {
            $table->string('passenger')->nullable()->change();
        });
    }
};
