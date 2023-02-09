<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'flight_from' => 'required',
            'flight_from.id' => 'required',
            'flight_from.date' => 'required',
            'flight_back' => 'required',
            'flight_back.id' => 'required',
            'flight_back.date' => 'required',
            'passengers.*.first_name' =>'required',
            'passengers.*.last_name' =>'required',
            'passengers.*.document_number' =>'required',
            'passengers.*.birth_date' =>'required|min:10|max:10|date:Y-m-d',
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

        $bookingData = [
          'flight_from' => $request['flight_from.id'],
          'date_from' => $request['flight_from.date'],
            'code' => Str::upper(Str::random(5))
        ];
        if ($request->has('flight_back')){
            $bookingData['flight_back'] = $request['flight_back.id'];
            $bookingData['date_back'] = $request['flight_back.date'];
        }



        $booking = Booking::create($bookingData);
        $booking->passengers()->createMany($request->passengers);
        $booking->flightFrom->date = $booking->date_from;
        if ($booking->flightBack) {
            $booking->flightBack->date = $booking->date_back;
        }

        return response([
            'data' => [
                'code'=> $booking->code
            ]
        ],201);

    }

    public function info($code){
        $booking = Booking::all()->where('code', $code)->first();
        $booking->flightFrom->date = $booking->date_from;
        if ($booking->flightBack) {
            $booking->flightBack->date = $booking->date_back;
        }
        return response([
            'data' => BookingResource::make($booking)
        ]);
    }

    public function seatInfo($code){
        $booking = Booking::where('code', $code)->first();

        $occuptedFrom = $booking->passengers->map(function ($item){
            return [
              'passenger_id' => $item->id,
                'place' => $item->place_from
            ];
        })->filter(function ($passenger){
            return $passenger['place'] !== null;
        });

        $occuptedBack = [];

        if ($booking->flight_back){
            $occuptedBack = $booking->passengers->map(function ($item){
                return [
                    'passenger_id' => $item->id,
                    'place' => $item->place_back
                ];
            })->filter(function ($passenger){
                return $passenger['place'] !== null;
            });
        }

        return response([
            'date' => [
                'occupied_from' => $occuptedFrom,
                'occupied_back' => $occuptedBack,
            ]
        ], 200);
    }

    public function changeSeat(Request $request, $code){
        $validate = Validator::make($request->all(), [
            'passenger' => 'required|exists:passengers,id',
            'seat' => 'required|max:2|min:2',
            'type' => 'required|min:4|max:4'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validate->errors()
                ]
            ], 422);
        }
        $booking = Booking::where('code', $code)->first();

            if ($currPassenger = $booking->passengers->find($request['passenger'])) {
                if ($request->type === 'from'){
                    $passenger = Passenger::all()->where('booking_id', $booking->id)->where('place_from', $request->seat)->first();
                    if ($passenger) {
                        return response()->json([
                            'error' => [
                                'code' => 422,
                                'message' => 'Seat is occupied'
                            ]
                        ], 422);
                    }
                    $currPassenger->place_from = $request->seat;
                }
                if ($request->type === 'back'){
                    $passenger = Passenger::all()->where('booking_id', $booking->id)->where('place_back', $request->seat)->first();
                    if ($passenger) {
                        return response()->json([
                            'error' => [
                                'code' => 422,
                                'message' => 'Seat is occupied'
                            ]
                        ], 422);
                    }
                    $currPassenger->place_back = $request->seat;
                }

                $currPassenger->save();

                return response([
                    'data'=> [
                        'id' => $currPassenger->id,
                        'first_name' => $currPassenger->first_name,
                        'last_name' => $currPassenger->last_name,
                        'birth_date' => $currPassenger->birth_date,
                        'document_number' => $currPassenger->document_number,
                        'place_from' => $currPassenger->place_from,
                        'place_back' => $currPassenger->place_back,
                    ]
                ], 200);
            }
        return response()->json([
            'error' => [
                'code' => 403,
                'message' => 'Passenger does not apply to booking',
            ]
        ], 403);


    }
}
