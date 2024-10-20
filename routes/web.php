<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('/send-test-email', function () {
//     $user = \App\Models\User::first();
//     try {
//         Mail::to($user->email)->send(new \App\Mail\AdminNotificationMail($user));
//         return 'Email sent successfully!';
//     } catch (\Exception $e) {
//         return 'Error: ' . $e->getMessage();
//     }
// });
Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');

