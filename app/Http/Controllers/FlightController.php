<?php

namespace App\Http\Controllers;

use App\Http\Resources\FlightResource;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{


    function getFlights($from, $to, $date){


         $flights = Flight::query()->whereHas('fromAirport', function ($q) use ($from){
             $q->where('iata', $from);
         })->whereHas('toAirport', function ($q) use ($to){
             $q->where('iata', $to);
         })->get();

         $flights->map(function ($flight) use ($date){
             $flight->setDate($date);
         });

         return $flights;
    }


    public function search(Request $request){
        $validator = Validator::make($request->all(), [
            'date1' => 'required',
            'from' => 'required',
            'to' => 'required',
            'passengers' => 'required|int',
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

        return response([
            'data' => [
                'flights_to' => FlightResource::collection($this->getFlights($request->from, $request->to, $request->date1)),
                'flights_back' => $request->date2 ? FlightResource::collection($this->getFlights($request->to, $request->from, $request->date2)) : []
            ]
        ], 200);


    }


}
