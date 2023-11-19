import {Component, OnInit} from '@angular/core';
import { CommonModule } from '@angular/common';
import {CourseGroup, DragDropGroup, GrammarCourses, Task} from "../../models/grammar-courses";
import {CourseServiceService} from "../../services/course/course-service.service";
import {ActivatedRoute} from "@angular/router";
import {switchMap} from "rxjs";
import {PanelModule} from "primeng/panel";
import {PRIMENG_BARREL} from "../../barrel/primeng.barrel";
import {MenuItem} from "primeng/api";
import {MultipleChoiceComponent} from "./multiple-choice/multiple-choice.component";
import {DragDropGroupComponent} from "./drag-drop-group/drag-drop-group.component";
import {DragDropWordsComponent} from "./drag-drop-words/drag-drop-words.component";
import {TypeMissingWordsComponent} from "./type-missing-words/type-missing-words.component";
import {FindWrongWordsComponent} from "./find-wrong-words/find-wrong-words.component";

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

  constructor(
    private route: ActivatedRoute,
    private readonly courseService: CourseServiceService
  ) {
  }

  ngOnInit(): void {
    this.route.params.pipe(switchMap((params: any) => {
      return this.courseService.getCourse(params.id)
    })).subscribe(courses => {
      this.course = courses;
      this.tasks = [{
        label: 'Beschreibung'
      }]
      for (let task of this.course?.children ?? []) {
        this.tasks.push({
          label: task.name
        })
      }
    })
  }

  indexChange(event: number): void {
    this.activeIndex = event;
    if (this.activeIndex == 0) {
      this.activeTask = undefined
      return;
    }
    this.activeTask = this.course!.children[this.activeIndex-1]
  }

  typeOf(activeTask: Task, type: string): DragDropGroup | Task {
    switch(type) {
      case 'DragDropGroup':
        return activeTask as DragDropGroup
    }
    return activeTask;
  }
}
