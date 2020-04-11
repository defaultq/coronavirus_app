<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GlobalData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_data', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('country',100)->nullable();
            $table->string('province')->nullable();
            $table->double('latitude',8,2)->nullable();
            $table->double('longitude',8,2)->nullable();
            $table->double('deaths')->nullable();
            $table->double('confirmed')->nullable();
            $table->double('recovered')->nullable();



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
        //
    }
}
