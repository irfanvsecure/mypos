<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Stable handle for a price, referenced from page content as {{price:key}} so each price is stored once. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pricing_plans', function (Blueprint $t) {
            $t->string('plan_key', 80)->nullable()->unique()->after('plan_group');
        });
    }

    public function down(): void
    {
        Schema::table('pricing_plans', function (Blueprint $t) {
            $t->dropUnique(['plan_key']);
            $t->dropColumn('plan_key');
        });
    }
};
