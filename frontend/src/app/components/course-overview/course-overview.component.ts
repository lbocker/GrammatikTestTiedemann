import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { CourseGroup } from '../../models/course-group.model';
import { BigTask, DragDropGroup, Task } from '../../models/task.model';
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
  course?: CourseGroup;
  tasks: MenuItem[] = [];
  activeIndex: number = 0;
  activeTask?: Task;
  bigTask?: BigTask;

  constructor(
    private readonly route: ActivatedRoute,
    private readonly courseService: CourseServiceService
  ) {
  }

  ngOnInit(): void {
    this.route.params.pipe(switchMap((params: any) => {
      return this.courseService.getCourse(params.courseId)
    })).subscribe(courses => {
      this.course = courses;
      this.tasks = [{
        label: 'Beschreibung'
      }];
      let index = 0;
      for (const task of this.course?.quizSets ?? []) {
        this.tasks.push({
          label: task.title
        });
        index ++;

        for (const subTask in task.quizzes) {
          this.tasks.push({
            label: `${index}.${Number(subTask)+1}`
          })
        }
      }
    })
  }



  indexChange(event: number): void {
    this.activeIndex = event;
    if (this.activeIndex == 0) {
      this.activeTask = undefined;
      return;
    }

    if (!isNaN(Number(this.tasks[this.activeIndex].label))) {
      let title = this.tasks[this.activeIndex].label!.split('.');
      let firstIndex = Number(title[0])-1;
      let lastIndex = Number(title[1])-1;

      this.bigTask = this.course!.quizSets[firstIndex];
      this.activeTask = this.bigTask.quizzes[Number(lastIndex)];
    } else {

      this.activeTask = undefined;

      // find BigTask

      let title = this.tasks[this.activeIndex+1].label!.split('.');
      let firstIndex = Number(title[0])-1;
      this.bigTask = this.course!.quizSets[firstIndex];
    }
  }
}
