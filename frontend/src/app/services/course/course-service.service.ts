import { Injectable } from '@angular/core';
import { CourseGroup } from '../../models/course-group.model';
import { Task } from '../../models/task.model';
import { User } from '../../models/user.model';
import { map, Observable, of, timer } from 'rxjs';
import { HttpService } from '../common/http.service';

@Injectable({
  providedIn: 'root'
})
export class CourseServiceService {
  user?: User;

  constructor(
    private readonly httpService: HttpService
  ) {
  }

  getCourseGroups(): Observable<CourseGroup[]> {
    return this.httpService.get('/api/courses')
  }

  getCourse(id: any): Observable<CourseGroup | undefined> {
    return this.httpService.get('/api/courses/' + id)
  }

  getQuizSet(id: number): Observable<any> {
    return this.httpService.get(`api/course/${id}/quizzes`)
  }
}