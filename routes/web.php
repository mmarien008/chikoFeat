<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\proprieteController;
use App\Http\Controllers\locataireController;
use App\Http\Controllers\contratController;
use App\Http\Controllers\genererPdfController;
use App\Http\Controllers\loyerController;
use App\Http\Controllers\garantieController;
use App\Http\Controllers\operationController;
use App\Http\Controllers\admin\dashbordController;
use App\Http\Controllers\authController;
use App\Http\Controllers\RevenuExterneController;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\admin\userController;

Route::middleware(['auth'])->group(function () {
    Route::get('/caisse',[RevenuExterneController::class,"index"])->name('caisse.index');
    Route::post('/caisse',[RevenuExterneController::class,"store"])->name('caisse.store');
    // Routes pour les propriétés
    Route::prefix('propriete')->name('propriete.')->group(function () {
        Route::get('/create', [proprieteController::class, 'create'])->name('create');
        Route::get('/all', [proprieteController::class, 'index'])->name('index');
        Route::post('/save', [proprieteController::class, 'save'])->name('save');
        Route::get('/show/{id}', [proprieteController::class, 'show'])->name('show');
        Route::get('/show_detaille/{id}/{nom_propriete}', [proprieteController::class,'show_detaille'])->name('show_detaille');
    });

    // Routes pour les contrats
    Route::prefix('contrat')->name('contrat.')->group(function () {
        Route::get('/resilier/{id_locataire}/{id_bien}/{id_type_bien}', [contratController::class,'resilier'])->name('resilier');
        Route::get('/{id_type_bien}/{nom_bien}/{bien}/{locataire}', [contratController::class,'create'])->name('create');
        Route::post('/save', [contratController::class,'save'])->name('save');
    });

    // Routes pour le loyer
    Route::prefix('loyer')->name('loyer.')->group(function () {
        Route::get('/create', [loyerController::class, 'create'])->name('create');
        Route::get('/index', function () {
            return view('loyer.index');
        })->name('index');
        Route::get('/showLocation/{id_locataire}', [loyerController::class, 'showLocation'])->name('showLocation');
        Route::get('/payer/{nom_locataire}/{type_bien}/{numero}/{type}', [loyerController::class, 'payer'])->name('payer');
        Route::post('/save', [loyerController::class, 'save'])->name('save');
        Route::get('/show/{type}', [loyerController::class, 'show'])->name('show');
        Route::get('/showdetaille/{type}/{nom}/{date}', [loyerController::class, 'showdetaille'])->name('showdetaille');
        Route::get('/completer/{id_bien}/{id_propriete}/{mois}', [loyerController::class, 'completerLoyer'])->name('completerLoyer');
        Route::post('/completerSave', [loyerController::class, 'completerLoyerEnregistrer'])->name('completerSave');
    });

    // Routes pour les locataires
    Route::prefix('locataire')->name('locataire.')->group(function () {
        Route::post('/save', [locataireController::class, 'save'])->name('save');
        Route::get('/create', [locataireController::class, 'create'])->name('create');
        Route::get('/index', [locataireController::class, 'index'])->name('index');
        Route::get('/show/{type}', [locataireController::class, 'show'])->name('show');
        Route::get('/showdetaille/{type}/{id_nom}', [locataireController::class, 'showdetaille'])->name('showdetaille');
    });

    // Routes pour les garanties
    Route::prefix('garantie')->name('garantie.')->group(function () {
        Route::post('/save', [garantieController::class, 'save'])->name('save');
        Route::get('/show/{id_locataire}/{id_type_bien}/{id_bien}/{type}', [garantieController::class, 'show'])->name('show');
    });

    // Routes pour la gestion des PDF
    Route::prefix('pdf')->name('pdf.')->group(function () {
        Route::get('/create', [genererPdfController::class, 'create'])->name('create');
        Route::get('/generer', [genererPdfController::class, 'generer'])->name('generer');
        Route::get('/show/{type}', [genererPdfController::class, 'show'])->name('show');
        Route::get('/genererRapportLoyerMois/{type}/{nom}/{dates}', [genererPdfController::class, 'genererRapportLoyerMois'])->name('genererRapportLoyerMois');
        Route::get('/telecharger', [genererPdfController::class, 'telecharger'])->name('telecharger');
    });

    // Routes pour l'administration
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [dashbordController::class, 'index'])->name('dashboard.index');
        Route::get('/dashboard/grapheLoyer', [dashbordController::class, 'info_graphique'])->name('dashboard.grapheLoyer');
        Route::get('/dashboard/info_graphique_depense', [dashbordController::class, 'info_graphique_depense'])->name('dashboard.info_graphique_depense');
    });

    // Routes pour les opérations
    Route::prefix('operation')->name('operation.')->group(function () {
        Route::get('/new', [operationController::class, 'create'])->name('create');
        Route::get('/voir', [operationController::class, 'index'])->name('index');
        Route::post('/save', [operationController::class, 'save'])->name('save');
        Route::get('/terminer/{id}', [operationController::class, 'terminer'])->name('terminer');
    });

    Route::prefix('admin/operation')->name('admin.operation.')->group(function () {
        Route::get('/voir', [App\Http\Controllers\admin\operationController::class, 'index'])->name('index');
        Route::get('/valider/{id}', [App\Http\Controllers\admin\operationController::class, 'valider'])->name('valider');
        Route::get('/annuler/{id}', [App\Http\Controllers\admin\operationController::class, 'annuler'])->name('annuler');
        Route::get('/notification', [App\Http\Controllers\admin\operationController::class, 'NotificationOperation'])->name('NotificationOperation');
    });

    // Routes pour la gestion des utilisateurs
    Route::prefix('admin/user')->name('admin.user.')->group(function () {
        Route::get('/create', [userController::class, 'create'])->name('create');
        Route::post('/store', [userController::class, 'store'])->name('store');
        Route::get('/index', [userController::class, 'index'])->name('index');
        Route::get('/edit/{user}', [userController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [userController::class, 'update'])->name('update');
        Route::post('/delete/{user}', [userController::class, 'destroy'])->name('destroy');
    });

});

// Routes d'authentification (pas de middleware ici pour permettre la connexion)
Route::get('/', [authController::class, 'login'])->name('login');
Route::post('auth/', [authController::class, 'Tologin'])->name('Tologin');
Route::post('logout/', [authController::class, 'logout'])->name('logout');
