<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['auth']],function(){
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create',[PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts',[PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}',[PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/restore',[PostController::class, 'restore'])->name('posts.restore');
    Route::get('/posts/ajax/show', [PostController::class, 'ajaxShow'])->name('posts.ajax.show');
});


Auth::routes();

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/redirect/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->stateless()->user();
    $exists = User::where('email', '=', $user->email)->first();
    if($exists) {
        Auth::login($exists, true);
        return redirect()->route('posts.index');
    } else {
        $user = User::create([
            'name'  => $user->nickname,
            'email' => $user->email,
            'password' => Hash::make('123456789')
        ]);
        Auth::login($user, true);
        return redirect()->route('posts.index');
    }
    
});

Route::get('/auth/callback/google', function () {

    $user = Socialite::driver('google')->user();
    $exists = User::where('email', '=', $user->email)->first();
    if($exists) {
        Auth::login($exists, true);
        return redirect()->route('posts.index');
    } else {
        $user = User::create([
            'name'  => $user->name,
            'email' => $user->email,
            'password' => Hash::make('123456789')
        ]);
        Auth::login($user, true);
        return redirect()->route('posts.index');
    }
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
