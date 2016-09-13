import { Routes, RouterModule } from '@angular/router';
import { FeatureListComponent } from './features/feature-list/feature-list.component';
import { FeatureComponent } from './features/feature/feature.component';
import { HomeComponent } from './home/home.component';
import { DayComponent } from './day/day.component';

const appRoutes: Routes = [
    { path: '', component: HomeComponent },
    { path: 'day/:id', component: DayComponent },
    { path: 'features', component: FeatureListComponent },
    { path: 'features/:id', component: FeatureComponent }
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(appRoutes);
