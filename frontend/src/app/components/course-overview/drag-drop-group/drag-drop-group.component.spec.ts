import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DragDropGroupComponent } from './drag-drop-group.component';

describe('DragDropGroupComponent', () => {
  let component: DragDropGroupComponent;
  let fixture: ComponentFixture<DragDropGroupComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [DragDropGroupComponent]
    });
    fixture = TestBed.createComponent(DragDropGroupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
