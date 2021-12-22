<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Livewire\Admin\PatientProfile as AdminPatientProfile;
use App\Http\Livewire\Admin\PrescriberProfile as AdminPrescriberProfile;
use App\Http\Livewire\Admin\TreatmentSupporters as AdminTreatmentSupporters;

Route::get('/test', function () {
    echo 'Wow';
});

Route::name('admin.')->middleware(['auth.admin'])->group(function () {
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
    Route::get('/prescriber/{org_id}/{id}', AdminPrescriberProfile::class)->name('prescribers.profile');
    Route::get('/patients/{id}', AdminPatients::class)->name('patients');
    Route::get('/patient/{org_id}/{code}', AdminPatientProfile::class)->name('patients.profile');
    Route::get('/treatment-supporters/{id}', AdminTreatmentSupporters::class)->name('supporters');
    Route::get('/admins', AdminAdmins::class)->name('admins');
});

require __DIR__ . '/auth.php';
