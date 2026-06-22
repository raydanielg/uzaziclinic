<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddCatalogFieldsToLabTests extends Migration
{
    public function up()
    {
        $driver = DB::getDriverName();
        $columns = $this->getColumns();

        // Add new columns using raw SQL to avoid Doctrine DBAL
        $newColumns = [
            'name' => 'VARCHAR(255)',
            'category' => 'VARCHAR(255)',
            'sample_type' => 'VARCHAR(255)',
            'price' => 'DECIMAL(10,2)',
            'turnaround_time' => 'VARCHAR(255)'
        ];

        foreach ($newColumns as $colName => $colType) {
            if (!in_array($colName, $columns)) {
                if ($driver === 'sqlite') {
                    DB::statement("ALTER TABLE lab_tests ADD COLUMN {$colName} {$colType}");
                } else {
                    // MySQL/PostgreSQL use Laravel Schema
                    Schema::table('lab_tests', function (Blueprint $table) use ($colName) {
                        switch ($colName) {
                            case 'name':
                                $table->string('name')->nullable()->after('test_name');
                                break;
                            case 'category':
                                $table->string('category')->nullable()->after('name');
                                break;
                            case 'sample_type':
                                $table->string('sample_type')->nullable()->after('category');
                                break;
                            case 'price':
                                $table->decimal('price', 10, 2)->default(0)->after('cost');
                                break;
                            case 'turnaround_time':
                                $table->string('turnaround_time')->nullable()->after('price');
                                break;
                        }
                    });
                }
            }
        }

        // Make patient_id nullable
        if ($driver === 'sqlite') {
            $this->makePatientIdNullableForSQLite();
        } elseif ($driver === 'mysql') {
            DB::statement('ALTER TABLE lab_tests MODIFY COLUMN patient_id BIGINT UNSIGNED NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE lab_tests ALTER COLUMN patient_id DROP NOT NULL');
        }
    }

    private function getColumns()
    {
        $driver = DB::getDriverName();
        $columns = [];

        if ($driver === 'sqlite') {
            $results = DB::select("PRAGMA table_info(lab_tests)");
            foreach ($results as $col) {
                $columns[] = $col->name;
            }
        } else {
            // Fallback for MySQL/PostgreSQL - use raw query to avoid Doctrine
            $results = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'lab_tests' AND TABLE_SCHEMA = DATABASE()");
            foreach ($results as $col) {
                $columns[] = $col->COLUMN_NAME;
            }
        }

        return $columns;
    }

    private function makePatientIdNullableForSQLite()
    {
        // Check if already nullable in SQLite
        $results = DB::select("PRAGMA table_info(lab_tests)");
        foreach ($results as $col) {
            if ($col->name === 'patient_id' && $col->notnull == 0) {
                return; // Already nullable
            }
        }

        // Recreate table to make patient_id nullable
        $columns = DB::select("PRAGMA table_info(lab_tests)");
        $columnDefs = [];
        $columnNames = [];

        foreach ($columns as $col) {
            $columnNames[] = $col->name;
            $def = "{$col->name} {$col->type}";
            if ($col->name === 'patient_id') {
                $def = "patient_id INTEGER";
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

        DB::statement("ALTER TABLE lab_tests RENAME TO lab_tests_old");
        DB::statement("CREATE TABLE lab_tests (" . implode(', ', $columnDefs) . ")");
        DB::statement("INSERT INTO lab_tests ({$colList}) SELECT {$colList} FROM lab_tests_old");
        DB::statement("DROP TABLE lab_tests_old");
    }

    public function down()
    {
        // Note: SQLite does not support dropping columns natively
        // For development/testing, we just drop the added columns if supported
        $driver = DB::getDriverName();
        if ($driver !== 'sqlite') {
            Schema::table('lab_tests', function (Blueprint $table) {
                $table->dropColumn(['name', 'category', 'sample_type', 'price', 'turnaround_time']);
            });
        }
    }
}
