import { Injectable } from '@angular/core';
import { Course } from '../../models/course';
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Observable } from "rxjs";
import { URLInterceptor } from "../../interceptor/url.interceptor";

@Injectable({
  providedIn: 'root'
})
export class CourseService {

  constructor(private http: HttpClient) { }

  httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  }

  getCourses(): Observable<Course[]> {
    return this.http.get<Course[]>(URLInterceptor.URL + '/courses')
  }

  getCourse(id: Number): Observable<Course> {
    const url = `${ URLInterceptor.URL }/course/${ id }`;
    return this.http.get<Course>(url);
  }

  updateCourseStatus(course: Course): Observable<any> {
    return this.http.put( URLInterceptor.URL + '/courses', course, this.httpOptions);
  }
}
