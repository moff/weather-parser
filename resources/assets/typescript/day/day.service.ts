import { Injectable } from '@angular/core';
import { Http, Response, Headers } from '@angular/http';
import { IDay } from './day.interface';

import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/do';
import 'rxjs/add/operator/catch';

@Injectable()
export class DayService {
    
    private _daysUrl: string = 'api/days';
    private headers: Headers;
    
    constructor(private _http: Http) {
        this.headers = new Headers();
        this.headers.append('Content-Type', 'application/json');
    }
    
    getDays(): Observable<IDay[]> {
        return this._http.get(this._daysUrl)
            .map((response: Response) => <IDay[]>response.json())
            .do(data => console.log('All: ' + JSON.stringify(data)))
            .catch(this.handleError);
    }
    
    getDay(id: number): Observable<IDay> {
        return this._http.get(this._daysUrl + '/' + id)
            .map((response: Response) => <IDay>response.json())
            .do(data => console.log('Day: ' + JSON.stringify(data)))
            .catch(this.handleError);
    }
    
    private handleError(error: Response) {
        console.error(error);
        return Observable.throw(error.json().error || 'Server error');
    }
    
}
