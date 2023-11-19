import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CourseOverviewComponent } from './course-overview.component';

describe('CourseOverviewComponent', () => {
  let component: CourseOverviewComponent;
  let fixture: ComponentFixture<CourseOverviewComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [CourseOverviewComponent]
    });
    fixture = TestBed.createComponent(CourseOverviewComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
