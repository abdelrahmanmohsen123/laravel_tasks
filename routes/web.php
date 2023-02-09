<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactUsController;

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



// login with github






Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index']);
Route::get('/contactus', [ContactUsController::class, 'index']);
Route::get('/aboutus', [AboutController::class, 'index']);
Route::view("/test", "about");



Route::get('/posts',[PostController::class, 'index'])->name('posts.all');
Route::get('/posts/deleted',[PostController::class, 'deleted'])->name('posts.deleted');
Route::get('/posts/add',[PostController::class, 'create'])->name('posts.add');
Route::post('/posts',[PostController::class, 'store'])->name('posts.store');
Route::get('/posts/show/{id}',[PostController::class, 'show'])->name('posts.show');
Route::get('/posts/edit/{id}',[PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/update/{id}',[PostController::class, 'update'])->name('posts.update');

// delete post
Route::delete('/posts/delete',[PostController::class, 'destroy'])->name('posts.delete');
Route::get('/posts/resore/{post}',[PostController::class, 'restore'])->name('posts.restore');
Route::delete('/posts/forcedelete',[PostController::class, 'forceDelete'])->name('posts.forceDelete');

Route::get('/posts/{id}/show', [PostController::class, 'show_modal'])->name('posts.show_modal');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect()->name('login.WithGithub');
});

Route::get('/auth/callback', function () {
    $githubUser = Socialite::driver('github')->user();
    $user =  User::where('email',$githubUser->email)->first();

   return $user;
    // $user = User::updateOrCreate([
    //     'github_id' => $githubUser->id,
    // ], [
    //     'name' => $githubUser->name,
    //     'email' => $githubUser->email,
    //     'github_token' => $githubUser->token,
    //     'github_refresh_token' => $githubUser->refreshToken,
    // ]);

    Auth::login($user);

    return redirect('/dashboard');
});