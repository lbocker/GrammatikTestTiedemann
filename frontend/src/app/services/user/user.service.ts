import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, tap } from 'rxjs';
import { setCookie } from 'typescript-cookie'
import { CookieAttributes } from 'typescript-cookie/dist/types';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  public stayLoggedIn = false;

  constructor(private readonly http: HttpClient) { }

  register(email: string, password: string): Observable<any> {
    return this.http.post('/register', {
      email: email,
      password: password
    })
  }

  login(username: string, password: string): Observable<any> {
    return this.http.post('/login_check', {
      username: username,
      password: password
    }).pipe(tap((response: any) => {
      this.saveToken(response.token)
    }));
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
