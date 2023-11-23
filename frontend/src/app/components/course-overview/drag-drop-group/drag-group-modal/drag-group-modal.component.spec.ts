import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DragGroupModalComponent } from './drag-group-modal.component';

describe('DragGroupModalComponent', () => {
  let component: DragGroupModalComponent;
  let fixture: ComponentFixture<DragGroupModalComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [DragGroupModalComponent]
    });
    fixture = TestBed.createComponent(DragGroupModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
