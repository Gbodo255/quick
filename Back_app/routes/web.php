<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\DossierController;
use App\Http\Controllers\Api\DossierDocumentController;
use App\Http\Controllers\Api\DossierOtpController;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\SimulationController;
use App\Http\Controllers\Api\TranslationController;
use App\Http\Middleware\EnsureAdminAuthenticated;
use Illuminate\Support\Facades\Route;

// Test route OUTSIDE API group
Route::get('test', function () {
    return response()->json(['message' => 'test works']);
});

// API Routes - Test route INSIDE API group
Route::prefix('api')->group(function () {
    Route::get('test', function () {
        return response()->json(['message' => 'api test works']);
    });

    Route::prefix('v1')->group(function () {
        Route::get('health', HealthController::class);
        Route::post('simulate', [SimulationController::class, 'simulate']);

        // Translation routes
        Route::post('translate', [TranslationController::class, 'translate']);
        Route::post('translate/object', [TranslationController::class, 'translateObject']);
        Route::get('translate/usage', [TranslationController::class, 'usage']);

        Route::post('dossiers', [DossierController::class, 'store']);
        Route::get('dossiers/{reference}', [DossierController::class, 'show']);

        Route::middleware('dossier.token')->group(function () {
            Route::patch('dossiers/{reference}', [DossierController::class, 'update']);
            Route::post('dossiers/{reference}/documents/{type}', [DossierDocumentController::class, 'store'])
                ->whereIn('type', ['piece_identite', 'rib', 'fiches_paie']);
            Route::delete('dossiers/{reference}/documents/{type}', [DossierDocumentController::class, 'destroy'])
                ->whereIn('type', ['piece_identite', 'rib', 'fiches_paie']);
            Route::post('dossiers/{reference}/otp/send', [DossierOtpController::class, 'send']);
            Route::post('dossiers/{reference}/otp/verify', [DossierOtpController::class, 'verify']);
            Route::post('dossiers/{reference}/processing/tick', [DossierController::class, 'advanceProcessing']);
        });
    });
});

// Web Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->middleware('throttle:5,1')->name('admin.login.submit');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');

Route::middleware([EnsureAdminAuthenticated::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/statistics', [AdminController::class, 'statistics'])->name('admin.statistics');
    Route::get('/admin/dossiers', [AdminController::class, 'dossiersIndex'])->name('admin.dossiers.index');
    Route::get('/admin/dossiers/archives', [AdminController::class, 'archives'])->name('admin.dossiers.archives');
    Route::post('/admin/dossiers/bulk', [AdminController::class, 'bulkUpdateStatus'])->name('admin.dossiers.bulk');
    Route::get('/admin/dossiers/{application}/approve', [AdminController::class, 'approvePreview'])->name('admin.dossiers.approve.preview');
    Route::get('/admin/dossiers/{application}/preview/pdf', [AdminController::class, 'previewPdf'])->name('admin.dossiers.preview.pdf');
    Route::get('/admin/dossiers/{application}/preview/email', [AdminController::class, 'previewEmail'])->name('admin.dossiers.preview.email');
    Route::post('/admin/dossiers/{application}/approve', [AdminController::class, 'approveConfirm'])->name('admin.dossiers.approve.confirm');
    Route::patch('/admin/dossiers/{application}/status', [AdminController::class, 'updateStatus'])->name('admin.dossiers.status.update');
    Route::patch('/admin/dossiers/{application}/archive', [AdminController::class, 'archiveDossier'])->name('admin.dossiers.archive');
    Route::patch('/admin/dossiers/{application}/unarchive', [AdminController::class, 'unarchiveDossier'])->name('admin.dossiers.unarchive');
    Route::post('/admin/dossiers/{application}/notes', [AdminController::class, 'storeDossierNote'])->name('admin.dossiers.notes.store');
    Route::get('/admin/dossiers/{application}', [AdminController::class, 'show'])->name('admin.dossiers.show');
    Route::get('/admin/dossiers/{application}/documents/{document}', [AdminController::class, 'downloadDocument'])->name('admin.documents.download');
    Route::get('/admin/notifications/unread', [AdminController::class, 'unreadNotifications'])->name('admin.notifications.unread');
    Route::get('/admin/notifications/{id}/read', [AdminController::class, 'readNotification'])->name('admin.notifications.read');

    // Utilisateurs (Clients)
    Route::get('/admin/clients', [AdminController::class, 'clientsIndex'])->name('admin.clients.index');
    Route::get('/admin/clients/archives', [AdminController::class, 'clientsArchives'])->name('admin.clients.archives');
    Route::get('/admin/clients/export', [AdminController::class, 'clientsExport'])->name('admin.clients.export');
    Route::get('/admin/clients/{email}', [AdminController::class, 'clientsShow'])->name('admin.clients.show');
    Route::post('/admin/clients/{email}/notes', [AdminController::class, 'storeClientNote'])->name('admin.clients.notes.store');
    Route::patch('/admin/clients/{email}/block', [AdminController::class, 'blockClient'])->name('admin.clients.block');
    Route::patch('/admin/clients/{email}/archive', [AdminController::class, 'archiveClient'])->name('admin.clients.archive');

    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // Profil
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/admin/profile/password', [AdminController::class, 'updatePassword'])->name('admin.profile.password');
    Route::post('/admin/profile/sessions/logout', [AdminController::class, 'logoutOtherDevices'])->name('admin.profile.sessions.logout');

    // Paramètres (admin only)
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/admin/settings/users', [AdminController::class, 'createUser'])->name('admin.settings.users.create');
    Route::patch('/admin/settings/users/{user}', [AdminController::class, 'updateUser'])->name('admin.settings.users.update');
    Route::post('/admin/settings/users/{user}/password', [AdminController::class, 'changeUserPassword'])->name('admin.settings.users.password');
    Route::delete('/admin/settings/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.settings.users.delete');
});

