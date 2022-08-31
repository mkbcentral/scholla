<?php

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
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->boolean('is_bank')->default(false)->after('is_paied');
            $table->boolean('is_fonctionnement')->default(false)->after('is_bank');
            $table->boolean('is_depense')->default(false)->after('is_fonctionnement');
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
            $table->dropColumn('is_bank');
            $table->dropColumn('is_fonctionnement');
            $table->dropColumn('is_depense');
        });
    }
};
