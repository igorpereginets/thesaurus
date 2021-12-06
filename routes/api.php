<?php

use App\Http\Controllers\ThesaurusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/words', [ThesaurusController::class, 'getWords']);
Route::get('/word/synonyms', [ThesaurusController::class, 'getSynonyms']);
Route::post('/word/synonyms', [ThesaurusController::class, 'addSynonyms']);
