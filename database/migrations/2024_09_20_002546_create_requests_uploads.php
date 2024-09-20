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
        Schema::create('requests_uploads', function (Blueprint $table) {
            $table->integer('id_request')->primary();
            $table->uuid('id_requesting_user');
            $table->uuid('id_analysis_user');
            $table->integer('status');
            $table->string('observation');
            $table->string('description');
            $table->timestamps();

            $table->foreign('id_requesting_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_analysis_user')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests_uploads');
    }
};
