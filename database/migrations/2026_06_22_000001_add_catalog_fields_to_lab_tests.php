<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCatalogFieldsToLabTests extends Migration
{
    public function up()
    {
        Schema::table('lab_tests', function (Blueprint $table) {
            if (!Schema::hasColumn('lab_tests', 'name')) {
                $table->string('name')->nullable()->after('test_name');
            }
            if (!Schema::hasColumn('lab_tests', 'category')) {
                $table->string('category')->nullable()->after('name');
            }
            if (!Schema::hasColumn('lab_tests', 'sample_type')) {
                $table->string('sample_type')->nullable()->after('category');
            }
            if (!Schema::hasColumn('lab_tests', 'price')) {
                $table->decimal('price', 10, 2)->default(0)->after('cost');
            }
            if (!Schema::hasColumn('lab_tests', 'turnaround_time')) {
                $table->string('turnaround_time')->nullable()->after('price');
            }
        });

        // Make patient_id nullable for catalog entries
        Schema::table('lab_tests', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('lab_tests', function (Blueprint $table) {
            $table->dropColumn(['name', 'category', 'sample_type', 'price', 'turnaround_time']);
        });
    }
}
