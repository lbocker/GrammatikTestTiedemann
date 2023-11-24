import { ApplicationConfig } from '@angular/core';
import { provideRouter } from '@angular/router';

import { routes } from './app.routes';
import { provideAnimations } from '@angular/platform-browser/animations';
import {MessageService} from 'primeng/api';
import {
  HTTP_INTERCEPTORS,
  provideHttpClient, withInterceptorsFromDi
} from '@angular/common/http';
import { URLInterceptor } from './interceptor/url.interceptor';
import {DialogService} from 'primeng/dynamicdialog';


export const appConfig: ApplicationConfig = {
  providers: [
    provideRouter(routes),
    provideAnimations(),
    MessageService,
    DialogService,
    provideHttpClient(
      withInterceptorsFromDi()
    ),
    {
      provide: HTTP_INTERCEPTORS,
      useClass: URLInterceptor,
      multi: true,
    },
  ]
};
