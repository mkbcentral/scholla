<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number_paiement')->nullable();
            $table->string('mounth_name')->nullable();
            $table->unsignedBigInteger('scolary_year_id')->index('paiments_scolary_year_id_foreign');
            $table->unsignedBigInteger('cost_general_id')->index('paiments_cost_general_id_foreign');
            $table->unsignedBigInteger('student_id')->index('paiments_student_id_foreign');
            $table->unsignedBigInteger('classe_id')->index('paiments_classe_id_foreign');
            $table->unsignedBigInteger('user_id')->index('paiments_user_id_foreign');
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
        Schema::dropIfExists('paiments');
    }
}
