<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number_paiment')->nullable();
            $table->unsignedBigInteger('scolary_year_id')->index('inscriptions_scolary_year_id_foreign');
            $table->unsignedBigInteger('cost_inscription_id')->index('inscriptions_cost_inscription_id_foreign');
            $table->unsignedBigInteger('student_id')->index('inscriptions_student_id_foreign');
            $table->unsignedBigInteger('user_id')->index('inscriptions_user_id_foreign');
            $table->boolean('is_paied')->default(false);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('inscriptions');
    }
}
