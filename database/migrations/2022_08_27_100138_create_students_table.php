<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->enum('gender', ['M', 'F']);
            $table->string('place_of_birth')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->unsignedBigInteger('classe_id')->index('students_classe_id_foreign');
            $table->unsignedBigInteger('student_responsable_id')->nullable()->index('students_student_responsable_id_foreign');
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
        Schema::dropIfExists('students');
    }
}
