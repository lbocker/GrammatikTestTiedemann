import { TestBed } from '@angular/core/testing';

import { URLInterceptor } from './url.interceptor';

describe('URLInterceptor', () => {
  beforeEach(() => TestBed.configureTestingModule({
    providers: [
      URLInterceptor
      ]
  }));

  it('should be created', () => {
    const interceptor: URLInterceptor = TestBed.inject(URLInterceptor);
    expect(interceptor).toBeTruthy();
  });
});
