<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UnitCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('started_at');// Doesn't support DATE_RFC3339_EXTENDED format yet
            $table->string('finished_at')->nullable();
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
        Schema::dropIfExists('unit_charges'); // Drop unit charges first due to foreign key constraint

    }
}
