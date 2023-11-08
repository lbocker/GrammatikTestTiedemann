import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatButtonModule } from "@angular/material/button";
import { MatFormFieldModule } from "@angular/material/form-field";
import { MatIconModule } from "@angular/material/icon";
import { MatInputModule } from "@angular/material/input";
import { ReactiveFormsModule } from "@angular/forms";
import { debounceTime, distinctUntilChanged, Observable, Subject, switchMap } from "rxjs";
import { CourseServiceService } from "../../services/course/course-service.service";

@Component({
  selector: 'app-courses-search',
  standalone: true,
  imports: [CommonModule, MatButtonModule, MatFormFieldModule, MatIconModule, MatInputModule, ReactiveFormsModule],
  templateUrl: './courses-search.component.html',
  styleUrls: ['./courses-search.component.less']
})
export class CoursesSearchComponent implements OnInit {
  courses$!: Observable<Course[]>;
  private searchTerm = new Subject<string>();

  constructor(private courseService: CourseServiceService) { }

  search(term: string): void {
    this.searchTerm.next(term);
  }

  ngOnInit(): void {
    this.courses$ = this.searchTerm.pipe(
      debounceTime(300),

      distinctUntilChanged(),

      switchMap((term: string) => this.courseService.searchCourse(term)),

    );
  }
}
