<?php

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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('starting_date');
            $table->date('ending_date');
            $table->text('description');
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('manager_id');
            $table->unsignedBigInteger('developer_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('manager_id')->references('id')->on('users');
            $table->foreign('developer_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
