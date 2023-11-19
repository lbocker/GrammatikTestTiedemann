import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DragDropWordsComponent } from './drag-drop-words.component';

describe('DragDropWordsComponent', () => {
  let component: DragDropWordsComponent;
  let fixture: ComponentFixture<DragDropWordsComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [DragDropWordsComponent]
    });
    fixture = TestBed.createComponent(DragDropWordsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
