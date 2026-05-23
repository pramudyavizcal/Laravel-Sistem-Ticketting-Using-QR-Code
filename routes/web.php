<?php

use App\Http\Controllers\Admin\AttendeeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ScannerController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// ── Public Registration Area ──────────────────────────────────
use App\Http\Controllers\EventRegistrationController;

Route::get('/', [EventRegistrationController::class, 'index'])->name('home');
Route::get('/event/{id}', [EventRegistrationController::class, 'show'])->name('event.public_show');
Route::post('/event/{id}/register', [EventRegistrationController::class, 'register'])->name('event.register');

// Payment Routes
Route::get('/registration/payment/{ticketCode}', [EventRegistrationController::class, 'paymentPage'])->name('event.register.payment');
Route::post('/registration/payment/{ticketCode}', [EventRegistrationController::class, 'submitPayment'])->name('event.register.submit-payment');
Route::get('/registration/payment/{ticketCode}/xendit', [EventRegistrationController::class, 'payWithXendit'])->name('event.register.pay-xendit');
Route::get('/registration/pending/{ticketCode}', [EventRegistrationController::class, 'pendingView'])->name('event.register.pending');

// Public ticket view
Route::get('/ticket/{ticketCode}', [TicketController::class, 'show'])->name('ticket.show');

// ── Auth Routes ───────────────────────────────────────────────
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (\Illuminate\Support\Facades\Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended(route('admin.dashboard'));
    }

    return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
})->name('login.post');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// ── Admin Routes ───────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Events
    Route::resource('events', EventController::class);
    Route::post('events/{event}/toggle', [EventController::class, 'toggleStatus'])->name('events.toggle');

    // Attendees
    Route::resource('attendees', AttendeeController::class);
    Route::post('attendees/import', [AttendeeController::class, 'importCsv'])->name('attendees.import');
    Route::post('attendees/{attendee}/reset-checkin', [AttendeeController::class, 'resetCheckin'])->name('attendees.reset-checkin');
    Route::post('attendees/{attendee}/approve', [AttendeeController::class, 'approve'])->name('attendees.approve');
    Route::post('attendees/{attendee}/reject', [AttendeeController::class, 'reject'])->name('attendees.reject');

    // Scanner
    Route::get('scanner', [ScannerController::class, 'index'])->name('scanner');
    Route::post('scanner/verify', [ScannerController::class, 'verify'])->name('scanner.verify');
    Route::get('scan-logs', [ScannerController::class, 'logs'])->name('scan-logs');

    // Profile / Change Password
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');

    // Settings
    Route::get('settings/branding', [SiteSettingController::class, 'edit'])->name('settings.branding');
    Route::put('settings/branding', [SiteSettingController::class, 'update'])->name('settings.branding.update');
});
