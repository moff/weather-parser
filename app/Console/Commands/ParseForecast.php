<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use duzun\hQuery;
use Carbon\Carbon;

class ParseForecast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:forecast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse weather forecast.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting to parse weather forecast!');
        
        $selectors = [
            "sunrise"       => ".forecast-detailed__sunrise .forecast-detailed__value",
            "sunset"        => ".forecast-detailed__sunset .forecast-detailed__value",
            "moon"          => ".forecast-detailed__moon i",
            "geomagnetic"   => ".forecast-detailed__geomagnetic-field .forecast-detailed__value",
            "forecastRows"  => ".weather-table:first tbody tr",
            "temperature"   => ".weather-table__body-cell_type_daypart .weather-table__temp",
            "daytime"       => ".weather-table__body-cell_type_daypart .weather-table__daypart",
            "condition"     => ".weather-table__body-cell_type_condition .weather-table__value",
            "pressure"      => ".weather-table__body-cell_type_air-pressure .weather-table__value",
            "humidity"      => ".weather-table__body-cell_type_humidity .weather-table__value",
            "windDirection" => ".weather-table__body-cell_type_wind .weather-table__value abbr",
            "windSpeed"     => ".weather-table__body-cell_type_wind .weather-table__value .wind-speed",
        ];
        
        $doc = hQuery::fromUrl('https://yandex.ru/pogoda/moscow/details');
        
        $daysTable = $doc->find('.forecast-detailed:first');
        $dayRows  = $daysTable->find('dd');
        
        $date = Carbon::now();
        
        // delete data for next days - we're going to get updated forecasts
        // Day::where('date','>=', $date->toDateString())->delete();
        
        foreach ($dayRows as $key => $row) {
            $this->info('--- ' . $date->toDateString());
            
            if ($sunrise = $row->find($selectors['sunrise'])) $this->info($sunrise->text());
            if ($sunset = $row->find($selectors['sunset'])) $this->info($sunset->text());
            if ($moon = $row->find($selectors['moon'])) $this->info($moon->attr('title'));
            if ($geomagnetic = $row->find($selectors['geomagnetic'])) $this->info($geomagnetic->text());
            
            $data = [
                'sunset' => $sunset,
                'sunrise' => $sunrise,
                'moon' => $moon,
                'geomagnetic' => $geomagnetic,
            ];
            
            
            
            // create day
            // $day = Day::create($data);
            
            $forecasts = [];
            $forecastRows = $row->find($selectors['forecastRows']);
            
            foreach ($forecastRows as $key => $row) {
                $rowData = [];
                
                if ($daytime = $row->find($selectors['daytime'])) $rowData['daytime'] = $daytime->text();
                if ($temperature = $row->find($selectors['temperature'])) $rowData['temperature'] = $temperature->text();
                if ($condition = $row->find($selectors['condition'])) $rowData['condition'] = $condition->text();
                if ($pressure = $row->find($selectors['pressure'])) $rowData['pressure'] = $pressure->text();
                if ($humidity = $row->find($selectors['humidity'])) $rowData['humidity'] = $humidity->text();
                if ($windDirection = $row->find($selectors['windDirection'])) $rowData['windDirection'] = $windDirection->text();
                if ($windSpeed = $row->find($selectors['windSpeed'])) $rowData['windSpeed'] = $windSpeed->text();
                
                $forecasts[] = $rowData;
            }
            
            // save related data
            // $day->forecasts()->create($forecasts);
            
            $this->info(var_dump($forecasts));
            
            $date->addDay();
        }
    }
}
