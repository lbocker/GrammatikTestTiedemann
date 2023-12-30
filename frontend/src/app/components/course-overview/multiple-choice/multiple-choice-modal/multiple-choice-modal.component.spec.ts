import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MultipleChoiceModalComponent } from './multiple-choice-modal.component';

describe('MultipleChoiceModalComponent', () => {
  let component: MultipleChoiceModalComponent;
  let fixture: ComponentFixture<MultipleChoiceModalComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [MultipleChoiceModalComponent]
    });
    fixture = TestBed.createComponent(MultipleChoiceModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
