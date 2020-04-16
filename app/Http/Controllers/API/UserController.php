<?php

namespace App\Http\Controllers\API;

use App\User;
use App\TestAPI;
use App\Http\Controllers\API\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
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

        return response()->json(compact('token'));
    }

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

        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
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

        return response()->json(compact('user'));
    }

    public function uploadTest(Request $request) {
        if(!$request->hasFile('image')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $validator = Validator::make($request->all(), [
            'reg_no' => 'required|string|max:255',
            'surname' => 'required|string|string|max:255',
            'first_name' => 'required|string|min:6',
            'middle_name' => 'required|string|min:6',
            'gender' => 'required|string',
            'date_of_birth' => 'required|string|min:6',
            'religion' => 'required|string|min:6',
            'residential_address' => 'required|string|min:6',
            'home_phone' => 'required|string|min:6',
            'state_of_origin' => 'required|string',
            'sponsor_name' => 'required|string|min:6',
            'sponsor_address' => 'required|string|min:6',
            'sponsor_phone' => 'required|string|min:6',
            'sponsor_email' => 'required|email|min:6',
            'proposed_class' => 'required|string',
            'school_attended' => 'required|string|min:6',
            'student_type' => 'required|string',//DAY OR BOARDING
            'cbt_mode' => 'required|string',
            'cbt_day' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 400);
        }
        $file = $request->file('image');
        if(!$file->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $path = public_path() . '/uploads/';
        $file->move($path, $file->getClientOriginalName());
       // $request['image'] = $file->getClientOriginalName();
        //dd($request);
        $data = TestAPI::create([
            'reg_no' => $request['reg_no'],
            'surname' => $request['surname'],
            'first_name' => $request['first_name'],
            'middle_name' => $request['middle_name'],
            'gender' => $request['gender'],
            'date_of_birth' => $request['date_of_birth'],
            'religion' => $request['religion'],
            'residential_address' => $request['residential_address'],
            'home_phone' => $request['home_phone'],
            'state_of_origin' => $request['state_of_origin'],
            'sponsor_name' => $request['sponsor_name'],
            'sponsor_address' => $request['sponsor_address'],
            'sponsor_phone' => $request['sponsor_phone'],
            'sponsor_email' => $request['sponsor_email'],
            'proposed_class' => $request['proposed_class'],
            'school_attended' => $request['school_attended'],
            'student_type' => $request['student_type'],//DAY OR BOARDING
            'cbt_mode' => $request['cbt_mode'],
            'cbt_day' => $request['cbt_day'],
            'image' => $file->getClientOriginalName()
        ]);
        return response()->json(compact('data'), 200);
    }


}