<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     summary="Register new User",
     *     path="/api/register",
     *     tags={"Regigter"},
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password_confirmation",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(response=200, description="Success",
     *     @OA\MediaType(mediaType="application/json",)),
     *     @OA\Response(response=400,description="Bad Request"),
     *     @OA\Response(response=404,description="not found"),
     *     @OA\Response(response=403,description="Forbidden")
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|unique:users',
            'password' => ['required','confirmed','min:1']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $user = User::create([
            'name' => $request->email,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => 'default'
        ]);
        UserServices::app($user)->generateVerificationCode($user);
        return response()->json([
            'status' => true,
            'message' => 'Успешное регистрация пользователя'
        ]);
    }

    /**
     * @OA\Post(
     *     summary="Login User",
     *     path="/api/login",
     *     tags={"Login"},
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(response=200, description="Success",
     *     @OA\MediaType(mediaType="application/json",)),
     *     @OA\Response(response=400,description="Bad Request"),
     *     @OA\Response(response=404,description="not found"),
     *     @OA\Response(response=403,description="Forbidden")
     * )
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => ['required']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $user = User::where('email',$request->email)->first();
        if ($user->email_verified_at === null) {
            UserServices::app($user)->generateVerificationCode($user);

            return response()->json([
                'status' => 'error',
                'message' => 'Email not verified. Verification code sent to your email.'
            ], 403);
        }
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }

        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
        ]);
    }

    /**
     * @OA\Post(
     *     summary="Logout User",
     *     path="/api/logout",
     *     tags={"Logout"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Success",
     *     @OA\MediaType(mediaType="application/json",)),
     *     @OA\Response(response=400,description="Bad Request"),
     *     @OA\Response(response=404,description="not found"),
     *     @OA\Response(response=403,description="Forbidden")
     * )
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message"=>"logged out"
        ]);
    }
}
