import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FindWrongWordsComponent } from './find-wrong-words.component';

describe('FindWrongWordsComponent', () => {
  let component: FindWrongWordsComponent;
  let fixture: ComponentFixture<FindWrongWordsComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [FindWrongWordsComponent]
    });
    fixture = TestBed.createComponent(FindWrongWordsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
