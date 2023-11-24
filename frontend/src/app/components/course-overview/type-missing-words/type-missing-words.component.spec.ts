import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TypeMissingWordsComponent } from './type-missing-words.component';

describe('TypeMissingWordsComponent', () => {
  let component: TypeMissingWordsComponent;
  let fixture: ComponentFixture<TypeMissingWordsComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [TypeMissingWordsComponent]
    });
    fixture = TestBed.createComponent(TypeMissingWordsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
