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
    return view('welcome');
});

Route::get('/landing', function () {
    return view('welcome');
})->name('landing');

Route::get('/home', function() {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    return redirect(auth()->user()->getDashboardRoute());
})->name('home');

Route::prefix('support')->name('support.')->group(function () {
    Route::view('/help-center', 'pages.support.help-center')->name('help-center');
    Route::view('/faqs', 'pages.support.faqs')->name('faqs');
    Route::view('/contact-support', 'pages.support.contact-support')->name('contact-support');
});

Route::prefix('resources')->name('resources.')->group(function () {
    Route::view('/guidelines', 'pages.resources.guidelines')->name('guidelines');
    Route::view('/health-tips', 'pages.resources.health-tips')->name('health-tips');
    Route::view('/news', 'pages.resources.news')->name('news');
    Route::view('/research', 'pages.resources.research')->name('research');
    Route::view('/staff-portal', 'pages.resources.staff-portal')->name('staff-portal');
});

Route::view('/blog', 'pages.blog.index')->name('blog.index');

Route::view('/about-us', 'pages.core.about')->name('about');
Route::view('/services', 'pages.core.services')->name('services');
Route::view('/appointments', 'pages.core.appointments')->name('appointments');
Route::view('/contact-us', 'pages.core.contact')->name('contact');

Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', function() { return view('pages.shop.index'); })->name('index');
    Route::get('/cart', function() { return view('pages.shop.cart'); })->name('cart');
    Route::get('/checkout', function() { return view('pages.shop.checkout'); })->name('checkout');
    Route::post('/place-order', [App\Http\Controllers\ShopController::class, 'placeOrder'])->name('place-order');
});

Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index']);

Auth::routes();

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
        Route::get('/appointments', [App\Http\Controllers\Doctor\DashboardController::class, 'appointments'])->name('appointments');
        Route::post('/appointments/{appointment}/status', [App\Http\Controllers\Doctor\DashboardController::class, 'updateAppointmentStatus'])->name('appointments.status');
        Route::get('/schedule', [App\Http\Controllers\Doctor\DashboardController::class, 'schedule'])->name('schedule');
        Route::get('/chat', [App\Http\Controllers\Doctor\DashboardController::class, 'chat'])->name('chat');
        Route::get('/profile', [App\Http\Controllers\Doctor\DashboardController::class, 'profile'])->name('profile');
        Route::get('/password', [App\Http\Controllers\Doctor\DashboardController::class, 'password'])->name('password');
        Route::get('/reports', [App\Http\Controllers\Doctor\DashboardController::class, 'reports'])->name('reports');

        /* ── Consultation flow (patient queue → vitals → lab → prescribe → done) ── */
        Route::prefix('consultation')->name('consultation.')->group(function () {
            Route::get('/',                          [App\Http\Controllers\Doctor\ConsultationController::class, 'queue'])->name('queue');
            Route::get('/{appointment}',             [App\Http\Controllers\Doctor\ConsultationController::class, 'show'])->name('show');
            Route::post('/{appointment}/vitals',     [App\Http\Controllers\Doctor\ConsultationController::class, 'saveVitals'])->name('vitals');
            Route::post('/{appointment}/lab',        [App\Http\Controllers\Doctor\ConsultationController::class, 'requestLab'])->name('lab');
            Route::post('/{appointment}/prescribe',  [App\Http\Controllers\Doctor\ConsultationController::class, 'prescribe'])->name('prescribe');
            Route::post('/{appointment}/complete',   [App\Http\Controllers\Doctor\ConsultationController::class, 'complete'])->name('complete');
        });
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
    Route::get('/stock-summary', [App\Http\Controllers\Pharmacist\DashboardController::class, 'stockSummary'])->name('stock-summary');
    Route::get('/inventory', [App\Http\Controllers\Pharmacist\DashboardController::class, 'inventory'])->name('inventory');
    Route::get('/medicines/create', [App\Http\Controllers\Pharmacist\DashboardController::class, 'createMedicine'])->name('medicines.create');
    Route::post('/medicines/store', [App\Http\Controllers\Pharmacist\DashboardController::class, 'storeMedicine'])->name('medicines.store');
    Route::get('/stock-move', [App\Http\Controllers\Pharmacist\DashboardController::class, 'stockMove'])->name('stock-move');
    Route::get('/prescriptions', [App\Http\Controllers\Pharmacist\DashboardController::class, 'prescriptions'])->name('prescriptions');
    Route::get('/prescriptions/history', [App\Http\Controllers\Pharmacist\DashboardController::class, 'prescriptionHistory'])->name('prescriptions.history');
    Route::get('/prescriptions/dispense/{id}', [App\Http\Controllers\Pharmacist\DashboardController::class, 'dispense'])->name('prescriptions.dispense');
    Route::get('/online-orders', [App\Http\Controllers\Pharmacist\DashboardController::class, 'onlineOrders'])->name('online-orders');
    Route::get('/orders', [App\Http\Controllers\Pharmacist\DashboardController::class, 'orders'])->name('orders');
    Route::get('/suppliers', [App\Http\Controllers\Pharmacist\DashboardController::class, 'suppliers'])->name('suppliers');
    Route::get('/settings', [App\Http\Controllers\Pharmacist\DashboardController::class, 'settings'])->name('settings');
    Route::get('/reports', [App\Http\Controllers\Pharmacist\DashboardController::class, 'reports'])->name('reports');
    Route::get('/profile', [App\Http\Controllers\Pharmacist\DashboardController::class, 'profile'])->name('profile');
    Route::get('/password', [App\Http\Controllers\Pharmacist\DashboardController::class, 'password'])->name('password');

    /* ── Dispensing flow (review → deduct stock → close visit) ── */
    Route::prefix('dispense')->name('dispense.')->group(function () {
        Route::get('/',                       [App\Http\Controllers\Pharmacist\DispenseController::class, 'index'])->name('index');
        Route::get('/{prescription}',         [App\Http\Controllers\Pharmacist\DispenseController::class, 'show'])->name('show');
        Route::post('/{prescription}/complete', [App\Http\Controllers\Pharmacist\DispenseController::class, 'complete'])->name('complete');
        Route::post('/{prescription}/cancel',   [App\Http\Controllers\Pharmacist\DispenseController::class, 'cancel'])->name('cancel');
    });
});

