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
        Schema::table('seo_tags', function (Blueprint $table) {
            $table->dropColumn(['schema_type', 'schema_name','schema_description','schema_url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_tags', function (Blueprint $table) {
            $table->string('schema_type')->nullable();
            $table->string('schema_name')->nullable();
            $table->text('schema_description')->nullable();
            $table->text('schema_url')->nullable();
        });
    }
};
