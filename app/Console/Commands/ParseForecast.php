<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use duzun\hQuery;
use Carbon\Carbon;
use App\Models\Day;

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
        Day::where('date','>=', $date->toDateString())->delete();
        
        foreach ($dayRows as $key => $row) {
            
            // day data
            $data = [];
            $data['date'] = $date->toDateString();
            
            $this->info('Parsing data for ' . $data['date']) . '...';
            
            if ($sunrise = $row->find($selectors['sunrise']))           $data['sunrise'] = $sunrise->text();
            if ($sunset = $row->find($selectors['sunset']))             $data['sunset'] = $sunset->text();
            if ($moon = $row->find($selectors['moon']))                 $data['moon'] = $moon->attr('title');
            if ($geomagnetic = $row->find($selectors['geomagnetic']))   $data['geomagnetic'] = $geomagnetic->text();
            
            // create day
            $day = Day::create($data);
            
            $forecasts = [];
            $forecastRows = $row->find($selectors['forecastRows']);
            
            foreach ($forecastRows as $key => $row) {
                $data = [];
                
                if ($daytime = $row->find($selectors['daytime']))               $data['daytime'] = $daytime->text();
                if ($temperature = $row->find($selectors['temperature']))       $data['temperature'] = $temperature->text();
                if ($condition = $row->find($selectors['condition']))           $data['condition'] = $condition->text();
                if ($pressure = $row->find($selectors['pressure']))             $data['pressure'] = $pressure->text();
                if ($humidity = $row->find($selectors['humidity']))             $data['humidity'] = $humidity->text();
                if ($windDirection = $row->find($selectors['windDirection']))   $data['windDirection'] = $windDirection->text();
                if ($windSpeed = $row->find($selectors['windSpeed']))           $data['windSpeed'] = $windSpeed->text();
                
                $forecasts[] = $data;
            }
            
            // save related data
            $day->forecasts()->createMany($forecasts);
            
            $date->addDay();
        }
        
        $this->info('Parsed!');
    }
}
