<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lab_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('lab_requests', 'appointment_id')) {
                $table->unsignedBigInteger('appointment_id')->nullable()->after('id')->index();
            }
            if (!Schema::hasColumn('lab_requests', 'technician_id')) {
                // user_id of the lab tech who processed it
                $table->unsignedBigInteger('technician_id')->nullable()->after('doctor_id');
            }
            if (!Schema::hasColumn('lab_requests', 'result_data')) {
                // structured results: [{test_name, value, unit, normal_range, flag}]
                $table->json('result_data')->nullable()->after('result_notes');
            }
            if (!Schema::hasColumn('lab_requests', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('result_data');
            }
            if (!Schema::hasColumn('lab_requests', 'sample_collected_at')) {
                $table->timestamp('sample_collected_at')->nullable()->after('completed_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('lab_requests', function (Blueprint $table) {
            foreach (['appointment_id','technician_id','result_data','completed_at','sample_collected_at'] as $col) {
                if (Schema::hasColumn('lab_requests', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
