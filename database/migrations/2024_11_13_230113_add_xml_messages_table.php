<?php

declare(strict_types=1);

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
        Schema::create('xml_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('image_priority')->nullable(false);
            $table->string('title')->nullable(true);
            $table->string('subtitle')->nullable(true);
            $table->string('button_link')->nullable(true);
            $table->string('img_link');
            $table->string('message_channel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xml_messages');
    }
};
