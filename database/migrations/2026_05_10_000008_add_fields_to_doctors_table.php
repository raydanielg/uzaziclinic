<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            if (!Schema::hasColumn('doctors', 'name')) {
                $table->string('name')->after('user_id')->nullable();
            }
            if (!Schema::hasColumn('doctors', 'phone')) {
                $table->string('phone')->after('name')->nullable();
            }
            if (!Schema::hasColumn('doctors', 'status')) {
                $table->string('status')->after('phone')->default('active');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['name', 'phone', 'status']);
        });
    }
}
