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

    if (!request.url.includes('register') && !request.url.includes('login_check')) {
      //header = header.set('token', this.getToken());
    }
    header = header.append('Access-Control-Allow-Origin', '*');
    header = header.append('Access-Control-Allow-Methods', 'DELETE, POST, GET, OPTIONS');
    header = header.append('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    console.log(request.headers.keys());

    console.log(environment.apiURL, request.url);


    return next.handle(request);
  }

  private getToken(): string {
    return `bearer ${  Cookies.get('token') ?? ''}`;
  }
}
