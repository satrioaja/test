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
        Schema::create('data_latihs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->double('open');
            $table->double('high');
            $table->double('low');
            $table->double('close');
            $table->double('volume');
            $table->double('market_cap');
            $table->foreignId('pelatihan_id')->constrained('pelatihans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_latihs');
    }
};
