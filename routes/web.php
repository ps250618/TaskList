<?php

use App\Livewire\ProjectsIndex;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\TasksIndex;
use App\Livewire\TeamsIndex;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/teams', TeamsIndex::class)->middleware('permission:team.read');
Route::get('/projects', ProjectsIndex::class)->middleware('permission:project.read');
Route::get('/tasks', TasksIndex::class)->middleware('permission:task.read');
Route::get('/teams/{team}', \App\Livewire\TeamsView::class)->middleware('permission:teamsview.read', 'can:view,team');
Route::get('/projects/{project}', \App\Livewire\ProjectView::class)->middleware('permission:projectsview.read', 'can:view,project');
Route::get('/tasks/{task}', \App\Livewire\TaskView::class)->middleware('permission:taskview.read', 'can:view,task');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__.'/auth.php';
