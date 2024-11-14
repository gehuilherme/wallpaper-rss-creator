<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\XmlInfoController;

Route::get('/', [XmlInfoController::class, 'create'])->name('index');
Route::get('/feed', [XmlInfoController::class, 'index'])->name('feed');
Route::get('/list', [XmlInfoController::class, 'list'])->name('list');
Route::post('/create-feed', [XmlInfoController::class, 'createFeed'])->name('create-feed');
Route::post('/delete-feed', [XmlInfoController::class, 'deleteFeed'])->name('delete-feed');
