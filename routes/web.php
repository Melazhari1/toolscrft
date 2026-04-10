<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TextalyzerController;
use App\Http\Controllers\DomainExpiryController;
use App\Http\Controllers\DomainWhoisController;
use App\Http\Controllers\LoremIpsumController;
use App\Http\Controllers\JsonToCsvController;
use App\Http\Controllers\PageController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/how-it-works', [PageController::class, 'howItWorks'])->name('how-it-works');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/textalyzer', [TextalyzerController::class, 'index'])->name('textalyzer.index');
Route::get('/domain-expiry', [DomainExpiryController::class, 'index'])->name('domain-expiry.index');
Route::post('/domain-expiry/check', [DomainExpiryController::class, 'check'])->name('domain-expiry.check');
Route::get('/domain-whois', [DomainWhoisController::class, 'index'])->name('domain-whois.index');
Route::post('/domain-whois/check', [DomainWhoisController::class, 'check'])->name('domain-whois.check');
Route::get('/lorem-ipsum', [LoremIpsumController::class, 'index'])->name('lorem-ipsum.index');
Route::get('/json-to-csv', [JsonToCsvController::class, 'index'])->name('json-to-csv.index');
