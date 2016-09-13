import { Component, OnInit, OnDestroy } from '@angular/core';
import { Day, DayService } from './day.service';
import { Router, ActivatedRoute } from '@angular/router';
import { Subscription } from 'rxjs/Subscription';

@Component({
    template: require('./day.component.html')
})
export class DayComponent implements OnInit {
    
    day: Day;

    private _sub: Subscription;

    constructor(
        private _route: ActivatedRoute,
        private _router: Router,
        private _dayService: DayService) {}

    ngOnInit() {
        this._sub = this._route.params.subscribe(params => {
            let id = +params['id']; // (+) converts string 'id' to a number
            this.day = this._dayService.getDay(id);
        });
    }

    ngOnDestroy() {
        this._sub.unsubscribe();
    }

}
