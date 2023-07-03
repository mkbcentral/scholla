<?php

use App\Models\AppLink;
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
        Schema::create('sub_app_links', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('icon')->nullable();
            $table->string('link')->nullable();
            $table->foreignIdFor(AppLink::class)->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_app_links');
    }
};
