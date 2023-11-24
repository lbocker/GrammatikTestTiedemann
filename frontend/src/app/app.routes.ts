import { Routes } from '@angular/router';
import { CardComponent } from './components/cards/cards.component';
import { CourseOverviewComponent } from './components/course-overview/course-overview.component';

export const routes: Routes = [
    {path: '', component: CardComponent, pathMatch: 'full'},
    {path: 'login', component: CardComponent},
    {
        path: 'course/:courseId', children: [
            {path: 'overview', component: CourseOverviewComponent}
        ]
    }
];
