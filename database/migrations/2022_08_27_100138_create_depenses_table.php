<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->double('amount', 8, 2)->default(0);
            $table->string('emise')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_trashed')->default(false);
            $table->unsignedBigInteger('depense_souce_id')->index('depenses_depense_souce_id_foreign');
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
        Schema::dropIfExists('depenses');
    }
}
