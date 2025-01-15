<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id('major_id');
            $table->string('major_name');
            $table->foreignId('department_id')->constrained('departments', 'department_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('majors');
    }
};
