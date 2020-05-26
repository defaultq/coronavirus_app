<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class GlobalData extends Model
{
    protected $fillable = ['date', 'country', 'province', 'latitude', 'longitude', 'recovered', 'deaths', 'confirmed'];
}
