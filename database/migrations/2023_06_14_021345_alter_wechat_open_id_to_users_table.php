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
        Schema::table('users', function (Blueprint $table) {
            $table->string('wechat_open_id')->comment('微信openId')->after('email');
            $table->string('wechat_union_id')->comment('微信unionId')->after('wechat_open_id');
            $table->dropColumn(['wechat']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['wechat_open_id', 'wechat_union_id']);
            $table->string('wechat',255)->nullable()->after('email');
        });
    }
};
