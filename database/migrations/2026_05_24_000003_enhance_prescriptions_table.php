<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('prescriptions', 'dispensed_by')) {
                // user_id of the pharmacist
                $table->unsignedBigInteger('dispensed_by')->nullable()->after('status');
            }
            if (!Schema::hasColumn('prescriptions', 'dispensed_at')) {
                $table->timestamp('dispensed_at')->nullable()->after('dispensed_by');
            }
            if (!Schema::hasColumn('prescriptions', 'total_cost')) {
                $table->decimal('total_cost', 10, 2)->default(0)->after('dispensed_at');
            }
        });

        Schema::table('prescription_items', function (Blueprint $table) {
            if (!Schema::hasColumn('prescription_items', 'medicine_id')) {
                $table->unsignedBigInteger('medicine_id')->nullable()->after('prescription_id')->index();
            }
            if (!Schema::hasColumn('prescription_items', 'quantity')) {
                $table->integer('quantity')->default(1)->after('medicine_name');
            }
            if (!Schema::hasColumn('prescription_items', 'unit_price')) {
                $table->decimal('unit_price', 10, 2)->default(0)->after('quantity');
            }
            if (!Schema::hasColumn('prescription_items', 'dispensed')) {
                $table->boolean('dispensed')->default(false)->after('instructions');
            }
        });
    }

    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            foreach (['dispensed_by','dispensed_at','total_cost'] as $col) {
                if (Schema::hasColumn('prescriptions', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
        Schema::table('prescription_items', function (Blueprint $table) {
            foreach (['medicine_id','quantity','unit_price','dispensed'] as $col) {
                if (Schema::hasColumn('prescription_items', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
