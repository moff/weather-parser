import { IForecast } from '../forecasts/forecast.interface.ts';

export interface IDay {
    id: number;
    sunset: string;
    sunrise: string;
    moon: string;
    geomagnetic: string;
    forecasts: IForecast[];
}
