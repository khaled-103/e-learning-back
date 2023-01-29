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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('subtitle');
            $table->text('description');
            $table->unsignedDouble('price');
            $table->enum('level',['All Levels','Beginner','Medium','Advanced']);
            $table->string('image');
            $table->foreignId('oranization_id')->nullable()->constrained('orgnaizations')->nullonDelete();
            $table->foreignId('language_id')->nullable()->constrained('languages')->nullonDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullonDelete();
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
        Schema::dropIfExists('courses');
    }
};
