<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('business')->nullable();
            $table->string('phone', 40);
            $table->string('email')->nullable();
            $table->string('type')->nullable();
            $table->text('message')->nullable();
            $table->string('page')->nullable();
            $table->string('referrer', 500)->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
