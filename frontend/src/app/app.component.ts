import {Component, OnInit} from '@angular/core';
import {Router} from "@angular/router";
import { CommonModule } from "@angular/common";
import {MessageService, PrimeIcons} from "primeng/api";
import {CourseGroup, User} from "./models/grammar-courses";
import {PRIMENG_BARREL} from "./barrel/primeng.barrel";
import {CourseServiceService} from "./services/course/course-service.service";
import { HttpClient, HttpClientModule } from "@angular/common/http";

@Component({
  selector: 'app-root',
  standalone: true,
  templateUrl: './app.component.html',
  imports: [
    CommonModule,
    PRIMENG_BARREL,
    HttpClientModule
  ],
  providers: [MessageService],
  styleUrls: ['./app.component.less']
})
export class AppComponent{
  value = '';
  protected user: false | User = false;

  protected userInitials: string = ''
  protected sidebar: boolean = false;
  protected showMenu = false;
  courses: CourseGroup[] = []

  constructor(private router: Router, private courseService: CourseServiceService) {
    this.courseService.user = this.user?this.user:undefined;
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
    this.courseService.user = undefined
  }
}
