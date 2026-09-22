<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->nullable()->after('id');
            $table->string('surname')->nullable()->after('name');
            $table->string('nickname')->nullable()->after('surname');
            $table->string('phone', 20)->nullable()->after('nickname');
            $table->string('line_id')->nullable()->after('phone');
            $table->date('dob')->nullable()->after('line_id');
            $table->date('doo')->nullable()->after('dob');
            $table->boolean('active')->default(true)->after('password');
            $table->string('avatar')->nullable()->after('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'surname', 'nickname', 'phone', 'line_id', 'dob', 'doo', 'active', 'avatar']);
        });
    }
};
