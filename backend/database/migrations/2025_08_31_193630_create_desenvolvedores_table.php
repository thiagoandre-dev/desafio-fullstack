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
        Schema::create('desenvolvedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nivel_id')->constrained('niveis')->onDelete('cascade');
            $table->string('nome', 255);
            $table->char('sexo', 1);
            $table->date('data_nascimento');
            $table->string('hobby', 255)->nullable();
            $table->timestamps();

            $table->index('nivel_id');
            $table->index('nome');
            $table->index('sexo');
            $table->index('data_nascimento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desenvolvedors');
    }
};
