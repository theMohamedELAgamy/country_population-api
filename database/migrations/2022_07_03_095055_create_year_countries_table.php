<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use  App\Models\Country;
use  App\Models\Year;
class CreateYearCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('year_countries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('year');
            $table->string('country');
            // $table->foreignIdFor(Country::class,'country');
            // $table->foreignIdFor(Year::class,'year');
            $table->bigInteger('population');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('year_countries');
    }
}
