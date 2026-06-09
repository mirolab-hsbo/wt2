<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $existent_user_count = User::where('email', $request->email)->count();
        if ($existent_user_count > 0) {
            return response("Benutzer mit derselben E-Mail-Adresse oder demselben Benutzername existiert bereits.", Response::HTTP_CONFLICT);
        }
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $token = $user->createToken('myToken');
        return response()->json(['token' => $token->plainTextToken]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where(['email' => $request->email])->first();
        if (!empty($user) && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('myToken');
            return response()->json(['token' => $token->plainTextToken]);
        }
        return response("Nutzer nicht gefunden oder Passwort falsch.", Response::HTTP_UNAUTHORIZED);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
    }
}
