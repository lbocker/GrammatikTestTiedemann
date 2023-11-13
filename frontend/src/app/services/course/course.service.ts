import { Injectable } from '@angular/core';
import { Course } from '../../models/course';
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Observable } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class CourseService {

  constructor(private http: HttpClient) { }

  private coursesUrl = 'api/courses';

  httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  }

  getCourses(): Observable<Course[]> {
    return this.http.get<Course[]>(this.coursesUrl)
  }

  getCourse(id: Number): Observable<Course> {
    const url = `${ this.coursesUrl }/${ id }`;
    return this.http.get<Course>(url);
  }

  updateCourseStatus(course: Course): Observable<any> {
    return this.http.put(this.coursesUrl, course, this.httpOptions);
  }
}
