<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('posts',[PostController::class, 'index'])->middleware('auth:sanctum');
Route::get('posts/{post}',[PostController::class, 'show']);
Route::post('posts',[PostController::class, 'store']);

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email'         => 'required|email',
        'password'      => 'required',
        'device_name'   => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});

