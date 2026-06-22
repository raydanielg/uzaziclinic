<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Doctor;
use App\Models\Appointment;

$doctor = Doctor::whereHas('user', function($q) {
    $q->where('email', 'doctor@afyacare.com');
})->first();

if ($doctor) {
    echo "Doctor ID: " . $doctor->id . "\n";
    $count = Appointment::whereDate('appointment_date', today())->update(['doctor_id' => $doctor->id]);
    echo "Updated " . $count . " appointments for doctor queue.\n";
    
    // Show current queue stats
    $total = Appointment::whereDate('appointment_date', today())->where('doctor_id', $doctor->id)->count();
    $withDoctor = Appointment::whereDate('appointment_date', today())
        ->where('doctor_id', $doctor->id)
        ->where('current_stage', 'with_doctor')
        ->count();
    echo "Total appointments today: " . $total . "\n";
    echo "With doctor stage: " . $withDoctor . "\n";
} else {
    echo "Doctor not found!\n";
}
