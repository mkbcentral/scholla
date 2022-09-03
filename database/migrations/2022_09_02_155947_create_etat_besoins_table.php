<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etat_besoins', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('amount')->default(0);
            $table->string('emise')->nullable();
            $table->text('description');
            $table->boolean('is_trashed')->default(false);
            $table->boolean('active')->default(false);
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etat_besoins');
    }
};
