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
        Schema::create('enseignats', function (Blueprint $table) {
            
                $table->id();
                $table->string('nom');
                $table->string('prenom');
                $table->string('adress');
                $table->string('name_img')->nullable();
                $table->binary('image')->nullable();
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
        Schema::dropIfExists('enseignats');
    }
};
