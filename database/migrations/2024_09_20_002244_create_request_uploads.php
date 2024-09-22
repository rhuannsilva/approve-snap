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
        Schema::create('request_uploads', function (Blueprint $table) {
            $table->increments('id_request');
            $table->uuid('id_requesting_user');
            $table->uuid('id_analysis_user')->nullable();
            $table->integer('status');
            $table->string('observation')->nullable();
            $table->string('description')->nullable();
            $table->date('create_date')->nullable();
            $table->date('edit_date')->nullable();
            $table->foreign('id_requesting_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_analysis_user')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_uploads');
    }
};
