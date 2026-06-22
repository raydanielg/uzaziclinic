<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterEmergencyContactLength extends Migration
{
    public function up()
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite: recreate table with new column size
            $columns = DB::select("PRAGMA table_info(patients)");
            $columnDefs = [];
            $columnNames = [];

            foreach ($columns as $col) {
                $columnNames[] = $col->name;
                $def = "{$col->name} {$col->type}";
                
                if ($col->name === 'emergency_contact') {
                    $def = "emergency_contact VARCHAR(255)";
                }
                
                if ($col->notnull == 1 && $col->dflt_value === null && $col->name !== 'id') {
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
            
            // Disable foreign keys temporarily
            DB::statement('PRAGMA foreign_keys = OFF');
            
            DB::statement("ALTER TABLE patients RENAME TO patients_old");
            DB::statement("CREATE TABLE patients (" . implode(', ', $columnDefs) . ")");
            DB::statement("INSERT INTO patients ({$colList}) SELECT {$colList} FROM patients_old");
            DB::statement("DROP TABLE patients_old");
            
            // Re-enable foreign keys
            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            // MySQL/PostgreSQL: use raw SQL instead of change() to avoid Doctrine DBAL issues
            DB::statement('ALTER TABLE patients MODIFY COLUMN emergency_contact VARCHAR(255) NULL');
        }
    }

    public function down()
    {
        // Skip - reverting column length is rarely needed
    }
}
