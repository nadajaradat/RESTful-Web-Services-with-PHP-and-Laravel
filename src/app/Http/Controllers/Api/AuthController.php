<?php
/* app\Http\Controllers\Api\AuthController.php */

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    //
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));
        $created_user = User::where('email', '=', $request->email)->first();
        return response()->json([
            'user' => $created_user,
            'stus' => 'registered',
            'verified' => false
        ], 200);
    }
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only("email", "password"))) {
            return response()->json(
                [
                    "user" => Null,
                    "message" => "Invalid login details",
                    "stus" => "failed",
                ],
                200
            );
        }
        $user = User::where("email", $request["email"])->firstOrFail();
        $user_loggedin = [
            'id' => $user->id,
            'email' => $user->email,
            'email_verified_at' =>  $user->email_verified_at,
            'stus' => 'loggedin'
        ];
        $token = $user->createToken("auth_token")->plainTextToken;
        $user_loggedin['token'] = $token;
        $user_loggedin['token_type'] = 'Bearer';

        return response()->json(
            $user_loggedin,
            200
        );
    }
}
