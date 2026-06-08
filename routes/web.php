<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPromptController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AiPromptController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromptController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TopRatedController;
use App\Http\Controllers\TrendingController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
// use App\Models\Conversation;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/leaderboard', [LeaderboardController::class, 'index']);
Route::get('/users/{user}', [ProfileController::class, 'show'])->name('users.show');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | Prompts
    |--------------------------------------------------------------------------
    */

    Route::get('/prompts', [PromptController::class, 'index'])->name('prompts.index');
    Route::get('/prompts/create', [PromptController::class, 'create'])->name('prompts.create');
    Route::post('/prompts', [PromptController::class, 'store'])->name('prompts.store');

    Route::get('/prompts/{prompt}', [PromptController::class, 'show'])->name('prompts.show');

    Route::get('/prompts/{prompt}/edit', [PromptController::class, 'edit'])->name('prompts.edit');
    Route::put('/prompts/{prompt}', [PromptController::class, 'update'])->name('prompts.update');

    Route::delete('/prompts/{prompt}', [PromptController::class, 'destroy'])->name('prompts.destroy');

    Route::post(
        '/prompts/{prompt}/copy',
        [PromptController::class, 'incrementCopy']
    )->name('prompts.copy');

    /*
    |--------------------------------------------------------------------------
    | Favorites
    |--------------------------------------------------------------------------
    */

    Route::get('/favorites', [FavoriteController::class, 'index']);

    Route::post(
        '/favorites/{prompt}',
        [FavoriteController::class, 'store']
    );

    Route::delete(
        '/favorites/{prompt}',
        [FavoriteController::class, 'destroy']
    );

    /*
    |--------------------------------------------------------------------------
    | Explore
    |--------------------------------------------------------------------------
    */

    Route::get('/explore', [PromptController::class, 'explore']);
    Route::get('/trending', [TrendingController::class, 'index']);
    Route::get('/top-rated', [TopRatedController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | Tags
    |--------------------------------------------------------------------------
    */

    Route::get('/tags/{tag:slug}', [TagController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | Profiles
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [SettingsController::class, 'update'])->name('profile.update');
    Route::put('/password', [SettingsController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [SettingsController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Follow System
    |--------------------------------------------------------------------------
    */

    Route::post('/follow/{user}', [FollowController::class, 'store']);

    Route::delete(
        '/follow/{user}',
        [FollowController::class, 'destroy']
    );

    /*
    |--------------------------------------------------------------------------
    | Collections
    |--------------------------------------------------------------------------
    */

    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');

    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');

    Route::get(
        '/collections/{collection}',
        [CollectionController::class, 'show']
    )->name('collections.show');

    Route::delete(
        '/collections/{collection}',
        [CollectionController::class, 'destroy']
    )->name('collections.destroy');

    Route::post(
        '/collections/{collection}/prompts/{prompt}',
        [CollectionController::class, 'addPrompt']
    )->name('collections.prompts.store');

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');

    /*
    |--------------------------------------------------------------------------
    | Comments
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/prompts/{prompt}/comments',
        [CommentController::class, 'store']
    );

    Route::delete(
        '/prompts/{prompt}/comments/{comment}',
        [CommentController::class, 'destroy']
    );

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/notifications',
        [NotificationController::class, 'index']
    );

    Route::post(
        '/notifications/mark-all-read',
        [NotificationController::class, 'markAllRead']
    );

    Route::post(
        '/notifications/{id}/mark-read',
        [NotificationController::class, 'markRead']
    );

    /*
    |--------------------------------------------------------------------------
    | Ratings
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/prompts/{prompt}/rate',
        [RatingController::class, 'store']
    );

    /*
    |--------------------------------------------------------------------------
    | Analytics
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/analytics',
        [AnalyticsController::class, 'index']
    );

    /*

    */

    Route::get('/ai-generator', [AiPromptController::class, 'index']);

    Route::post('/ai-generator', [AiPromptController::class, 'generate']);
    Route::post('/ai-assist', [AiPromptController::class, 'assist']);

    Route::post('/chat/send-ajax', [ChatController::class, 'sendAjax'])
        ->name('chat.send-ajax');
    Route::get('/chat/messages-list', [ChatController::class, 'listConversations'])
        ->name('chat.messages-list');
    Route::get('/chat/messages/{id}', [ChatController::class, 'getMessages'])
        ->name('chat.messages');
    Route::delete('/chat/messages/{id}', [ChatController::class, 'destroyConversation'])
        ->name('chat.messages.destroy');

});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/', [AdminController::class, 'index']);

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        Route::get('/users', [AdminUserController::class, 'index']);

        Route::get('/users/{user}', function (\App\Models\User $user) {
            return redirect()->route('users.show', $user);
        });

        Route::patch(
            '/users/{user}/grant-admin',
            [AdminUserController::class, 'grantAdmin']
        );

        Route::patch(
            '/users/{user}/revoke-admin',
            [AdminUserController::class, 'revokeAdmin']
        );

        Route::delete(
            '/users/{user}',
            [AdminUserController::class, 'destroy']
        );

        /*
        |--------------------------------------------------------------------------
        | Prompts
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/prompts',
            [AdminPromptController::class, 'index']
        );

        Route::get('/prompts/{prompt}', function (\App\Models\Prompt $prompt) {
            return redirect()->route('prompts.show', $prompt);
        });

        Route::patch(
            '/prompts/{prompt}/feature',
            [AdminPromptController::class, 'toggleFeature']
        );

        Route::delete(
            '/prompts/{prompt}',
            [AdminPromptController::class, 'destroy']
        );
    });

require __DIR__ . '/auth.php';
