<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware( 'auth:sanctum' )->get( '/user', function ( Request $request ) {
    return $request->user();
} );

Route::middleware( 'api' )->group( function () {
    Route::get( '/todos', [TodoController::class, 'index'] )->name( 'todos.index' );
    Route::get( '/todos/{id}', [TodoController::class, 'show'] )->name( 'todos.show' );
    Route::post( '/todos', [TodoController::class, 'store'] )->name( 'todos.store' );
    Route::put( '/todos/{id}', [TodoController::class, 'update'] )->name( 'todos.update' );
    Route::delete( '/todos/{id}', [TodoController::class, 'destroy'] )->name( 'todos.destroy' );
} );

Route::middleware( 'auth:api' )->group( function () {
    Route::get( 'users', [UserController::class, 'index'] ); // Get a list of users (paginated)
    Route::post( 'users', [UserController::class, 'store'] ); // Create a new user
    Route::get( 'users/{id}', [UserController::class, 'show'] ); // Get a specific user by ID
    Route::put( 'users/{id}', [UserController::class, 'update'] ); // Update a user by ID
    Route::delete( 'users/{id}', [UserController::class, 'destroy'] ); // Delete a user by ID
} );