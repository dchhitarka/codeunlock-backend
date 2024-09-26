<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// BASE API URL = /api/v1

// Get All Posts
Route::get('/posts', 'api\v1\PostController@index');
// Get post with slug postSlug
Route::get('/posts/{postSlug}', 'api\v1\PostController@show');

// Search Route
Route::get('/search', 'api\v1\PostController@search');

// POST, PUT & DELETE ARE PROTECTED ROUTES WHICH REQUIRE USER AUTHENTICATION (AS WELL AS ADMIN STATUS)
Route::middleware('auth:api')->group(function(){
    // ADMIN
    Route::get('/admin/posts', 'api\v1\PostController@admin_index');

    // Create new post and it requires user authentication
    Route::post('/posts', 'api\v1\PostController@store');

    // Get PostEngagements as well
    Route::get('/posts/{postSlug}/authenticated', 'api\v1\PostController@showPost');
    // Edit post with slug postSlug
    Route::put('/posts/{postId}/update', 'api\v1\PostController@update');
    // Delete post 
    Route::delete('/posts/{postId}', 'api\v1\PostController@destroy');

    Route::get('/posts/{userId}/bookmarks', 'api\v1\PostController@bookmarks');
    Route::get('/posts/{userId}/likes', 'api\v1\PostController@likes');

    // Post Likes and Bookmarks [DONE]
    Route::put('/posts/{postId}/{userId}/like', 'api\v1\PostController@likePost');
    // Route::put('/posts/{postId}/{userId}/unlike', 'api\v1\PostController@unlikePost');
    Route::put('/posts/{postId}/{userId}/bookmark', 'api\v1\PostController@bookmarkPost');
    // Route::put('/posts/{postId}/{userId}/unbookmark', 'api\v1\PostController@unbookmarkPost');

    // Comments Route
    // Create new comment for the given post id
    Route::post('/posts/{postId}/comments', 'api\v1\CommentController@store');
    // Edit the comment with given id for given postId
    Route::put('/posts/{postId}/comments/{commentId}', 'api\v1\CommentController@update');
    // Delete comment with given id for given postId
    Route::delete('/posts/{postId}/comments/{commentId}', 'api\v1\CommentController@destroy');

    // Tags Route
    // Create new tag for the given post id
    Route::post('/tags', 'api\v1\TagController@store');
    // Edit the tag with given id for given postId
    Route::put('/tags/{tagId}', 'api\v1\TagController@update');
    // Follow/Unfollow Tag
    Route::put('/tags/{tagId}/{userId}/follow', 'api\v1\TagController@engage');
    // Delete comment with given id for given postId
    Route::delete('/tags/{tagId}', 'api\v1\TagController@destroy');

    Route::get('/admin/dashboard', 'api\v1\PostController@admin_dashboard');
});

Route::get('/posts/{postId}/comments', 'api\v1\CommentController@index');
// Get the comment with given id and postid
Route::get('/posts/{postId}/comments/{commentId}', 'api\v1\CommentController@show');
// Get All Tags
Route::get('/tags', 'api\v1\TagController@index');
// Get the tag with given id
Route::get('/tags/{tagSlug}', 'api\v1\TagController@show');

// Auth Routes [DONE]
Route::prefix('/auth')->group(function(){
    Route::post('/register', 'api\v1\AuthController@register');
    Route::post('/login', 'api\v1\AuthController@login');

    // Verify Your Account
    Route::get('/verify/{hash}/{email_hash}', 'api\v1\AuthController@verify');
    Route::post('/verify/mail', 'api\v1\AuthController@send_mail_again');

    // Reset your password
    Route::post('/forgot', 'api\v1\AuthController@forgot');
    Route::get('/reset/{hash}', 'api\v1\AuthController@reset');
    Route::post('/update/{hash}', 'api\v1\AuthController@updatePassword');

    // TEST
    Route::get('/enc/{emailname}', 'api\v1\AuthController@enc');
    Route::get('/dec/{emailname}', 'api\v1\AuthController@dec');
    Route::middleware('auth:api')->get('sendmail', 'api\v1\AuthController@getencrypt');
    
    Route::middleware('auth:api')->get('/logout', 'api\v1\AuthController@logout');
    Route::middleware('auth:api')->get('/users', 'api\v1\UserController@index');
    Route::middleware('auth:api')->get('/user/{userId}', 'api\v1\UserController@show');
    Route::middleware('auth:api')->get('/user/{userId}/details', 'api\v1\UserController@details');
    Route::middleware('auth:api')->put('/user/{userId}', 'api\v1\UserController@update');
    Route::middleware('auth:api')->delete('/user/{userId}', 'api\v1\UserController@destroy');
});

Route::fallback(function () {
    return json_encode(array(["404" => "Not Found"]));
});