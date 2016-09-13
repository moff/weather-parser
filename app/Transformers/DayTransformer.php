<?php
namespace App\Transformers;

use App\Models\Day;
use League\Fractal;

class DayTransformer extends Fractal\TransformerAbstract
{
    protected $availableIncludes = ['forecasts'];
    protected $defaultIncludes = ['forecasts'];

    public function transform(Day $day = null)
    {
        if (!$day) {
            return [];
        }

        return [
            'id' => (int) $day->id,
            'date' => $day->date,
            'sunset' => $day->sunset,
            'sunrise' => $day->sunrise,
            'moon' => $day->moon,
            'geomagnetic' => $day->geomagnetic,
        ];
    }
    
    public function includeForecasts(Day $day)
    {
        $forecasts = $day->forecasts;

        return $this->collection($forecasts, new ForecastTransformer);
    }
}
