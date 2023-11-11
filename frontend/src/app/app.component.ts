import {Component, OnInit} from '@angular/core';
import {Router} from "@angular/router";
import { CommonModule } from "@angular/common";
import {MenuItem, MessageService, PrimeIcons} from "primeng/api";
import { User } from "./models/grammar-courses";
import {PRIMENG_BARREL} from "./barrel/primeng.barrel";

@Component({
  selector: 'app-root',
  standalone: true,
  templateUrl: './app.component.html',
  imports: [
    CommonModule,
    PRIMENG_BARREL
  ],
  providers: [MessageService],
  styleUrls: ['./app.component.less']
})
export class AppComponent implements OnInit{
  value = '';
  protected user: false | User = {
    name: 'Lennard Ortmeyer',
    password: '!Ich bin der Beste123!',
    image: 'https://picsum.photos/80/80',
    score: 250
  };
  protected userInitials: string = ''
  protected sidebar: boolean = false;
  protected userMenu: MenuItem[] = [
    {label: this.user ? this.user.name: '', icon: 'pi pi-user'}
  ]
  protected showMenu = false;

  constructor(private router: Router) {
  }
  ngOnInit(): void {
    // TODO ausbauen wenn Login implementiert ist
    var subscription = this.router.events.subscribe(() => {
      if (this.router.url == '/login') {
        subscription.unsubscribe()

        this.user = {
          name: 'Lennard Ortmeyer',
          password: '!Ich bin der Beste123!',
          image: 'https://picsum.photos/80/80',
          score: 187
        }
        this.userInitials = this.getUserInitials(this.user.name)

        this.router.navigate([''])
      }
    })
  }


  toggleSidebar(): void {
    this.sidebar = !this.sidebar;
  }

  getUserInitials(username: string): string {
    let usernameSplit = username.trim().split(' ');
    if (usernameSplit.length == 1) {
      return usernameSplit[0][0]
    }
    return usernameSplit[0][0] + usernameSplit[usernameSplit.length-1][0]
  }

  toggleMenu() {
    this.showMenu = !this.showMenu
  }

  protected readonly PrimeIcons = PrimeIcons;

  logOut() {
    this.user = false;
  }
}
