<?php

use App\Http\Livewire\Admin\Dashboard as AdminDashboard;
use App\Http\Livewire\Admin\Organizations as AdminOrganizations;
use App\Http\Livewire\Admin\Patients as AdminPatients;
use App\Http\Livewire\Admin\Prescribers as AdminPrescribers;
use App\Http\Livewire\Admin\Regions as AdminRegions;
use App\Http\Livewire\Admin\Admins as AdminAdmins;
use App\Http\Livewire\Admin\AllAppointments as AdminAllAppointments;
use App\Http\Livewire\Admin\Appointments as AdminAppointments;
use App\Http\Livewire\Admin\District as AdminDistrict;
use App\Http\Livewire\Admin\Invoices as AdminInvoices;
use App\Http\Livewire\Admin\OrganizationSubscriptions;
use App\Http\Livewire\Admin\OrganizationTypes;
use App\Http\Livewire\Admin\PrescriberTypes;
use App\Http\Livewire\Admin\Users as AdminUsers;
use App\Http\Livewire\Admin\OrgProfile as AdminOrgProfile;
use App\Http\Livewire\Admin\TreatmentSupporters as AdminTreatmentSupporters;
use App\Http\Livewire\ApiTests;
use App\Http\Livewire\Appointments;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\PatientProfile;
use App\Http\Livewire\Patients;
use App\Http\Livewire\Prescribers;
use App\Http\Livewire\TreatmentSupporters;
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

Route::get('/dash', Dashboard::class);


// Route::get('/admin', AdminDashboard::class)->name('admin.dash');
// Route::get('/admin/organizations', AdminOrganizations::class)->name('admin.organizations');
// Route::get('/admin/prescribers', AdminPrescribers::class)->name('admin.prescribers');
// Route::get('/admin/patients', AdminPatients::class)->name('admin.patients');
// Route::get('/admin/regions', AdminRegions::class)->name('admin.regions');
// Route::get('/admin/admins', AdminAdmins::class)->name('admin.admins');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::middleware(['auth:user'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/appointments', Appointments::class)->name('appointments');
    Route::get('/patients', Patients::class)->name('patients');
    Route::get('/prescribers', Prescribers::class)->name('prescribers');
    Route::get('/treatment-supporters', TreatmentSupporters::class)->name('supporters');
    Route::get('/admins', AdminAdmins::class)->name('admins');
    Route::get('/patient/{id}', PatientProfile::class)->name('patient-profile');
    Route::get('/api-tests', ApiTests::class);
});


Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    // Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/', AdminOrganizations::class)->name('organizations');
    Route::get('/organization/{id}', AdminOrgProfile::class)->name('organizations.profile');
    Route::get('/all-appointments', AdminAllAppointments::class)->name('appointments.all');
    Route::get('/regions', AdminRegions::class)->name('regions');
    Route::get('/region/{id}', AdminDistrict::class)->name('regions.district');
    Route::get('/admins', AdminAdmins::class)->name('admins');
    Route::get('/org-types', OrganizationTypes::class)->name('types.org');
    Route::get('/prescriber-types', PrescriberTypes::class)->name('types.prescriber');
    Route::get('/users', AdminUsers::class)->name('users');
    Route::get('/invoices', AdminInvoices::class)->name('invoices');
    Route::get('/subscriptions/{id}', OrganizationSubscriptions::class)->name('subscriptions');
    Route::get('/appointments/{id}', AdminAppointments::class)->name('appointments');
    Route::get('/prescribers/{id}', AdminPrescribers::class)->name('prescribers');
    Route::get('/patients/{id}', AdminPatients::class)->name('patients');
    Route::get('/treatment-supporters/{id}', AdminTreatmentSupporters::class)->name('supporters');
});


require __DIR__ . '/auth.php';
