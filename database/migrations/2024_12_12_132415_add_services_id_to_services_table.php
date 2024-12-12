<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('services', function (Blueprint $table) {
        $table->string('services_id')->unique()->nullable();
    });
}

public function down()
{
    Schema::table('services', function (Blueprint $table) {
        $table->dropColumn('services_id');
    });
}
};