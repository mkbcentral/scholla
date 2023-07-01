<?php

use App\Models\School;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('type_other_costs', function (Blueprint $table) {
            $table->foreignIdFor(School::class)->nullable()->after('name')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('type_other_costs', function (Blueprint $table) {
            $table->dropColumn('school_id');
        });
    }
};
