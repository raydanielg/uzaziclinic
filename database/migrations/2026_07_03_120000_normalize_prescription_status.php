<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Convert legacy 'active' status to 'pending' so the model and database agree
        DB::table('prescriptions')->where('status', 'active')->update(['status' => 'pending']);

        // Update the default value for new prescriptions
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE prescriptions MODIFY COLUMN status VARCHAR(255) NOT NULL DEFAULT 'pending'");
        } else {
            Schema::table('prescriptions', function (Blueprint $table) {
                $table->string('status')->default('pending')->change();
            });
        }
    }

    public function down(): void
    {
        DB::table('prescriptions')->where('status', 'pending')->update(['status' => 'active']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE prescriptions MODIFY COLUMN status VARCHAR(255) NOT NULL DEFAULT 'active'");
        } else {
            Schema::table('prescriptions', function (Blueprint $table) {
                $table->string('status')->default('active')->change();
            });
        }
    }
};
