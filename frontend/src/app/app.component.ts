import {Component, OnInit} from '@angular/core';
import {Router} from "@angular/router";
import { CommonModule } from "@angular/common";
import {MessageService, PrimeIcons} from "primeng/api";
import {CourseGroup, User} from "./models/grammar-courses";
import {PRIMENG_BARREL} from "./barrel/primeng.barrel";
import {CourseServiceService} from "./services/course/course-service.service";

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
  protected showMenu = false;
  courses: CourseGroup[] = []

  constructor(private router: Router, private courseService: CourseServiceService) {
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

  getCourses(): void {
    this.courseService.getCourseGroups().subscribe(response => this.courses = response)
  }

  toggleSidebar(): void {
    this.sidebar = !this.sidebar;
    if (this.sidebar) {
      return this.getCourses()
    }
    this.courses = []
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
