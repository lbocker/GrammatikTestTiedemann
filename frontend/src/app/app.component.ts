import { Component } from '@angular/core';
import { CardComponent } from "./components/card/card.component";
import {RouterLink, RouterOutlet} from "@angular/router";
import { MatInputModule } from "@angular/material/input";
import { MatIconModule } from "@angular/material/icon";
import { FormsModule } from "@angular/forms";
import { MatButtonModule } from "@angular/material/button";
import { CommonModule } from "@angular/common";

@Component({
  selector: 'app-root',
  standalone: true,
  templateUrl: './app.component.html',
  imports: [
    CardComponent,
    RouterLink,
    MatInputModule,
    MatIconModule,
    FormsModule,
    MatButtonModule,
    CommonModule,
    RouterOutlet
  ],

  styleUrls: ['./app.component.less']
})
export class AppComponent {
  value = '';
  user = false;
}
