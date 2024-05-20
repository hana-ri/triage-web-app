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
        Schema::create('triage', function (Blueprint $table) {
            $table->id();
            $table->enum('hospital_type', ['local', 'regional']);
            $table->string('fullname', 255);
            $table->integer('age');
            $table->enum('gender', ['male', 'female']);
            $table->decimal('SBP', 8, 2);
            $table->decimal('DBP', 8, 2);
            $table->decimal('HR', 8, 2);
            $table->decimal('RR', 8, 2);
            $table->decimal('BT', 8, 2);
            $table->decimal('Saturation', 8, 2);
            $table->enum('arrival_mode', ['public ambulance', 'private ambulance', 'private vehicle', 'walking']);
            $table->boolean('injury');
            $table->enum('AVPU_scale', ['alert', 'verbal responsive', 'painfully responsive', 'unresponsive']);
            $table->boolean('is_pain');
            $table->integer('pain_scale');
            $table->integer('prediction_level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('triage');
    }
};
