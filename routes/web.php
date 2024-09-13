<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\PusherAuthController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

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

Broadcast::routes(['middleware' => ['auth']]);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/pusher/auth', [PusherAuthController::class, 'authenticate'])->middleware('auth');
Route::get('/fetch-messages/{userId}', [ChatController::class, 'fetchMessages'])->middleware('auth');

Route::get('/chat', [ChatController::class, 'index'])->name('chat')->middleware('auth');
Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send-message')->middleware('auth');



Route::get('/', function () {
    return view('index');
})->name('landing');

Route::get('/features', function () {
    return view('features.index');
})->name('features');

Route::get('/admin', [AdminController::class, 'index'])->name('dashboard');

Route::get('/chat-menu', [AdminController::class, 'chatMenu'])->name('chat-menu');
Route::resource('topics', TopicController::class);
Route::resource('information', InformationController::class);
Route::post('/information/upload', [InformationController::class, 'uploadImage'])->name('information.upload');


Route::get('/chat-admin', [AdminController::class, 'chatIndex'])->name('chat-admin');
Route::get('/admin/chat/{userId}', [AdminController::class, 'chatDetail'])->name('chat.detail');


// Route untuk mengambil pesan berdasarkan userId
Route::get('/admin/messages/{userId}', [AdminController::class, 'fetchMessages'])->name('admin.fetch-messages');

// Route untuk mengirim balasan dari admin
Route::post('/admin/send-message', [AdminController::class, 'sendReplyMessage'])->name('admin.send-message');

Route::get('/article', function () {
    return view('article.index');
})->name('article');
Route::get('/social', function () {
    return view('social.index');
})->name('social');
// Route::get('/chat', function () {
//     return view('chat.index');
// })->name('chat');
