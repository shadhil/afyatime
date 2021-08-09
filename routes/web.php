<?php

use App\Http\Livewire\Admin\Dashboard as AdminDashboard;
use App\Http\Livewire\Admin\Organizations as AdminOrganizations;
use App\Http\Livewire\Admin\Patients as AdminPrescribers;
use App\Http\Livewire\Admin\Prescribers as AdminPatients;
use App\Http\Livewire\Admin\Regions as AdminRegions;
use App\Http\Livewire\Admin\Admins as AdminAdmins;
use App\Http\Livewire\Dashboard;
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


Route::get('/admin', AdminDashboard::class)->name('admin.dash');
Route::get('/admin/organizations', AdminOrganizations::class)->name('admin.organizations');
Route::get('/admin/prescribers', AdminPrescribers::class)->name('admin.prescribers');
Route::get('/admin/patients', AdminPatients::class)->name('admin.patients');
Route::get('/admin/regions', AdminRegions::class)->name('admin.regions');
Route::get('/admin/admins', AdminAdmins::class)->name('admin.admins');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::middleware(['auth:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');
    // Route::get('/dashboard', [WriterController::class, 'writerDashboard'])->name('writer.dashboard');
});


Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('/dash', function () {
        return view('welcome');
    })->name('dash');
    // Route::get('/dashboard', [WriterController::class, 'writerDashboard'])->name('writer.dashboard');
});


require __DIR__ . '/auth.php';
