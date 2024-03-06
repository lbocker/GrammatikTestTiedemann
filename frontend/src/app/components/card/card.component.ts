import { Component, Input, OnInit } from '@angular/core';
import { CommonModule, NgOptimizedImage } from '@angular/common';
import { GrammarCourses } from '../../models/grammar-courses.model';
import { Router } from '@angular/router';
import { PRIMENG_BARREL } from '../../barrel/primeng.barrel';
import { CourseServiceService } from '../../services/course/course-service.service';
import { CourseGroup } from '../../models/grammar-courses';

@Component({
  selector: 'app-card',
  standalone: true,
  imports: [CommonModule, NgOptimizedImage, PRIMENG_BARREL],
  templateUrl: './card.component.html',
  styleUrls: ['./card.component.less']
})
export class CardComponent implements OnInit {
  @Input()
  grammarCourses: CourseGroup[] = [ ];

  ngOnInit(): void {
    this.courseService.getCourseGroups()
      .subscribe({
        next: (response: any) => {
          this.grammarCourses = response
        }
      })
  }

  constructor(
    private readonly router: Router,
    private readonly courseService: CourseServiceService
  ) {
  }

  trackByCourse(index: number, item: CourseGroup): number {
    return item.id;
  }

  openCourse(course: CourseGroup): void {
    this.router.navigate([`course/${ course.id }/overview`])
  }
}
