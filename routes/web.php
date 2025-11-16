<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EtudiantsController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\BesoinController;

// Routes pour l'authentification utilisateur
Route::get('/', [UserController::class, 'login'])->name('user.login');
Route::post('/login', [UserController::class, 'loginPost'])->name('user.login.post');

// Route pour la déconnexion
Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');

// Route pour les pages

Route::get('/dashboard', [PageController::class, 'dashboard'])->name('front.dashboard');
Route::get('/etudiants', [PageController::class, 'etudiants'])->name('front.etudiants');
Route::get('/inscription', [PageController::class, 'inscription'])->name('front.inscription');


// Routes pour inscrire un étudiant
// Route::resource('etudiantss', EtudiantsController::class);

// Route::get('/etudiants', [PageController::class, 'etudiants'])->name('front.etudiants');
Route::get('/etudiants/add', [EtudiantsController::class, 'create'])->name('etudiants.add');
Route::post('/etudiants', [EtudiantsController::class, 'store'])->name('etudiants.store');
Route::get('/etudiants/{id}/edit', [EtudiantsController::class, 'edit'])->name('etudiants.edit');
Route::put('/etudiants/{id}', [EtudiantsController::class, 'update'])->name('etudiants.update');
Route::delete('/etudiants/{id}', [EtudiantsController::class, 'destroy'])->name('etudiants.destroy');

// Route pour afficher la page de paiement
Route::get('/paiement', [PageController::class, 'paiement'])->name('front.paiement');

// Route pour la gestion des paiements
Route::get('/paiements/create', [PaiementController::class, 'create'])->name('paiements.create');
Route::post('/paiements', [PaiementController::class, 'store'])->name('paiements.store');
Route::get('/paiements/{id}/edit', [PaiementController::class, 'edit'])->name('paiements.edit');
Route::put('/paiements/{id}', [PaiementController::class, 'update'])->name('paiements.update');
Route::delete('/paiements/{id}', [PaiementController::class, 'destroy'])->name('paiements.destroy');

// Routes pour les reçus de paiement
// Routes pour les reçus
Route::get('/receipt/{id}', [ReceiptController::class, 'show'])->name('receipt.show');
Route::get('/receipt/{id}/download', [ReceiptController::class, 'download'])->name('receipt.download');
Route::get('/receipt/{id}/print', [ReceiptController::class, 'print'])->name('receipt.print');

// Route pour calculer les paiements restants

Route::get('/paiements/{id}/add', [PaiementController::class, 'createAdditional'])->name('paiements.add');
Route::post('/paiements/{id}/add', [PaiementController::class, 'addPayment'])->name('paiements.add.store');


// Routes pour les statistiques
Route::get('/statistiques/cumul-niveaux', [StatistiqueController::class, 'cumulParNiveau'])->name('statistiques.cumul');
Route::get('/statistiques/detaillees', [StatistiqueController::class, 'statistiquesDetaillees'])->name('statistiques.detaillees');
Route::get('/statistiques/export-pdf', [StatistiqueController::class, 'exportPDF'])->name('statistiques.export.pdf');

// Routes pour la gestion des besoins étudiants
Route::resource('besoins', BesoinController::class);
Route::get('/besoins-dashboard', [BesoinController::class, 'dashboard'])->name('besoins.dashboard');
