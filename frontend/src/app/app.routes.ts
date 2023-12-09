import { Routes } from '@angular/router';
import { CardComponent } from './components/card/card.component';
import {CourseOverviewComponent} from './components/course-overview/course-overview.component';
import { LoginComponent } from './components/login/login.component';
import { RegistrationComponent } from './components/registration/registration.component';

export const routes: Routes = [
  { path: '', component: CardComponent, pathMatch: 'full' },
  { path: 'login', component: LoginComponent },
  { path: 'register', component: RegistrationComponent },
  { path: 'course/:courseId', children: [
      {path: 'overview', component: CourseOverviewComponent}
    ]}
];
