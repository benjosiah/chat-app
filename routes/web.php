
<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [ChatController::class, 'Teams'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/chat/{team_id}', [ChatController::class, 'chatRoom'])->name('chatroom');

// Route::middleware('auth:sanctum')->get('team/{team_id}/rooms', [ChatController::class, 'chatRooms']);
Route::middleware('auth:sanctum')->get('chat/{room_id}/messages', [ChatController::class, 'messages']);
Route::middleware('auth:sanctum')->post('chat/{room_id}/message', [ChatController::class, 'newMessage']);

Route::middleware('auth:sanctum')->get('/teams', [ChatController::class, 'userTeam']);
Route::middleware('auth:sanctum')->post('team/{team_id}', [ChatController::class, 'addMemer']);
Route::middleware('auth:sanctum')->post('team', [ChatController::class, 'newTeam']);

Route::middleware('auth:sanctum')->post('team/{team_id}/chat', [ChatController::class, 'newChatRoom']);
// Route::middleware('auth:sanctum')->get('chat/{room_id}/messages', [ChatController::class, 'messages']);
// Route::middleware('auth:sanctum')->post('chat/{room_id}/message', [ChatController::class, 'newMessage']);