<?php
  
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\{
    HomeController, PublicPasakumiController, PublicProjektiController, PublicJaunumiController,
    PublicGalerijasController, PublicPageController, ContactController
};
use App\Http\Controllers\Admin\{
    AdminDashboardController, PasakumiController, ProjektiController, JaunumiController, GalerijasController,
    LapasController, KategorijasController, ContactMessagesController, UsersController, SaturaSaitesController, ExportController,
    AuditLogsController, GalleryImagesController
};
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pasakumi', [PublicPasakumiController::class, 'index'])->name('public.pasakumi.index');
Route::get('/pasakumi/{pasakums}', [PublicPasakumiController::class, 'show'])->name('public.pasakumi.show');

Route::get('/projekti', [PublicProjektiController::class, 'index'])->name('public.projekti.index');
Route::get('/projekti/{projekts}', [PublicProjektiController::class, 'show'])->name('public.projekti.show');

Route::get('/jaunumi', [PublicJaunumiController::class, 'index'])->name('public.jaunumi.index');
Route::get('/jaunumi/{jaunums}', [PublicJaunumiController::class, 'show'])->name('public.jaunumi.show');

Route::get('/galerijas', [PublicGalerijasController::class, 'index'])->name('public.galerijas.index');
Route::get('/galerijas/{galerija}', [PublicGalerijasController::class, 'show'])->name('public.galerijas.show');


Route::get('/kontakti', [ContactController::class, 'create'])->name('contact.create');
Route::post('/kontakti', [ContactController::class, 'store'])
    ->middleware(['throttle:10,1'])
    ->name('contact.store');

Route::get('/lapa/{slug}', [PublicPageController::class, 'show'])->name('public.page.show');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('pasakumi', PasakumiController::class);
    Route::resource('projekti', ProjektiController::class);
    Route::resource('jaunumi', JaunumiController::class);
    Route::resource('galerijas', GalerijasController::class);
    Route::resource('lapas', LapasController::class);
    Route::resource('kategorijas', KategorijasController::class)->except(['show']);

    // Gallery images
    Route::post('galerijas/{galerija}/atteli', [GalleryImagesController::class, 'store'])->name('galerijas.atteli.store');
    Route::delete('galerijas/{galerija}/atteli/{attels}', [GalleryImagesController::class, 'destroy'])->name('galerijas.atteli.destroy');

    // Contact messages
    Route::get('kontakt-zinojumi', [ContactMessagesController::class, 'index'])->name('kontakt.index');
    Route::patch('kontakt-zinojumi/{zinojums}/apstradats', [ContactMessagesController::class, 'markProcessed'])->name('kontakt.process');



Route::get('satura-saites', [SaturaSaitesController::class, 'index'])->name('saites.index');
Route::get('satura-saites/create', [SaturaSaitesController::class, 'create'])->name('saites.create');
Route::post('satura-saites', [SaturaSaitesController::class, 'store'])->name('saites.store');
Route::post('satura-saites/generate', [SaturaSaitesController::class, 'generate'])->name('saites.generate');
Route::post('satura-saites/bulk', [SaturaSaitesController::class, 'bulk'])->name('saites.bulk');
Route::patch('satura-saites/{saite}/approve', [SaturaSaitesController::class, 'approve'])->name('saites.approve');
Route::patch('satura-saites/{saite}/reject', [SaturaSaitesController::class, 'reject'])->name('saites.reject');
Route::delete('satura-saites/{saite}', [SaturaSaitesController::class, 'destroy'])->name('saites.destroy');
    // Exports
    Route::get('export/{resource}/csv', [ExportController::class, 'csv'])->name('export.csv');
    Route::get('export/{resource}/pdf', [ExportController::class, 'pdf'])->name('export.pdf');

    // Admin-only
    Route::resource('users', UsersController::class);

    Route::get('audit', [AuditLogsController::class, 'index'])->name('audit.index');
});

require __DIR__.'/auth.php';