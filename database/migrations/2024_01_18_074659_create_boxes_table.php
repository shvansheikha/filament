<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->id();
            $table->integer('kind')->nullable();
            $table->string('title')->nullable();
            $table->string('mobile')->nullable();
            $table->string('location')->nullable();
            $table->text('address')->nullable();
            $table->integer('arena')->nullable();
            $table->integer('built')->nullable();
            $table->integer('mortgage')->nullable();
            $table->integer('rent')->nullable();
            $table->integer('box_number')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('price')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('area_id')->constrained()->cascadeOnDelete();
            $table->foreignId('part_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boxes');
    }
};
