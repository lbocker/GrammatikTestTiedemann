import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class TasksService {

  constructor(private http: HttpClient) { }

  private tasksUrl = 'api/tasks';

  getTasks(): Observable<any> {
    return this.http.get(this.tasksUrl);
  }

  getTask(id: Number): Observable<any> {
    const url = `${ this.tasksUrl }/${ id }`;
    return this.http.get(url);
  }
}
