import { Injectable } from '@angular/core';
import {
    HttpRequest,
    HttpHandler,
    HttpEvent,
    HttpInterceptor, HttpHeaders
} from '@angular/common/http';
import { Observable } from 'rxjs';
import { CourseService } from '../services/course/course.service';

@Injectable()
export class URLInterceptor implements HttpInterceptor {
    static URL: string = 'http://localhost:8000/api';

    constructor(private readonly service: CourseService) {
    }

    intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        let header: HttpHeaders = request.headers.set('username', this.service.user?.name ?? 'unset')
        header = header.set('password', this.service.user?.password ?? 'unset')
        console.log(header)
        const modifiedRequest = request.clone({
            headers: header,
            url: URLInterceptor.URL + request.url.startsWith('/') ? '' : `/${ request.url }`
        });

        return next.handle(modifiedRequest);
    }
}
