<?php

use App\Models\ScolaryYear;
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
        Schema::table('cost_inscriptions', function (Blueprint $table) {
            $table->foreignIdFor(ScolaryYear::class)->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cost_inscriptions', function (Blueprint $table) {
            $table->dropColumn('scolary_year_id');
        });
    }
};
