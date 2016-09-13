<?php
namespace App\Transformers;

use App\Models\Forecast;
use League\Fractal;

class ForecastTransformer extends Fractal\TransformerAbstract
{
    protected $availableIncludes = [];
    protected $defaultIncludes = [];

    public function transform(Forecast $forecast = null)
    {
        if (!$forecast) {
            return [];
        }

        return [
            'id' => (int) $forecast->id,
            'daytime' => $forecast->daytime,
            'temperature' => $forecast->temperature,
            'condition' => $forecast->condition,
            'pressure' => $forecast->pressure,
            'humidity' => $forecast->humidity,
            'windDirection' => $forecast->windDirection,
            'windSpeed' => $forecast->windSpeed,
        ];
    }
}

