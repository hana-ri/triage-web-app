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
            $table->string('name', 255);
            $table->integer('age');
            $table->enum('gender', ['male', 'female']);
            $table->decimal('sbp', 8, 2);
            $table->decimal('dbp', 8, 2);
            $table->decimal('hr', 8, 2);
            $table->decimal('rr', 8, 2);
            $table->decimal('bt', 8, 2);
            $table->decimal('saturation', 8, 2);
            // $table->integer('patients_number_per_hour');
            // $table->enum('hospital_type', ['local', 'regional']);
            // $table->enum('arrival_mode', ['public ambulance', 'private ambulance', 'private vehicle', 'walking', 'other']);
            // $table->boolean('injury');
            // $table->enum('AVPU_scale', ['alert', 'verbal responsive', 'painfully responsive', 'unresponsive']);
            // $table->integer('nrs_pain');
            $table->boolean('triage_device');
            $table->string('prediction');
            $table->string('validation');
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
