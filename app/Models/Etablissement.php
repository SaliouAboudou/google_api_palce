<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
      use HasFactory;

    protected $fillable = [
        'name',
        'formatted_address',
        'vicinity',
        'contact',
        'place_id',
    ];
}
