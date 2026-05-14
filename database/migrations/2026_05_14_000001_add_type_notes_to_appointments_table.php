<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeNotesToAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'type')) {
                $table->string('type')->default('General Consultation')->after('symptoms');
            }
            if (!Schema::hasColumn('appointments', 'notes')) {
                $table->text('notes')->nullable()->after('type');
            }
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['type', 'notes']);
        });
    }
}
