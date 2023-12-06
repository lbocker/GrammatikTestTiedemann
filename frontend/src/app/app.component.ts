import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common';
import { MessageService, PrimeIcons } from 'primeng/api';
import { CourseGroup } from './models/course-group.model';
import { User } from './models/user.model';
import { PRIMENG_BARREL } from './barrel/primeng.barrel';
import { CourseServiceService } from './services/course/course-service.service';
import { HttpClientModule } from '@angular/common/http';

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
export class AppComponent implements OnInit {
  value = '';
  courses: CourseGroup[] = []

  protected user: false | User = {
    name: 'Lennard Ortmeyer',
    password: '!Ich bin der Beste123!',
    image: 'https://picsum.photos/80/80',
    score: 250
  };
  protected userInitials: string = ''
  protected sidebar: boolean = false;
  protected showMenu = false;

  protected readonly PrimeIcons = PrimeIcons;

  constructor(private readonly router: Router, private readonly courseService: CourseServiceService) {
    this.courseService.user = this.user ? this.user : undefined;
  }

  ngOnInit(): void {
    // TODO ausbauen wenn Login implementiert ist
    const subscription = this.router.events.subscribe(() => {
      if (this.router.url == '/login') {
        subscription.unsubscribe()

        this.user = {
          name: 'Lennard Ortmeyer',
          password: '!Ich bin der Beste123!',
          image: 'https://picsum.photos/80/80',
          score: 187
        }
        this.userInitials = this.getUserInitials(this.user.name)
        this.courseService.user = this.user;
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
    const usernameSplit = username.trim().split(' ');
    if (usernameSplit.length == 1) {
      return usernameSplit[0][0]
    }
    return usernameSplit[0][0] + usernameSplit[usernameSplit.length - 1][0]
  }

  toggleMenu(): void {
    this.showMenu = !this.showMenu
  }

  logOut(): void {
    this.user = false;
    this.courseService.user = undefined
  }
}
