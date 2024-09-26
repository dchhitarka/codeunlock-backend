<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\Mail\EmailVerify;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $req){
        try{
            $login = $req->validate([
                'email' => 'required|email',
                'password' => 'required|string'
            ]);
            if(!Auth::attempt($login)){
                return response(['error' => "Invalid email or password", "status" => false], 401);
            }
            if(Auth::user()->email_verified_at == null){
                return response(['error' => "Account not verified"]);
            }
            // Revoke previous token
            $token = Auth::user()->token();
            if($token != null){
                $tokenRepository = app('Laravel\Passport\TokenRepository');
                $refreshTokenRepository = app('Laravel\Passport\RefreshTokenRepository');
                // Revoke an access token...
                $tokenRepository->revokeAccessToken($token->id);
                // Revoke all of the token's refresh tokens...
                $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
                DB::table('oauth_access_tokens')->delete($token->id);
                DB::table('oauth_access_tokens')->save();
            }    
            // Generate new token
            $user = Auth::user();
            $accessToken = Auth::user()->createToken('authToken')->accessToken;
            $user->updated_at = Carbon::now();
            $user->save();
            $user->post_engagements;
            $user->access_token = $accessToken;
            $user->status = true;
            return $user;
        }
        catch(Exception $e){
            return response(["error" => $e->getMessage(), "status" => false]);
        }
    }

    public function forgot(Request $req){
        $user = User::firstWhere('email', $req->input('email'));
        if(!$user){
            return response(["error" => "Invalid Email Address! Try Again with a valid email address."]);
        }
        $user->reset_password_token = bin2hex(random_bytes(12));
        $user->reset_password_expires = Carbon::now();
        $user->save();
        $this->send_reset_mail($user);
        return response(["message" => 'You have been emailed a password reset link!']);
}

    public function send_reset_mail($user){
        $q = $user->reset_password_token;
        $user->reset = env('APP_URL'). '/u/reset/'. $q;
        try{
            Mail::to($user->email)->send(new ResetPassword($user));
        } catch (Exception $e) {
            return response(["error" => $e.getMessage()]);
        }
    }

    public function reset(Request $req, $hash){
        $user = User::firstWhere('reset_password_token', $hash);
        if(!$user || strtotime(Carbon::now()) - strtotime($user->reset_password_expires) > 3600){
            return response(["error" => 'Password reset is invalid or has expired!', "status" => false], 410);
        }
        return response(["message" => "Reset your password", "status" => true]); // Display Reset Form
    }

    public function updatePassword(Request $req, $hash){
        $user = User::firstWhere('reset_password_token', $hash);
        if(!$user || strtotime(Carbon::now()) - strtotime($user->reset_password_expires) > 3600){
            return response(["message" => 'Password reset is invalid or has expired!'], 410);
        }
        $user->password = Hash::make($req->input('password'));
        $user->reset_password_token = null;
        $user->reset_password_expires = null;
        $user->save();
        return response(["message" => "Your password has been reset!"]);
    }

    public function getAvatarUrl($email){
        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?s=200&d=retro";
    }

    public function register(Request $req){
        try{
            $validator = Validator::make($req->input(), [
                'email' => 'required|unique:users|email',
                'password' => 'required|string',
                'name' => 'required|unique:users|string',
            ]);
            if($validator->fails()){
                return response(["message" => $validator->messages(), "status" => false]);
            }
            $avatar = $this->getAvatarUrl($req['email']);
            $user = User::create([
                'name' => $req['name'],
                'email' => $req['email'],
                'avatar' => "https://www.gravatar.com/avatar/" . md5(strtolower(trim($req['email']))) . "?s=200&d=retro",
                'password' => Hash::make($req['password']),
            ]);
            $user->email_link_sent = Carbon::now();
            $user->email_verify_token = bin2hex(random_bytes(12));
            $user->save();
            $this->send_mail($user);
            return response(['messgae' => "Registered successfully. Please verify your account!", "status" => true]);
        }
        catch(Exception $e){
            return response(["message" => $e->getMessage(), "status" => false]);
        }
    }    

    public function send_mail($user){
        $q = $this->encrypt(strtolower(trim($user->email)));
        $user->verify = env('APP_URL'). '/u/verify/'. $user->email_verify_token . "/" . $q;
        Mail::to($user->email)->send(new EmailVerify($user));                
    }

    public function verify(Request $req, $hash, $email_hash){
        $email = $this->decrypt($email_hash);
        $user = User::firstWhere('email', $email);
        if($user->email_verify_token == $hash){
            if($user->email_verified_at != null){
                return response(["message" => "Your account has already been verified"], 200);
            }

            if(strtotime(Carbon::now()) - strtotime($user->email_link_sent) > 3600){
                $user->email_link_sent = null;
                $user->email_verify_token = null;
                $user->save();
                return response(["error" => "This link has expired! Resend Link"], 410);
            }
            else{
                $user->email_verified_at = Carbon::now();
                $user->email_link_sent = null;
                $user->email_verify_token = null;
                $user->save();
                return response(["message" => "Your account has been verified"], 200);
            }
        }
        $user->email_link_sent = null;
        $user->save();
        return response(["error" => "Invalid Link!"], 410);
    }
    
    public function send_mail_again(Request $req){
        $user = User::firstWhere('email', $req->input('email'));
        if(!$user){
            return response(["error" => "Invalid Email Address! Try Again with a valid email address."]);
        }
        $user->email_link_sent = Carbon::now();
        $user->email_verify_token = bin2hex(random_bytes(12));
        $user->save();
        $this->send_mail($user);
        return response(["message" => 'Mail Sent!']);
    }

    public function logout(Request $req){
        $token = $req->user()->token();
        $tokenRepository = app('Laravel\Passport\TokenRepository');
        $refreshTokenRepository = app('Laravel\Passport\RefreshTokenRepository');

        // Revoke an access token...
        $tokenRepository->revokeAccessToken($token->id);

        // Revoke all of the token's refresh tokens...
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
        // ->revoke();
        DB::table('oauth_access_tokens')->delete($token->id);
        return response(["message" => "Logout successful"]);
    }

    public function encrypt($value){
        // Store the cipher method 
        $ciphering = "AES-128-CTR";         
        // Use OpenSSl Encryption method 
        $iv_length = openssl_cipher_iv_length($ciphering); 
        $options = 0; 
        // Non-NULL Initialization Vector for encryption 
        $encryption_iv = '1234567891011121'; 
        // Store the encryption key 
        $encryption_key = 'emailname'; 
        // Use openssl_encrypt() function to encrypt the data 
        $encryption = openssl_encrypt($value, $ciphering, 
                    $encryption_key, $options, $encryption_iv); 
        return $encryption;                
    }

    public function decrypt($key){
        // Store the cipher method 
        $ciphering = "AES-128-CTR";         
        $options = 0; 
        $decryption_iv = '1234567891011121';
        // Store the decryption key 
        $decryption_key = "emailname"; 
        // Use openssl_decrypt() function to decrypt the data 
        $decryption = openssl_decrypt ($key, $ciphering,  
                $decryption_key, $options, $decryption_iv); 
        return $decryption;
    }

    public function getencrypt(Request $req){
        return $this->send_mail($req->user());
    }
    
    public function enc(Request $req, $emailname){
        return $this->encrypt($emailname);
    }    
    
    public function dec(Request $req, $emailname){
        return $this->decrypt($emailname);
    }
    
}
