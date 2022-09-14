<?php

use App\Models\Requisition;
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
        Schema::create('detail_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->float('amount',16)->default(0);
            $table->foreignIdFor(Requisition::class)->constrained();
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
        Schema::dropIfExists('detail_requisitions');
    }
};
