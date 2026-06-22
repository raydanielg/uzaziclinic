<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
        // Using raw SQL instead of change() to avoid Doctrine DBAL compatibility issues
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE lab_tests MODIFY COLUMN patient_id BIGINT UNSIGNED NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE lab_tests ALTER COLUMN patient_id DROP NOT NULL');
        } elseif ($driver === 'sqlite') {
            // SQLite: recreate table since ALTER COLUMN is limited
            // Or skip since SQLite foreign key enforcement is optional
            // We'll use a workaround by renaming and recreating
            $this->makePatientIdNullableForSQLite();
        }
    }

    private function makePatientIdNullableForSQLite()
    {
        // SQLite workaround: rename table, create new with nullable, copy data, drop old
        $columns = DB::select("PRAGMA table_info(lab_tests)");
        $columnDefs = [];
        $columnNames = [];

        foreach ($columns as $col) {
            $columnNames[] = $col->name;
            $def = "{$col->name} {$col->type}";
            if ($col->name === 'patient_id') {
                $def = "patient_id INTEGER"; // nullable in SQLite by default
            }
            if ($col->notnull == 1 && $col->name !== 'patient_id') {
                $def .= " NOT NULL";
            }
            if ($col->dflt_value !== null) {
                $def .= " DEFAULT {$col->dflt_value}";
            }
            if ($col->pk == 1) {
                $def .= " PRIMARY KEY AUTOINCREMENT";
            }
            $columnDefs[] = $def;
        }

        $colList = implode(', ', $columnNames);

        Schema::rename('lab_tests', 'lab_tests_old');
        DB::statement("CREATE TABLE lab_tests (" . implode(', ', $columnDefs) . ")");
        DB::statement("INSERT INTO lab_tests ({$colList}) SELECT {$colList} FROM lab_tests_old");
        Schema::drop('lab_tests_old');
    }

    public function down()
    {
        Schema::table('lab_tests', function (Blueprint $table) {
            $table->dropColumn(['name', 'category', 'sample_type', 'price', 'turnaround_time']);
        });
    }
}
