<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'current_stage')) {
                // workflow stage: with_doctor, awaiting_lab, lab_complete, awaiting_pharmacy, done
                $table->string('current_stage', 30)->default('with_doctor')->after('status')->index();
            }
            if (!Schema::hasColumn('appointments', 'chief_complaint')) {
                $table->text('chief_complaint')->nullable()->after('current_stage');
            }
            if (!Schema::hasColumn('appointments', 'vital_signs')) {
                $table->json('vital_signs')->nullable()->after('chief_complaint');
            }
            if (!Schema::hasColumn('appointments', 'queue_number')) {
                $table->string('queue_number', 20)->nullable()->after('vital_signs');
            }
            if (!Schema::hasColumn('appointments', 'received_by')) {
                // user_id of the receptionist who registered the visit
                $table->unsignedBigInteger('received_by')->nullable()->after('queue_number');
            }
            if (!Schema::hasColumn('appointments', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('received_by');
            }
        });

        // Backfill existing rows: completed → done; cancelled stays
        DB::table('appointments')->where('status', 'completed')->update(['current_stage' => 'done']);
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            foreach (['current_stage','chief_complaint','vital_signs','queue_number','received_by','completed_at'] as $col) {
                if (Schema::hasColumn('appointments', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
