<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('collection_name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->unsignedInteger('size');
            $table->string('disk');
            $table->string('conversions_disk')->nullable();
            $table->json('manipulations')->nullable();
            $table->json('custom_properties')->nullable();
            $table->json('responsive_urls')->nullable();
            $table->integer('order_column')->nullable();
            $table->timestamps();

            $table->index(['model_type', 'model_id', 'collection_name', 'order_column']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
