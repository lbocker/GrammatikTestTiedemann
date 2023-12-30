import { Injectable } from '@angular/core';
import { CourseGroup } from '../../models/course-group.model';
import { Task } from '../../models/task.model';
import { User } from '../../models/user.model';
import { map, Observable, of, timer } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CourseServiceService {
  user?: User;
  private readonly tmpChildTasks: Task[] = [
    {
      name: 'Task 1',
      status: 'Offen',
      type: 'MultipleChoice',
      right: ['Test', 'Test2'],
      wrong: ['Test 3', 'Test 4']
    },
    {
      name: 'Task 2',
      status: 'In Bearbeitung',
      type: 'DragDropGroup',
      group: [{
        text: 'Option 1',
        items: ['Zu Opt1', 'Zu Opt1 2']
      }, {
        text: 'Option 2',
        items: ['Zu Opt2', 'Zu Opt2 2']
      },]
    },
    {
      name: 'Task 3',
      status: 'Fertig',
      type: 'DragDropWords',
      text: 'Lorem ipsum dolor sit %_%, consetetur sadipscing elitr, sed %_% nonumy eirmod tempor invidunt ut labore et dolore magna %_% erat, sed diam voluptua. At vero eos et %_% et justo duo dolores et ea',
      fillTexts: [
        'amet', 'diam', 'aliquyam', 'accusam'
      ]
    }
  ];
  private readonly group: CourseGroup[] = [
    {
      id: 0,
      title: 'Komma Setzung',
      description: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam',
      category: 'Grammatik',
      options: this.tmpChildTasks
    },
    {
      id: 1,
      title: 'Rechtschreibung',
      description: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam',
      category: 'Grammatik',
      options: this.tmpChildTasks
    },
    {
      id: 2,
      title: 'Sprachliche mittel',
      description: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam',
      category: 'Grammatik',
      options: this.tmpChildTasks
    },
  ]

  getCourseGroups(): Observable<CourseGroup[]> {
    return timer(5000).pipe(map(() => this.group))
  }

  getCourse(id: any): Observable<CourseGroup | undefined> {
    return of(this.group.find((value: CourseGroup) => value.id != id))
  }
}
