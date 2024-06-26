import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { CourseGroup } from '../../models/course-group.model';
import { BigTask, Description, DragDropGroup, Task } from '../../models/task.model';
import { CourseServiceService } from '../../services/course/course-service.service';
import { ActivatedRoute } from '@angular/router';
import { switchMap } from 'rxjs';
import { PRIMENG_BARREL } from '../../barrel/primeng.barrel';
import { MenuItem } from 'primeng/api';
import { MultipleChoiceComponent } from './multiple-choice/multiple-choice.component';
import { DragDropGroupComponent } from './drag-drop-group/drag-drop-group.component';
import { DragDropWordsComponent } from './drag-drop-words/drag-drop-words.component';
import { TypeMissingWordsComponent } from './type-missing-words/type-missing-words.component';
import { FindWrongWordsComponent } from './find-wrong-words/find-wrong-words.component';

@Component({
  selector: 'app-course-overview',
  standalone: true,
  imports: [CommonModule, PRIMENG_BARREL, MultipleChoiceComponent, DragDropGroupComponent, DragDropWordsComponent, TypeMissingWordsComponent, FindWrongWordsComponent],
  templateUrl: './course-overview.component.html',
  styleUrls: ['./course-overview.component.less']
})
export class CourseOverviewComponent implements OnInit {
  description?: Description;
  tasksMenu: MenuItem[] = [];
  activeIndex: number = 0;
  activeTask?: Task;
  bigTask?: BigTask;
  tasks!: Task[];


  constructor(
    private readonly route: ActivatedRoute,
    private readonly courseService: CourseServiceService
  ) {
  }

  ngOnInit(): void {
    this.route.params.pipe(
      switchMap((params: any) => this.courseService.getCourse(params.courseId)),
      switchMap((course: any) => {
        this.description = course;

        return this.courseService.getQuizSet(course.id)
      })
    ).subscribe(quizSet => {
      this.tasks = quizSet;

      console.log(quizSet);
      let index = 0;
      this.tasksMenu = [{
        label: 'Beschreibung'
      }];

      for (const task of quizSet) {
        index++;
        this.tasksMenu.push({
          label: `Aufgabe ${index}`
        });
      }
    })
  }



  indexChange(event: number): void {
    this.activeIndex = event;
    if (this.activeIndex == 0) {
      this.activeTask = undefined;
      return;
    }

    this.activeTask = this.tasks[this.activeIndex];
  }

  taskCompleted() {
    this.indexChange(this.activeIndex + 1);
  }
}
