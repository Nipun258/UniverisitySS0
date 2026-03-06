<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds two new columns to the oauth_clients table:
     *   app_portal_url  – the public URL of the client app (shown as a link in the SSO portal)
     *   app_icon        – Font Awesome icon class (e.g. "fas fa-graduation-cap")
     */
    public function up(): void
    {
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->string('app_portal_url')->nullable()->after('redirect_uris')
                  ->comment('Public URL of the client application shown in the SSO App Portal');
            $table->string('app_icon')->nullable()->after('app_portal_url')
                  ->comment('Font Awesome icon class, e.g. fas fa-graduation-cap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->dropColumn(['app_portal_url', 'app_icon']);
        });
    }

    /**
     * Get the migration connection name.
     */
    public function getConnection(): ?string
    {
        return $this->connection ?? config('passport.connection');
    }
};
