<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $fillable = [
        'date',
        'sunset',
        'sunrise',
        'moon',
        'geomagnetic',
    ];
    
    public function forecasts()
    {
        return $this->hasMany('App\Forecast');
    }
}
