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
            $table->boolean('triage_vital_o2_device');
            $table->string('chief_complaint');
            $table->string('prediction_level');
            $table->string('validation');
            $table->string('note')->nullable();
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
