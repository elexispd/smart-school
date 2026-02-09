<?php

use App\Livewire\SchoolOnboarding;
use App\Livewire\SchoolList;
use App\Livewire\SuperAdminUsers;
use App\Livewire\RolesPermissions;
use App\Livewire\SaasActivityLogs;
use Illuminate\Support\Facades\Route;

Route::view('platform/dashboard', 'livewire.platform.dashboard.super-admin')->name('super_admin.dashboard')->middleware('role:super_admin');
Route::get('platform/users', SuperAdminUsers::class)->name('super_admin.users')->middleware('role:super_admin')->middleware('can:view users');
Route::get('platform/schools', SchoolList::class)->name('super_admin.schools')->middleware('role:super_admin')->middleware('can:view schools');
Route::get('platform/roles-permissions', RolesPermissions::class)->name('super_admin.roles')->middleware('role:super_admin');
Route::get('platform/activity-logs', SaasActivityLogs::class)->name('super_admin.activity_logs')->middleware('role:super_admin');
Route::get('platform/schools/onboard', SchoolOnboarding::class)->name('schools.onboard')->middleware('role:super_admin')->middleware('can:view schools');
