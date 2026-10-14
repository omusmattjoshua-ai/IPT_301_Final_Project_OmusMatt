<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lab_test_id')->constrained()->restrictOnDelete();
            $table->string('result_value');
            $table->text('remarks')->nullable();
            $table->date('result_date');
            $table->timestamps();
            $table->unique(['lab_order_id', 'lab_test_id']);
            $table->index('lab_test_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_results');
    }
};
