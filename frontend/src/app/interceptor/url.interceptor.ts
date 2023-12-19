import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor, HttpHeaders
} from '@angular/common/http';
import { Observable } from 'rxjs';
import { CourseServiceService } from '../services/course/course-service.service';
import { environment } from '../../environments/environment';

@Injectable()
export class URLInterceptor implements HttpInterceptor {

  constructor(private readonly service: CourseServiceService) {
  }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    let header: HttpHeaders = request.headers.set('username', this.service.user?.name ?? 'unset')
    header = header.set('password', this.service.user?.password ?? 'unset')
    console.log(header)
    const modifiedRequest = request.clone({
      headers: header,
      url: environment.apiURL + request.url.startsWith('/') ? '' : `/${ request.url }`
    });

    return next.handle(modifiedRequest);
  }
}
