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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('Haciendo');
            $table->boolean('urgent')->default(false);
            $table->tinyInteger('progress')->default(0);
            $table->unsignedInteger('order_column')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
