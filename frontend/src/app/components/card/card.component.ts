import { Component, Input } from '@angular/core';
import { CommonModule, NgOptimizedImage } from '@angular/common';
import { GrammarCourses } from '../../models/grammar-courses.model';
import { Router } from '@angular/router';
import { PRIMENG_BARREL } from '../../barrel/primeng.barrel';

@Component({
  selector: 'app-card',
  standalone: true,
  imports: [CommonModule, NgOptimizedImage, PRIMENG_BARREL],
  templateUrl: './card.component.html',
  styleUrls: ['./card.component.less']
})
export class CardComponent {
  @Input()
  grammarCourses: GrammarCourses[] | undefined;

  constructor(private readonly router: Router) {
  }

  trackByCourse(index: number, item: GrammarCourses): number {
    return item.id;
  }

  openCourse(course: GrammarCourses): void {
    this.router.navigate([`course/${ course.id }/overview`])
  }
}
