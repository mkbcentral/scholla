<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToInscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->foreign(['scolary_year_id'])->references(['id'])->on('scolary_years');
            $table->foreign(['user_id'])->references(['id'])->on('users');
            $table->foreign(['cost_inscription_id'])->references(['id'])->on('cost_inscriptions');
            $table->foreign(['student_id'])->references(['id'])->on('students');
            $table->foreign(['classe_id'])->references(['id'])->on('classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->dropForeign('inscriptions_scolary_year_id_foreign');
            $table->dropForeign('inscriptions_user_id_foreign');
            $table->dropForeign('inscriptions_cost_inscription_id_foreign');
            $table->dropForeign('inscriptions_student_id_foreign');
            $table->dropForeign('inscriptions_classe_id_foreign');
        });
    }
}
