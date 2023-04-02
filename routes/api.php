<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HackernewsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(
    ['prefix' => config('hackernews.apiversion')],
    function () {

        Route::get('/spool/max', [HackernewsController::class, 'spoolmax']);

        Route::get('spool/top', [HackernewsController::class, 'spooltop']);

        Route::get('/spool/new', [HackernewsController::class, 'spoolnew']);

        Route::get('spool/show', [HackernewsController::class, 'spoolshow']);

        Route::get('/spool/ask', [HackernewsController::class, 'spoolask']);

        Route::get('spool/job', [HackernewsController::class, 'spooljob']);

        Route::get('/spool/best', [HackernewsController::class, 'spoolbest']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
