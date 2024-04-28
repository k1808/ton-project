<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|unique:users',
            "firstName"=> 'required|string',
            "lastName"=> 'required|string',
            "link"=> 'required|string',
            "userType" => 'required|numeric',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
 
        if ($id <= 0 ) {
            return response()->json(['error' => 'Invalid userId supplied'], 400);
        }
        $user = User::where(['id'=>$id])->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->update([
            'phone' => $request->phone,
            "firstName"=> $request->firstName,
            "lastName"=> $request->lastName,
            "link"=> $request->link,
            "role_id"=>$request->userType
        ]);
        return response()->json(['user' => new UserResource($user)], 200);
    }

    public function del($id)
    {
        if ($id <= 0 ) {
            return response()->json(['error' => 'Invalid userId supplied'], 400);
        }
        $user = User::where(['id'=>$id])->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['msg' => 'user deleted'], 200);
    }

    public function index()
    {
        $users = User::all();

        return response()->json(['users' => UserResource::collection($users)], 200);
    }
    public function show($id)
    {
        if ($id <= 0 ) {
            return response()->json(['error' => 'Invalid userId supplied'], 400);
        }
        $user = User::where(['id'=>$id])->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json(['user' => new UserResource($user)], 200);
    }
}
