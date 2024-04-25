import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of, tap } from 'rxjs';
import { getCookie, setCookie } from 'typescript-cookie'
import { CookieAttributes } from 'typescript-cookie/dist/types';
import { HttpService } from '../common/http.service';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  public stayLoggedIn = false;

  constructor(private readonly http: HttpService, private readonly router: Router) { }

  register(email: string, password: string): Observable<any> {
    return this.http.post('/api/register', {
      email: email,
      password: password
    })
  }

  login(username: string, password: string): Observable<any> {
    return this.http.post('/api/login_check', {
      username: username,
      password: password
    }).pipe(tap((response: any) => {
      this.saveToken(response.token);
      this.saveEmail(username);
    }));
  }

  increasePoints(points: number): Observable<boolean> {
    let email = this.getEmail();

    if (!email) {
      return of(false);
    }

    return this.http.post('/api/user/points', {
      points: points,
    }, true, {
      email: email
    })
  }

  private getEmail(): string | null {
    let cookie = getCookie('email');
    if (cookie) {
      return cookie;
    }
    this.router.navigate(['/login']);
    return null
  }

  private saveEmail(email: string): void {
    const cookieAttributes: CookieAttributes = {
      secure: true,
    };
    if (this.stayLoggedIn) {
      cookieAttributes.expires = 0.5; // 12 hours
    }

    setCookie('email', email, cookieAttributes)
  }
  private saveToken(token: string): void {
    const cookieAttributes: CookieAttributes = {
      secure: true,
    };
    if (this.stayLoggedIn) {
      cookieAttributes.expires = 0.5; // 12 hours
    }

    setCookie('token', token, cookieAttributes)
  }
}
