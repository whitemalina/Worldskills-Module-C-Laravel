<?php

namespace App\Http\Resources;

use App\Models\Flight;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'code' => $this->code,
            'cost' => $this->getCost(),
            'flights' => FlightResource::collection($this->flightBack ? [$this->flightFrom, $this->flightBack] : [$this->flightFrom]),
            'passengers' => PassengerResource::collection($this->passengers)
        ];
    }
}
