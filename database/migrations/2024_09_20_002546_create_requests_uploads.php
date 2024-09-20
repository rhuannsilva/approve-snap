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
            $table->id();
            $table->integer('id_requesting_user');
            $table->integer('status');
            $table->integer('id_analysis_user');
            $table->string('observation');
            $table->integer('observation');
            $table->timestamps();
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
