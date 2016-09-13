import { Component, OnInit, OnDestroy } from '@angular/core';
import { DayService } from './day.service';
import { IDay } from './day.interface';
import { Router, ActivatedRoute } from '@angular/router';
import { Subscription } from 'rxjs/Subscription';

@Component({
    template: require('./day.component.html')
})
export class DayComponent implements OnInit, OnDestroy {
    
    private _sub: Subscription;
    
    day: IDay = <IDay>{};
    errorMessage: string;

    constructor(
        private _route: ActivatedRoute,
        private _router: Router,
        private _dayService: DayService) {}

    ngOnInit() {
        this._sub = this._route.params.subscribe(params => {
            let id = +params['id']; // (+) converts string 'id' to a number
            this._dayService.getDay(id)
                .subscribe(
                    day => this.day = day,
                    error => this.errorMessage = <any>error
                );
        });
    }

    ngOnDestroy() {
        this._sub.unsubscribe();
    }

}
