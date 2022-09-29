<?php

use App\Models\Paiment;
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
        Schema::create('paie_regularisations', function (Blueprint $table) {
            $table->id();
            $table->float('amount')->default(0);
            $table->foreignIdFor(Paiment::class)->constrained();
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
        Schema::dropIfExists('paie_regularisations');
    }
};
