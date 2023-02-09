<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function list(Request $request){
        return response([
            'data' => [
                'items' => Airport::query()->where('city', 'LIKE', "%${request["query"]}%")->orWhere('name', 'LIKE', "%${request["query"]}%")->orWhere('iata', 'LIKE', "%${request["query"]}%")->get()
            ]
        ], 200);
    }
}
