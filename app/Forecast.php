<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    protected $fillable = [
        'daytime',
        'temperature',
        'condition',
        'pressure',
        'humidity',
        'windDirection',
        'windSpeed',
    ];
    
    public function day()
    {
        return $this->belongsTo('App\Day');
    }
}
