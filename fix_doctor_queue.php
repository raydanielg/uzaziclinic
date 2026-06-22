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
    echo "Updated " . $count . " appointments successfully!\n";
} else {
    echo "Doctor not found!\n";
    echo "Available doctors:\n";
    foreach (Doctor::with('user')->get() as $d) {
        echo "  ID: " . $d->id . " | Email: " . ($d->user->email ?? 'N/A') . " | Name: " . $d->name . "\n";
    }
}
