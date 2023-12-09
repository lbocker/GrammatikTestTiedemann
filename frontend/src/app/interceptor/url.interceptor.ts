import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor, HttpHeaders
} from '@angular/common/http';
import { Observable } from 'rxjs';
import { Cookies } from 'typescript-cookie';
import { environment } from '../../environments/environment';

@Injectable()
export class URLInterceptor implements HttpInterceptor {

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    let header: HttpHeaders = request.headers;

    if (!request.url.includes('register')) {
      header = header.set('token', this.getToken());
    }

    const modifiedRequest = request.clone({
      headers: header,
      url: environment.apiURL + (request.url.startsWith('/') ? request.url : `/${request.url}`)
    });

    return next.handle(modifiedRequest);
  }

  private getToken(): string {
    return `bearer ${  Cookies.get('token') ?? ''}`;
  }
}
