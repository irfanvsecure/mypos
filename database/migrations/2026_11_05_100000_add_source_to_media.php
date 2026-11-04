<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media', function (Blueprint $t) {
            $t->string('source_url', 2048)->nullable()->after('variants');
            $t->string('uploaded_via', 30)->nullable()->after('source_url');   // mcp_url | mcp_base64
        });
    }

    public function down(): void
    {
        Schema::table('media', fn (Blueprint $t) => $t->dropColumn(['source_url', 'uploaded_via']));
    }
};
