<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends BaseModel
{
    protected $transformerClass = 'App\Transformers\DayTransformer';
    
    protected $fillable = [
        'date',
        'sunset',
        'sunrise',
        'moon',
        'geomagnetic',
    ];
    
    public function forecasts()
    {
        return $this->hasMany('App\Models\Forecast');
    }
}
