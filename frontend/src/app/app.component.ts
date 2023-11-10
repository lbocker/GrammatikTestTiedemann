import { Component } from '@angular/core';
import { CardComponent } from "./components/card/card.component";
import {RouterLink, RouterOutlet} from "@angular/router";
import { MatInputModule } from "@angular/material/input";
import { MatIconModule } from "@angular/material/icon";
import { FormsModule } from "@angular/forms";
import { MatButtonModule } from "@angular/material/button";
import { CommonModule } from "@angular/common";
import { TabMenuModule } from "primeng/tabmenu";
import { MenuItem } from "primeng/api";
import { ButtonModule } from "primeng/button";
import { SidebarModule } from "primeng/sidebar";
import { User } from "./models/grammar-courses";
import { AvatarModule } from "primeng/avatar";

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
    RouterOutlet,
    CommonModule,
    TabMenuModule,
    ButtonModule,
    SidebarModule,
    AvatarModule
  ],

  styleUrls: ['./app.component.less']
})
export class AppComponent {
  value = '';
  protected navigations: MenuItem[] = [
    {label: 'Home', icon: 'pi pi-fw pi-home'},
    {label: 'Login/Register', icon: 'pi pi-fw pi-user', routerLink: 'login'},
  ]
  protected user: false | User = false;
  protected sidebar: boolean = false;

  toogleSidebar(): void {
    this.sidebar = !this.sidebar;
  }
}
