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
            $table->integer('dark_mode')->after('last_login_ip')->default(0);
            $table->string('sidebar_theam')->after('dark_mode')->default('dark');
            $table->string('sidebar_color')->after('sidebar_theam')->default('primary');
            $table->string('sidebar_layout')->after('sidebar_color')->default('layout-fixed');
            $table->string('nav_color')->after('sidebar_layout')->default('navbar-white');
            $table->string('nav_layout')->after('nav_color')->nullable();
            $table->string('footer_layout')->after('nav_layout')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['dark_mode', 'sidebar_theam', 'sidebar_color','sidebar_layout','nav_color','nav_layout','footer_layout']);
        });
    }
};
