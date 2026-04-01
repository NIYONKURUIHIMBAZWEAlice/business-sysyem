<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    if (!Schema::hasColumn('sales', 'payment_method')) {
        Schema::table('sales', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'mobile_money'])->default('cash')->after('total_amount');
        });
    }
}

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });
    }
};