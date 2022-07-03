<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearCountry extends Model
{
    use HasFactory;
    protected $fillable = [
        'year_id',
        'country_id',
        'population'
        
        
    ];
}
