import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
    providedIn: 'root'
})
export class TasksService {

    private readonly tasksUrl = 'api/tasks';

    constructor(private readonly http: HttpClient) {
    }

    getTasks(): Observable<any> {
        return this.http.get(this.tasksUrl);
    }

    getTask(id: Number): Observable<any> {
        const url = `${ this.tasksUrl }/${ id }`;
        return this.http.get(url);
    }
}
