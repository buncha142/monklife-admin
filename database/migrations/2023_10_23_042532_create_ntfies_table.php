<?php

use App\Models\User;
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
        Schema::create('ntfies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->longText('image')->nullable();
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('passenger')->nullable();
            $table->timestamp('published_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ntfies');
    }
};
