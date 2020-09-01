<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
//////_____USER LOGIN_____///////////////////////////////////////////////////
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = JWTAuth::user();

        $status = 'success';

        return response()->json(compact('status','user','token'));
    }

//////_____USER REGISTRATION_____///////////////////////////////////////////////////
    public function register(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        $status = 'success';

        return response()->json(compact('user','token',"status"),201);
    }

//////_____SHOW USER DETAILS_____///////////////////////////////////////////////////
    public function getUser()
        {
                try {

                        if (! $user = JWTAuth::parseToken()->authenticate()) {
                                return response()->json(['user_not_found'], 404);
                        }

                } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                        return response()->json(['token_expired'], $e->getStatusCode());

                } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                        return response()->json(['token_invalid'], $e->getStatusCode());

                } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                        return response()->json(['token_absent'], $e->getStatusCode());

                }

                $status = 'success';

                return response()->json(compact('user','status'));
        }

//////_____UPGRADE USER TO PREMIUM_____///////////////////////////////////////////////////
    public function userUpgrade(Request $request){

        $id = JWTAuth::parseToken()->authenticate()->id;
        $users = User::find($id);
        $users->user_type =  'premium';

        $users->save();

        $status = 'success';
        return response()->json(compact('users','status'), 201);
    }

//////_____DOWNGRADE USER TO FREE_____///////////////////////////////////////////////////
    public function userDowngrade(Request $request){

        $id = JWTAuth::parseToken()->authenticate()->id;
        $users = User::find($id);
        $users->user_type =  'free';

        $users->save();

        $status = 'success';
        return response()->json(compact('users','status'), 201);
    }
}
