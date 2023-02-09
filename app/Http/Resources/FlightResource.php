<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'flight_id' => $this->id,
          'flight_code' => $this->flight_code,
          'from' => [
              'city' => $this->fromAirport->city,
              'airport' => $this->fromAirport->name,
              'iata' => $this->fromAirport->iata,
              'date' => $this->date,
              'time' => $this->time_from
          ],
            'to' => [
                'city' => $this->toAirport->city,
                'airport' => $this->toAirport->name,
                'iata' => $this->toAirport->iata,
                'date' => $this->date,
                'time' => $this->time_from
            ],

          'cost' => $this->cost,
          'availability' => 60,
        ];
    }
}
