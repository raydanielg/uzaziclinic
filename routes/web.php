<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    }
    return view('welcome');
});

Route::get('/landing', function () {
    return view('welcome');
})->name('landing');

Route::get('/home', function() {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();
    
    // Admin check
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    // Role-based redirect
    if ($user->role) {
        switch ($user->role->name) {
            case 'doctor':
                return redirect()->route('doctor.dashboard');
            case 'nurse':
                return redirect()->route('nurse.dashboard');
            case 'pharmacist':
                return redirect()->route('pharmacist.dashboard');
            case 'lab_tech':
                return redirect()->route('lab.dashboard');
            case 'accountant':
                return redirect()->route('accountant.dashboard');
            case 'receptionist':
                return redirect()->route('receptionist.dashboard');
            case 'customer':
                return redirect()->route('patient.dashboard');
        }
    }

    return redirect('/')->with('error', 'Unauthorized access or role not found.');
})->name('home');

Route::post('/contact/submit', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.submit');

    // Doctor Routes
    Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/patients', [App\Http\Controllers\Doctor\DashboardController::class, 'patients'])->name('patients');
        Route::get('/patients/{id}', [App\Http\Controllers\Doctor\DashboardController::class, 'patientDetails'])->name('patients.details');
        Route::get('/prescriptions/add', [App\Http\Controllers\Doctor\DashboardController::class, 'addPrescription'])->name('prescriptions.add');
        Route::post('/prescriptions/store', [App\Http\Controllers\Doctor\DashboardController::class, 'storePrescription'])->name('prescriptions.store');
        Route::get('/lab-requests', [App\Http\Controllers\Doctor\DashboardController::class, 'labRequests'])->name('lab.requests');
        Route::post('/lab-requests/store', [App\Http\Controllers\Doctor\DashboardController::class, 'storeLabRequest'])->name('lab.requests.store');
        Route::get('/lab-results', [App\Http\Controllers\Doctor\DashboardController::class, 'labResults'])->name('lab.results');
        Route::get('/medical-records', [App\Http\Controllers\Doctor\DashboardController::class, 'medicalRecords'])->name('medical.records');
        Route::get('/schedule', [App\Http\Controllers\Doctor\DashboardController::class, 'schedule'])->name('schedule');
        Route::get('/chat', [App\Http\Controllers\Doctor\DashboardController::class, 'chat'])->name('chat');
        Route::get('/profile', [App\Http\Controllers\Doctor\DashboardController::class, 'profile'])->name('profile');
        Route::get('/password', [App\Http\Controllers\Doctor\DashboardController::class, 'password'])->name('password');
        Route::get('/reports', [App\Http\Controllers\Doctor\DashboardController::class, 'reports'])->name('reports');
    });

Route::middleware(['auth', 'role:nurse'])->prefix('nurse')->name('nurse.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Nurse\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/checkin', [App\Http\Controllers\Nurse\DashboardController::class, 'checkin'])->name('checkin');
    Route::get('/queue', [App\Http\Controllers\Nurse\DashboardController::class, 'queue'])->name('queue');
    Route::get('/vitals', [App\Http\Controllers\Nurse\DashboardController::class, 'vitals'])->name('vitals');
    Route::get('/appointments', [App\Http\Controllers\Nurse\DashboardController::class, 'appointments'])->name('appointments');
    Route::get('/assist-doctor', [App\Http\Controllers\Nurse\DashboardController::class, 'assistDoctor'])->name('assist-doctor');
    Route::get('/patients', [App\Http\Controllers\Nurse\DashboardController::class, 'patients'])->name('patients');
    Route::get('/bed-allocation', [App\Http\Controllers\Nurse\DashboardController::class, 'bedAllocation'])->name('bed-allocation');
    Route::get('/wards', [App\Http\Controllers\Nurse\DashboardController::class, 'wardManagement'])->name('wards');
    Route::get('/lab-collection', [App\Http\Controllers\Nurse\DashboardController::class, 'labCollection'])->name('lab-collection');
    Route::get('/medication', [App\Http\Controllers\Nurse\DashboardController::class, 'medication'])->name('medication');
    Route::get('/reports', [App\Http\Controllers\Nurse\DashboardController::class, 'reports'])->name('reports');
    Route::get('/profile', [App\Http\Controllers\Nurse\DashboardController::class, 'profile'])->name('profile');
    Route::get('/password', [App\Http\Controllers\Nurse\DashboardController::class, 'password'])->name('password');
});

