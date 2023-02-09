<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|unique:users',
            'document_number' => 'required|string|max:10|min:10',
            'password' => 'required|string',
        ]);

        if ($validator->fails()){
            return response([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ]
            ]);
        }

        User::create($validator->validated());

        return response('', 204);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required|exists:users',
            'password' => 'required|string',
        ]);

        if ($validator->fails()){
            return response([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ]
            ]);
        }

        $user = User::query()->where('phone', $request->phone)->where('password', $request->password)->first();

        if ($user){
              $token= $user->api_token = Str::random(32);

            $user->save();
            return response([
                'data'  => [
                    'token' => $token
                ]
            ], 200);
        }

        return response([
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized',
            ]
        ]);


    }

    public function bookings(Request $request){
        $token = $request->bearerToken();

        if ($user = User::where('api_token', $token)->first()) {
            $bookings = Booking::query()->whereHas('passengers', function ($q) use ($user){
                $q->where('document_number', $user->document_number);
            })->get();

            return response([
                'data' => [
                    'items' => BookingResource::collection($bookings)
                ]
            ], 200);
        }

        return response([
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized',
            ]
        ]);



    }


    public function info(Request $request){
        $token = $request->bearerToken();

        if ($user = User::where('api_token', $token)->first()) {

            return response([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone' => $user->phone,
                'document_number' => $user->document_number,
            ],200);
        }

        return response([
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized',
            ]
        ]);
    }
}
