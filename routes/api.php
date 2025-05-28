<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::prefix('posts')->group(function () {
        Route::get("/", [PostsController::class, 'index'])->name('posts.index'); //get all datas
        Route::post('/', [PostsController::class, 'store'])->name('posts.store');
        Route::get('/{id}', [PostsController::class, 'show'])->name('posts.show');
        Route::put('/{id}', [PostsController::class, 'update'])->name('posts.update');
        Route::delete('/{id}', [PostsController::class, 'destroy'])->name('posts.destroy');
    });

    Route::prefix('comments')->group(function () {
        Route::post("/", [CommentsController::class, 'store'])->name('comments.store');
        Route::delete("/{id}", [CommentsController::class, 'destroy'])->name('comments.destroy');
    });
});
