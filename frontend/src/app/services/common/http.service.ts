import { Injectable } from '@angular/core';
import { map, Observable, of, timer } from 'rxjs';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class HttpService {
  private headers = new HttpHeaders();

  constructor(private readonly httpClient: HttpClient) {
    this.headers = this.headers.append('Access-Control-Allow-Origin', location.origin);
    this.headers = this.headers.append('Access-Control-Allow-Methods', 'DELETE, POST, GET, OPTIONS');
    this.headers = this.headers.append('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
  }

  get(url: string, headers=true, ...args: any[]): Observable<any> {
    return this.httpClient.get(
      environment.apiURL + (url.startsWith('/') ? '' : '/') + url,
      { headers: this.headers, ...args}
    )
  }

  post(url: string, body: any, headers=true, ...args: any[]): Observable<any> {
    return this.httpClient.post(
      environment.apiURL + (url.startsWith('/') ? '' : '/') + url,
      body,
      { headers: this.headers, ...args}
    )
  }

  put(url: string, body: any, headers=true, ...args: any[]): Observable<any> {
    return this.httpClient.put(
      environment.apiURL + (url.startsWith('/') ? '' : '/') + url,
      body,
      { headers: this.headers, ...args}
    )
  }

  delete(url: string, headers=true, ...args: any[]): Observable<any> {
    return this.httpClient.delete(
      environment.apiURL + (url.startsWith('/') ? '' : '/') + url,
      { headers: this.headers, ...args}
    )
  }
}
