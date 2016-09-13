import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs/Subscription';
import { IDay } from '../day/day.interface';
import { DayService } from '../day/day.service';

@Component({
	template: require('./home.component.html')
})
export class HomeComponent implements OnInit {
    private _sub: Subscription;
    
    days: IDay[] = [];
    errorMessage: string;
    
    constructor(private _dayService: DayService) {}
    
    ngOnInit(): void {
        this._sub = this._dayService.getDays()
            .subscribe(
                days => { 
                    this.days = days; 
                },
                error => this.errorMessage = <any>error);
    }
    
    ngOnDestroy(): void {
        this._sub.unsubscribe();
    }
}
