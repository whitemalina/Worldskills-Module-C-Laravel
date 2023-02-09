<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'document_number',
        'birth_date',
    ];


}
