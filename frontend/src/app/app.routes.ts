import { Routes } from '@angular/router';
import { CardComponent } from "./components/card/card.component";

export const routes: Routes = [
  { path: '', component: CardComponent, pathMatch: 'full' },
  { path: 'login', component: CardComponent }
];
