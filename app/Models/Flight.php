<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $with = [
      'fromAirport',
      'toAirport'
    ];

    public function fromAirport(){
        return $this->hasOne(Airport::class, 'id', 'from_id' );
    }

    public function toAirport(){
        return $this->hasOne(Airport::class, 'id', 'to_id' );
    }

    public function setDate($date){
        $this->date = $date;
    }


}