Route::middleware(['auth', 'role:pharmacist'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Pharmacist\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/inventory', [App\Http\Controllers\Pharmacist\DashboardController::class, 'inventory'])->name('inventory');
    Route::get('/prescriptions', [App\Http\Controllers\Pharmacist\DashboardController::class, 'prescriptions'])->name('prescriptions');
    Route::get('/prescriptions/dispense/{id}', [App\Http\Controllers\Pharmacist\DashboardController::class, 'dispense'])->name('prescriptions.dispense');
    Route::get('/orders', [App\Http\Controllers\Pharmacist\DashboardController::class, 'orders'])->name('orders');
    Route::get('/suppliers', [App\Http\Controllers\Pharmacist\DashboardController::class, 'suppliers'])->name('suppliers');
    Route::get('/alerts', [App\Http\Controllers\Pharmacist\DashboardController::class, 'alerts'])->name('alerts');
    Route::get('/reports', [App\Http\Controllers\Pharmacist\DashboardController::class, 'reports'])->name('reports');
    Route::get('/profile', [App\Http\Controllers\Pharmacist\DashboardController::class, 'profile'])->name('profile');
    Route::get('/password', [App\Http\Controllers\Pharmacist\DashboardController::class, 'password'])->name('password');
});

Route::middleware(['auth', 'role:lab_tech'])->prefix('lab')->name('lab.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Lab\DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:accountant'])->prefix('accountant')->name('accountant.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Accountant\DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:receptionist'])->prefix('receptionist')->name('receptionist.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Receptionist\DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:customer'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Patient\DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::put('/{user}/role', [App\Http\Controllers\Admin\UserController::class, 'updateUserRole'])->name('role.update');
        Route::delete('/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
        Route::get('/roles', [App\Http\Controllers\Admin\UserController::class, 'roles'])->name('roles');
        Route::put('/roles/{role}', [App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('roles.update');
        Route::delete('/roles/{role}', [App\Http\Controllers\Admin\UserController::class, 'destroyRole'])->name('roles.destroy');
        Route::get('/logs', [App\Http\Controllers\Admin\UserController::class, 'logs'])->name('logs');
    });

    // Patient Management
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PatientController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\PatientController::class, 'create'])->name('create');
        Route::get('/categories', [App\Http\Controllers\Admin\PatientController::class, 'categories'])->name('categories');
        Route::get('/history', [App\Http\Controllers\Admin\PatientController::class, 'history'])->name('history');
    });

    // Doctor Management
    Route::prefix('doctors')->name('doctors.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DoctorController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\DoctorController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\DoctorController::class, 'store'])->name('store');
        Route::post('/from-user/{user}', [App\Http\Controllers\Admin\DoctorController::class, 'createProfileFromUser'])->name('from-user');
        Route::get('/schedules', [App\Http\Controllers\Admin\DoctorController::class, 'schedules'])->name('schedules');
        Route::get('/specializations', [App\Http\Controllers\Admin\DoctorController::class, 'specializations'])->name('specializations');
    });

    // Appointment Management
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AppointmentController::class, 'index'])->name('index');
        Route::get('/book', [App\Http\Controllers\Admin\AppointmentController::class, 'create'])->name('create');
        Route::post('/book', [App\Http\Controllers\Admin\AppointmentController::class, 'store'])->name('store');
        Route::post('/quick-patient', [App\Http\Controllers\Admin\AppointmentController::class, 'quickPatient'])->name('quick-patient');
        Route::get('/upcoming', [App\Http\Controllers\Admin\AppointmentController::class, 'upcoming'])->name('upcoming');
        Route::get('/history', [App\Http\Controllers\Admin\AppointmentController::class, 'history'])->name('history');
        Route::get('/today', [App\Http\Controllers\Admin\AppointmentController::class, 'today'])->name('today');
        Route::get('/cancelled', [App\Http\Controllers\Admin\AppointmentController::class, 'cancelled'])->name('cancelled');
    });

    // Pharmacy & Inventory
    Route::prefix('pharmacy')->name('pharmacy.')->group(function () {
        Route::get('/stock', [App\Http\Controllers\Admin\PharmacyController::class, 'stock'])->name('stock');
        Route::get('/create', [App\Http\Controllers\Admin\PharmacyController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\PharmacyController::class, 'store'])->name('store');
        Route::delete('/stock/{medicine}', [App\Http\Controllers\Admin\PharmacyController::class, 'destroy'])->name('destroy');
        Route::get('/alerts', [App\Http\Controllers\Admin\PharmacyController::class, 'alerts'])->name('alerts');
        Route::get('/suppliers', [App\Http\Controllers\Admin\PharmacyController::class, 'suppliers'])->name('suppliers');
        Route::get('/orders', [App\Http\Controllers\Admin\PharmacyController::class, 'orders'])->name('orders');
        Route::get('/expiry', [App\Http\Controllers\Admin\PharmacyController::class, 'expiry'])->name('expiry');
    });

    // Lab Management
    Route::prefix('lab')->name('lab.')->group(function () {
        Route::get('/catalog', [App\Http\Controllers\Admin\LabController::class, 'catalog'])->name('catalog');
        Route::post('/catalog', [App\Http\Controllers\Admin\LabController::class, 'store'])->name('store');
        Route::delete('/catalog/{labTest}', [App\Http\Controllers\Admin\LabController::class, 'destroy'])->name('destroy');
        Route::get('/results', [App\Http\Controllers\Admin\LabController::class, 'results'])->name('results');
        Route::get('/equipment', [App\Http\Controllers\Admin\LabController::class, 'equipment'])->name('equipment');
        Route::post('/equipment', [App\Http\Controllers\Admin\LabController::class, 'storeEquipment'])->name('equipment.store');
        Route::delete('/equipment/{equipment}', [App\Http\Controllers\Admin\LabController::class, 'destroyEquipment'])->name('equipment.destroy');
        Route::get('/reports', [App\Http\Controllers\Admin\LabController::class, 'reports'])->name('reports');
    });

    // Medical Services
    Route::prefix('medical')->name('medical.')->group(function () {
        Route::get('/prescriptions', [App\Http\Controllers\Admin\MedicalServiceController::class, 'prescriptions'])->name('prescriptions');
        Route::get('/records', [App\Http\Controllers\Admin\MedicalServiceController::class, 'records'])->name('records');
        Route::get('/lab-results', [App\Http\Controllers\Admin\MedicalServiceController::class, 'labResults'])->name('lab-results');
    });

    // E-commerce / Store
    Route::prefix('store')->name('store.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\EcommerceController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\EcommerceController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\EcommerceController::class, 'store'])->name('store');
        Route::delete('/{product}', [App\Http\Controllers\Admin\EcommerceController::class, 'destroy'])->name('destroy');
        Route::get('/orders', [App\Http\Controllers\Admin\EcommerceController::class, 'orders'])->name('orders');
        Route::get('/categories', [App\Http\Controllers\Admin\EcommerceController::class, 'categories'])->name('categories');
        Route::get('/reviews', [App\Http\Controllers\Admin\EcommerceController::class, 'reviews'])->name('reviews');
    });

    // Payments & Billing
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/invoices', [App\Http\Controllers\Admin\FinanceController::class, 'invoices'])->name('invoices');
        Route::post('/invoices', [App\Http\Controllers\Admin\FinanceController::class, 'storeInvoice'])->name('invoices.store');
        Route::get('/receipts', [App\Http\Controllers\Admin\FinanceController::class, 'receipts'])->name('receipts');
        Route::get('/payments', [App\Http\Controllers\Admin\FinanceController::class, 'payments'])->name('payments');
        Route::get('/history', [App\Http\Controllers\Admin\FinanceController::class, 'history'])->name('history');
    });

    // Communication
    Route::prefix('communication')->name('communication.')->group(function () {
        Route::get('/chat', [App\Http\Controllers\Admin\ChatController::class, 'index'])->name('chat');
    });

    // Insurance
    Route::prefix('insurance')->name('insurance.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\InsuranceController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\InsuranceController::class, 'create'])->name('create');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('sales');
        Route::get('/patients', [App\Http\Controllers\Admin\ReportController::class, 'patients'])->name('patients');
        Route::get('/doctors', [App\Http\Controllers\Admin\ReportController::class, 'doctors'])->name('doctors');
        Route::get('/stock', [App\Http\Controllers\Admin\ReportController::class, 'stock'])->name('stock');
        Route::get('/revenue', [App\Http\Controllers\Admin\ReportController::class, 'revenue'])->name('revenue');
        Route::get('/appointments', [App\Http\Controllers\Admin\ReportController::class, 'appointments'])->name('appointments');
    });

    // System Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/general', [App\Http\Controllers\Admin\SettingController::class, 'general'])->name('general');
        Route::get('/email', [App\Http\Controllers\Admin\SettingController::class, 'email'])->name('email');
        Route::get('/sms', [App\Http\Controllers\Admin\SettingController::class, 'sms'])->name('sms');
        Route::get('/gateways', [App\Http\Controllers\Admin\SettingController::class, 'gateways'])->name('gateways');
        Route::get('/backup', [App\Http\Controllers\Admin\SettingController::class, 'backup'])->name('backup');
        Route::post('/update', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('update');
    });

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/send', [App\Http\Controllers\Admin\NotificationController::class, 'send'])->name('send');
        Route::get('/history', [App\Http\Controllers\Admin\NotificationController::class, 'history'])->name('history');
        Route::get('/email-templates', [App\Http\Controllers\Admin\NotificationController::class, 'emailTemplates'])->name('emailTemplates');
        Route::get('/sms-templates', [App\Http\Controllers\Admin\NotificationController::class, 'smsTemplates'])->name('smsTemplates');
    });
});
