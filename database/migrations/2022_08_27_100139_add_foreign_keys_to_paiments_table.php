<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPaimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paiments', function (Blueprint $table) {
            $table->foreign(['scolary_year_id'])->references(['id'])->on('scolary_years');
            $table->foreign(['user_id'])->references(['id'])->on('users');
            $table->foreign(['cost_general_id'])->references(['id'])->on('cost_generals');
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
        Schema::table('paiments', function (Blueprint $table) {
            $table->dropForeign('paiments_scolary_year_id_foreign');
            $table->dropForeign('paiments_user_id_foreign');
            $table->dropForeign('paiments_cost_general_id_foreign');
            $table->dropForeign('paiments_student_id_foreign');
            $table->dropForeign('paiments_classe_id_foreign');
        });
    }
}
