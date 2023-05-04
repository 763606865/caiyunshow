<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('background_color', 45)->comment('背景颜色');
            $table->integer('web_weight')->nullable(false)->default(1920)->comment('pc宽/px');
            $table->integer('web_height')->nullable(false)->default(1080)->comment('pc高/px');
            $table->integer('h5_weight')->nullable(false)->default(750)->comment('h5宽/px');
            $table->integer('h5_height')->nullable(false)->default(500)->comment('h5高/px');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['background_color', 'web_weight', 'web_height', 'h5_weight', 'h5_height']);
        });
    }
};
