<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    //
    public function register (Request $request)
    {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password'=> Hash::make($request['password']),
        ]);
        return response()->json(['message' => 'user createed']);
    }
}
