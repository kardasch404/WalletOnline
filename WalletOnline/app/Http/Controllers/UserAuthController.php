<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Dotenv\Validator;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Mockery\Expectation;

class UserAuthController extends Controller
{
    //
    public function register(Request $request)
    {

        DB::beginTransaction();
        try {

            $newwallet = Wallet::create([
                'argent' => $request->has('argent') ? $request['argent'] : 0,
            ]);


            $user = User::create([
                'name' => $request['name'],
                'lastname' => $request['lastname'],
                'email' => $request['email'],
                'role_id' => $request['role_id'],
                'wallet_id' => $newwallet->id,
                'password' => Hash::make($request['password']),
            ]);
            DB::commit();
            return response()->json([
                'message' => 'user createed',
                'user' => $user,
                'wallet' => $newwallet
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'erroor' . $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validateUser = FacadesValidator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record',
                ], 401);
            }
            $user = User::where('email', $request->email)->first();
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logged out'
        ]);
    }

    public function getSolde($id)
    {
        $user = User::findOrFail($id);
        $wallet = $user->wallet;
        return response()->json([
            'argent' => $wallet->argent,
        ]);
    }

    public function ajouterArgent(Request $request)
    {

        $user = User::where('email', '=', $request->email)->first();
        // return response()->json([
        //     'email' => $user
        // ]);

        $wallet = $user->wallet;
        $wallet->argent = 5000.00;
        $wallet->save();
        return response()->json([
            'wallet' => $wallet
        ]);
    }
}
