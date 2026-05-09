<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameAndPhoneToPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'name')) {
                $table->string('name')->after('user_id')->nullable();
            }
            if (!Schema::hasColumn('patients', 'phone')) {
                $table->string('phone', 20)->after('name')->nullable();
            }
            if (!Schema::hasColumn('patients', 'gender')) {
                $table->string('gender', 10)->after('phone')->nullable();
            }
            if (!Schema::hasColumn('patients', 'status')) {
                $table->string('status')->after('gender')->default('active');
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
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['name', 'phone', 'gender', 'status']);
        });
    }
}
