<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyRequestController;
use App\Http\Controllers\RentalContractController;
use App\Http\Controllers\RentPaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Afficher la page d'accueil avec la méthode viewDemo
//Route::get('/', [PropertyController::class, 'viewDemo']);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('properties', PropertyController::class);
    Route::apiResource('rental-contracts', RentalContractController::class);
    Route::apiResource('rent-payments', RentPaymentController::class);
    Route::apiResource('property-requests', PropertyRequestController::class);
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/rental-contracts/{rentalContract}/pdf', [RentalContractController::class, 'generatePdf'])
        ->name('rental-contracts.pdf');
    Route::get('/rent-payments/{rentPayment}/receipt', [RentPaymentController::class, 'generateReceipt'])
        ->name('rent-payments.receipt');
});
Route::get('/test-relations', function () {
    $payment = \App\Models\RentPayment::with(['rentalContract', 'rentalContract.tenant', 'rentalContract.property'])->first();
    dd([
        'payment_id' => $payment->id,
        'contract_id' => $payment->rentalContract->id ?? null,
        'contract_number' => $payment->rentalContract->contract_number ?? null,
        'tenant_name' => $payment->rentalContract->tenant->name ?? null,
        'property_title' => $payment->rentalContract->property->title ?? null,
    ]);
});
// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// À propos
Route::get('/about', [PageController::class, 'about'])->name('about');

// Propriétés
Route::prefix('properties')->name('properties.')->group(function () {
    Route::get('/', [PropertyController::class, 'index'])->name('index');
    Route::get('/location', [PropertyController::class, 'location'])->name('location');
    Route::get('/sell-rent', [PropertyController::class, 'sellRent'])->name('sell-rent');
    Route::get('/listing', [PropertyController::class, 'listing'])->name('listing');
    Route::get('/listing-left', [PropertyController::class, 'listingLeft'])->name('listing-left');
    Route::get('/listing-right', [PropertyController::class, 'listingRight'])->name('listing-right');
    Route::get('/{property:slug}', [PropertyController::class, 'show'])->name('show');
    Route::get('/search', [PropertyController::class, 'search'])->name('search');
});

/*// Blog
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/style-two', [BlogController::class, 'index2'])->name('index2');
    Route::get('/left-sidebar', [BlogController::class, 'left'])->name('left');
    Route::get('/right-sidebar', [BlogController::class, 'right'])->name('right');
    Route::get('/{post:slug}', [BlogController::class, 'show'])->name('show');
});*/

// Pages
Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/agency', [PageController::class, 'agency'])->name('agency');
    Route::get('/agency-details', [PageController::class, 'agencyDetails'])->name('agency-details');
    Route::get('/agent', [PageController::class, 'agent'])->name('agent');
    Route::get('/agent-details', [PageController::class, 'agentDetails'])->name('agent-details');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
    Route::get('/404', [PageController::class, 'notFound'])->name('404');
});

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Recherche globale
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Mentions légales
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

