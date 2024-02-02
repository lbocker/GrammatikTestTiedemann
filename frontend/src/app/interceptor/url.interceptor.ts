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
import { Cookies } from 'typescript-cookie';

@Injectable()
export class URLInterceptor implements HttpInterceptor {

  constructor(private readonly service: CourseServiceService) {
  }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    let header: HttpHeaders = request.headers;

    if (!request.url.includes('register')) {
      header = header.set('token', this.getToken());
    }

    console.log(environment.apiURL, request.url);

    const modifiedRequest = request.clone({
      headers: header,
      url: environment.apiURL + (request.url.startsWith('/') ? '' : '/') + request.url
    });

    return next.handle(modifiedRequest);
  }

  private getToken(): string {
    return `bearer ${  Cookies.get('token') ?? ''}`;
  }
}