Route::middleware(['auth', 'role:lab_tech'])->prefix('lab')->name('lab.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Lab\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/requests', [App\Http\Controllers\Lab\DashboardController::class, 'requests'])->name('requests');
    Route::get('/equipment', [App\Http\Controllers\Lab\DashboardController::class, 'equipment'])->name('equipment');
    Route::get('/tests', [App\Http\Controllers\Lab\DashboardController::class, 'tests'])->name('tests');
    Route::get('/profile', [App\Http\Controllers\Lab\DashboardController::class, 'profile'])->name('profile');
    Route::get('/password', [App\Http\Controllers\Lab\DashboardController::class, 'password'])->name('password');

    /* ── Lab request processing (start → enter results → complete → routes back to doctor) ── */
    Route::prefix('process')->name('process.')->group(function () {
        Route::get('/',                          [App\Http\Controllers\Lab\ProcessController::class, 'index'])->name('index');
        Route::get('/{labRequest}',              [App\Http\Controllers\Lab\ProcessController::class, 'show'])->name('show');
        Route::post('/{labRequest}/start',       [App\Http\Controllers\Lab\ProcessController::class, 'start'])->name('start');
        Route::post('/{labRequest}/complete',    [App\Http\Controllers\Lab\ProcessController::class, 'complete'])->name('complete');
        Route::post('/{labRequest}/cancel',      [App\Http\Controllers\Lab\ProcessController::class, 'cancel'])->name('cancel');
        Route::get('/{labRequest}/files',        [App\Http\Controllers\Lab\ProcessController::class, 'getLabResultFiles'])->name('files.index');
        Route::get('/files/{file}/download',     [App\Http\Controllers\Lab\ProcessController::class, 'downloadLabResultFile'])->name('files.download');
        Route::delete('/files/{file}',            [App\Http\Controllers\Lab\ProcessController::class, 'deleteLabResultFile'])->name('files.delete');
    });
});

Route::middleware(['auth', 'role:accountant'])->prefix('accountant')->name('accountant.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Accountant\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/invoices', [App\Http\Controllers\Accountant\DashboardController::class, 'invoices'])->name('invoices');
    Route::get('/payments', [App\Http\Controllers\Accountant\DashboardController::class, 'payments'])->name('payments');
    Route::get('/reports', [App\Http\Controllers\Accountant\DashboardController::class, 'reports'])->name('reports');
    Route::get('/profile', [App\Http\Controllers\Accountant\DashboardController::class, 'profile'])->name('profile');
    Route::get('/password', [App\Http\Controllers\Accountant\DashboardController::class, 'password'])->name('password');
});

