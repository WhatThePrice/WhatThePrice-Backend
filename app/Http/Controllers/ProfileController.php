<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use JWTAuth;

class ProfileController extends Controller
{
    //
    public function updateProfile(Request $request){

        $profiles = Profile::updateOrCreate(
        [
            'user_id'   => JWTAuth::parseToken()->authenticate()->id
        ],
        [
            'postcode' => $request->get('postcode'),
            'gender' => $request->get('gender'),
            'birth_date' => $request->get('birth_date'),
            'phone_number' => $request->get('phone_number')
        ]
            );

        $status = 'success';

        return response()->json(compact('profiles','status'),201);
    }

    public function getProfile(){

        $id = JWTAuth::parseToken()->authenticate()->id;

        $userProfile = DB::table('users')
                    ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
                    ->select('users.id','users.name','users.email','users.user_type',
                             'profiles.gender', 'profiles.phone_number', 'profiles.postcode',
                             'profiles.birth_date')
                    ->where('users.id', $id)
                    ->get();


        $status = 'success';

        return response()->json(compact('userProfile','status','id'),201);
    }


}
