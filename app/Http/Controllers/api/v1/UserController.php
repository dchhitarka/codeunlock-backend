<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all(); 
        $users->each->tags;
        $users->each->posts;
        $users->each->comments;
        return $users;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        if($userId != "null"){
            $user = User::find($userId);
            return $user;
        }
        else{
            return response(["message" => "Incorrect user id"], 404);
        }
    }

    public function details(Request $request, $userId)
    {
        // $user = $request->user();
        $user = User::find($id);
        $user->post_engagements;
        return $user;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->user()->id == Auth::user()->id){
            $user = Auth::user;
            $user->name = $request->name || $user->name;
            $user->avatar = $request->avatar || $user->avatar;
            $user->email = $request->email || $user->email;
            $user->save();
            return $user;
        }
        return response(["message" => "Unathorised Access!"], 403);
    }

    /**
     * Remove the specified resource from storage.
     * No need to display this option for now
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($request->user()->id == Auth::user()->id){
            $user = User::find($id);
            $token = $user->token();
            $tokenRepository = app('Laravel\Passport\TokenRepository');
            $refreshTokenRepository = app('Laravel\Passport\RefreshTokenRepository');
            // Revoke an access token...
            $tokenRepository->revokeAccessToken($token->id);
            // Revoke all of the token's refresh tokens...
            $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
            $user->delete();
            return response(["message" => "User Profile deleted successfully"]); 
        }
        return response(["message" => "Unathorised Access!"], 403);
    }
}