Route::middleware(['auth', 'role:receptionist'])->prefix('receptionist')->name('receptionist.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Receptionist\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointments', [App\Http\Controllers\Receptionist\DashboardController::class, 'appointments'])->name('appointments');
    Route::post('/appointments', [App\Http\Controllers\Receptionist\DashboardController::class, 'storeAppointment'])->name('appointments.store');
    Route::post('/appointments/{appointment}/status', [App\Http\Controllers\Receptionist\DashboardController::class, 'updateAppointmentStatus'])->name('appointments.status');
    Route::delete('/appointments/{appointment}', [App\Http\Controllers\Receptionist\DashboardController::class, 'cancelAppointment'])->name('appointments.cancel');
    Route::get('/patients', [App\Http\Controllers\Receptionist\DashboardController::class, 'patients'])->name('patients');
    Route::get('/patients/json', [App\Http\Controllers\Receptionist\DashboardController::class, 'getPatientsJson'])->name('patients.json');
    Route::post('/patients/register', [App\Http\Controllers\Receptionist\DashboardController::class, 'registerPatient'])->name('patients.register');
    Route::post('/test-sms', [App\Http\Controllers\Receptionist\DashboardController::class, 'testSMS'])->name('test-sms');
    Route::post('/patients/send-to-doctor', [App\Http\Controllers\Receptionist\DashboardController::class, 'sendPatientToDoctor'])->name('patients.send-to-doctor');
    Route::get('/patients/{id}/view', [App\Http\Controllers\Receptionist\DashboardController::class, 'viewPatient'])->name('patients.view');
    Route::get('/patients/{id}/edit', [App\Http\Controllers\Receptionist\DashboardController::class, 'editPatient'])->name('patients.edit');
    Route::put('/patients/{id}/update', [App\Http\Controllers\Receptionist\DashboardController::class, 'updatePatient'])->name('patients.update');
    Route::post('/patients/{id}/resend-sms', [App\Http\Controllers\Receptionist\DashboardController::class, 'resendPatientSMS'])->name('patients.resend-sms');
    Route::post('/patients/{patient}/files', [App\Http\Controllers\Receptionist\DashboardController::class, 'uploadPatientFile'])->name('patients.files.upload');
    Route::get('/patients/{patient}/files', [App\Http\Controllers\Receptionist\DashboardController::class, 'getPatientFiles'])->name('patients.files.index');
    Route::get('/files/{file}/download', [App\Http\Controllers\Receptionist\DashboardController::class, 'downloadPatientFile'])->name('files.download');
    Route::delete('/files/{file}', [App\Http\Controllers\Receptionist\DashboardController::class, 'deletePatientFile'])->name('files.delete');
    Route::get('/doctors', [App\Http\Controllers\Receptionist\DashboardController::class, 'doctors'])->name('doctors');
    Route::get('/doctors/json', [App\Http\Controllers\Receptionist\DashboardController::class, 'getDoctorsJson'])->name('doctors.json');
    Route::get('/payments/pending', [App\Http\Controllers\Receptionist\DashboardController::class, 'getPendingPayments'])->name('payments.pending');
    Route::post('/payments/{paymentId}/confirm', [App\Http\Controllers\Receptionist\DashboardController::class, 'confirmPayment'])->name('payments.confirm');
    Route::get('/profile', [App\Http\Controllers\Receptionist\DashboardController::class, 'profile'])->name('profile');
    Route::get('/password', [App\Http\Controllers\Receptionist\DashboardController::class, 'password'])->name('password');

    /* ── Visit / Queue flow (search/register patient → send to doctor → monitor queue) ── */
    Route::prefix('visits')->name('visits.')->group(function () {
        Route::get('/queue',                       [App\Http\Controllers\Receptionist\VisitController::class, 'queue'])->name('queue');
        Route::get('/search-patient',              [App\Http\Controllers\Receptionist\VisitController::class, 'searchPatient'])->name('search');
        Route::post('/register-patient',           [App\Http\Controllers\Receptionist\VisitController::class, 'registerPatient'])->name('register');
        Route::post('/send-to-doctor',             [App\Http\Controllers\Receptionist\VisitController::class, 'sendToDoctor'])->name('send');
        Route::post('/change-doctor',              [App\Http\Controllers\Receptionist\DashboardController::class, 'changeDoctor'])->name('change-doctor');
        Route::post('/complete',                   [App\Http\Controllers\Receptionist\DashboardController::class, 'markVisitCompleted'])->name('complete');
        Route::post('/payment',                    [App\Http\Controllers\Receptionist\DashboardController::class, 'processPayment'])->name('payment');
        Route::get('/medical-details',             [App\Http\Controllers\Receptionist\DashboardController::class, 'getMedicalDetails'])->name('medical-details');
        Route::post('/{appointment}/cancel',       [App\Http\Controllers\Receptionist\VisitController::class, 'cancelVisit'])->name('cancel');
    });
});

Route::middleware(['auth', 'role:customer'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Patient\DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/payments', [App\Http\Controllers\Admin\DashboardController::class, 'getAllPayments'])->name('payments');
    Route::get('/payments/pending', [App\Http\Controllers\Admin\DashboardController::class, 'getPendingPayments'])->name('payments.pending');
    Route::post('/payments/{paymentId}/confirm', [App\Http\Controllers\Admin\DashboardController::class, 'confirmPayment'])->name('payments.confirm');
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('hr', App\Http\Controllers\Admin\HRController::class);
    Route::get('/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');
    
    // Calendar & Appointments
    Route::prefix('calendar')->name('calendar.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\CalendarController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\CalendarController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\CalendarController::class, 'store'])->name('store');
        Route::delete('/{appointment}', [App\Http\Controllers\Admin\CalendarController::class, 'destroy'])->name('destroy');
        Route::get('/user/{userId}', [App\Http\Controllers\Admin\CalendarController::class, 'userSchedule'])->name('user');
    });

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
        Route::get('/{appointment}', [App\Http\Controllers\Admin\AppointmentController::class, 'show'])->name('show');
        Route::post('/{appointment}/status', [App\Http\Controllers\Admin\AppointmentController::class, 'updateStatus'])->name('status');
        Route::post('/{appointment}/reassign', [App\Http\Controllers\Admin\AppointmentController::class, 'reassignDoctor'])->name('reassign');
        Route::delete('/{appointment}', [App\Http\Controllers\Admin\AppointmentController::class, 'destroy'])->name('destroy');
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
