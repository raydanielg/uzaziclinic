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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', function() {
    $user = auth()->user();
    if ($user && $user->role) {
        switch ($user->role->name) {
            case 'admin': return redirect()->route('admin.dashboard');
            case 'doctor': return redirect('/doctor/dashboard');
            case 'nurse': return redirect('/nurse/dashboard');
            case 'pharmacist': return redirect('/pharmacist/dashboard');
            case 'lab_tech': return redirect('/lab/dashboard');
            case 'accountant': return redirect('/accountant/dashboard');
            case 'receptionist': return redirect('/receptionist/dashboard');
            case 'customer': return redirect('/patient/dashboard');
        }
    }
    return redirect('/');
})->name('home');

Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
        Route::get('/roles', [App\Http\Controllers\Admin\UserController::class, 'roles'])->name('roles');
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
        Route::get('/schedules', [App\Http\Controllers\Admin\DoctorController::class, 'schedules'])->name('schedules');
        Route::get('/specializations', [App\Http\Controllers\Admin\DoctorController::class, 'specializations'])->name('specializations');
    });

    // Appointment Management
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AppointmentController::class, 'index'])->name('index');
        Route::get('/today', [App\Http\Controllers\Admin\AppointmentController::class, 'today'])->name('today');
        Route::get('/upcoming', [App\Http\Controllers\Admin\AppointmentController::class, 'upcoming'])->name('upcoming');
        Route::get('/cancelled', [App\Http\Controllers\Admin\AppointmentController::class, 'cancelled'])->name('cancelled');
    });

    // Pharmacy & Inventory
    Route::prefix('pharmacy')->name('pharmacy.')->group(function () {
        Route::get('/stock', [App\Http\Controllers\Admin\PharmacyController::class, 'stock'])->name('stock');
        Route::get('/create', [App\Http\Controllers\Admin\PharmacyController::class, 'create'])->name('create');
        Route::get('/alerts', [App\Http\Controllers\Admin\PharmacyController::class, 'alerts'])->name('alerts');
        Route::get('/suppliers', [App\Http\Controllers\Admin\PharmacyController::class, 'suppliers'])->name('suppliers');
        Route::get('/orders', [App\Http\Controllers\Admin\PharmacyController::class, 'orders'])->name('orders');
        Route::get('/expiry', [App\Http\Controllers\Admin\PharmacyController::class, 'expiry'])->name('expiry');
    });

    // Lab Management
    Route::prefix('lab')->name('lab.')->group(function () {
        Route::get('/catalog', [App\Http\Controllers\Admin\LabController::class, 'catalog'])->name('catalog');
        Route::get('/results', [App\Http\Controllers\Admin\LabController::class, 'results'])->name('results');
        Route::get('/equipment', [App\Http\Controllers\Admin\LabController::class, 'equipment'])->name('equipment');
        Route::get('/reports', [App\Http\Controllers\Admin\LabController::class, 'reports'])->name('reports');
    });

    // E-commerce Store
    Route::prefix('store')->name('store.')->group(function () {
        Route::get('/products', [App\Http\Controllers\Admin\EcommerceController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\EcommerceController::class, 'create'])->name('create');
        Route::get('/categories', [App\Http\Controllers\Admin\EcommerceController::class, 'categories'])->name('categories');
        Route::get('/orders', [App\Http\Controllers\Admin\EcommerceController::class, 'orders'])->name('orders');
        Route::get('/reviews', [App\Http\Controllers\Admin\EcommerceController::class, 'reviews'])->name('reviews');
    });

    // Billing & Finance
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/invoices', [App\Http\Controllers\Admin\FinanceController::class, 'invoices'])->name('invoices');
        Route::get('/receipt', [App\Http\Controllers\Admin\FinanceController::class, 'receipt'])->name('receipt');
        Route::get('/payments', [App\Http\Controllers\Admin\FinanceController::class, 'payments'])->name('payments');
        Route::get('/insurance', [App\Http\Controllers\Admin\FinanceController::class, 'insurance'])->name('insurance');
        Route::get('/tax', [App\Http\Controllers\Admin\FinanceController::class, 'tax'])->name('tax');
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
    });

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/send', [App\Http\Controllers\Admin\NotificationController::class, 'send'])->name('send');
        Route::get('/history', [App\Http\Controllers\Admin\NotificationController::class, 'history'])->name('history');
        Route::get('/email-templates', [App\Http\Controllers\Admin\NotificationController::class, 'emailTemplates'])->name('emailTemplates');
        Route::get('/sms-templates', [App\Http\Controllers\Admin\NotificationController::class, 'smsTemplates'])->name('smsTemplates');
    });
});
