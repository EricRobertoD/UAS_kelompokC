<?php

namespace App\Http\Controllers;

// use Controller;
use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Verified;

class AuthController extends Controller
{
    public function verify(Request $request) {
        $user = User::findOrFail($request->id);

        if (! hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                "message" => "Unauthorized",
                "success" => false
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                "message" => "User already verified!",
                "success" => false
            ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json([
            "message" => "Email verified successfully!",
            "success" => true
        ]);
    }

    public function register(Request $request){
        $registrationData = $request->all();    // Mengambil seluruh data input dan menyimpan dalam variabel registratinoData
        
        $validate = Validator::make($registrationData, [
            'nama_user' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'email' => 'required|email:rfc,dns|unique:users',
            'telepon' => 'required|digits_between:10,13',
            'gender' => 'required'
            
         ]);    // rule validasi input saat register

         if($validate->fails())    // Mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);   // Mengembalikan error validasi input

        $registrationData['password'] = bcrypt($request->password); // Untuk meng-enkripsi password

        $user = User::create($registrationData);    // Membuat user baru
        $user->sendEmailVerificationNotification();

        return response([
            'message' => 'Register Success',
            'user' => $user
        ], 200); // return data user dalam bentuk json

    }

    public function login (Request $request){
        $loginData = $request->all();
        //$status = 0;
 
        $validate = Validator::make($loginData, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        if(Auth::guard('web')->attempt($loginData)){
            $user = Auth::user();
            if($user->email_verified_at == null){
            return response(['message' => "Your Accout Email must be verified before you can continue"],403);
        }
            $token = $user->createToken('Authentication Token')->accessToken;   //generate token

            return response([
                'message' => 'Authenticated',
                'user' => $user,
                'token_type' => 'Bearer',
                'access_token' => $token,
            ]); // return data user dan token dalam bentuk json
        }else{
            return response(['message' => 'Invalid Credentials user'], 401);  // Mengembalikan error gagal login
        }
        return new ResourceUser(true, 'User berhasil login', $response);
        
    
    }
    public function logout(Request $request){
        $user = $request->user()->token();
        $dataUser = $request->user();
        $user->revoke();
        return response([
            'message' => 'Logout Succes',
            'user' => $dataUser
        ]);
    }
}