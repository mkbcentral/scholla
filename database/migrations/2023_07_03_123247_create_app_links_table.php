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
        Schema::create('app_links', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->string('link')->nullable();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_links');
    }
};
