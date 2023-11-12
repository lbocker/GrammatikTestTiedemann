import { Injectable } from '@angular/core';
import {CourseGroup} from "../../models/grammar-courses";
import {map, Observable, timer} from "rxjs";


@Injectable({
  providedIn: 'root'
})
export class CourseServiceService {

  constructor() { }

  getCourseGroups(): Observable<CourseGroup[]> {
    return timer(5000).pipe(map(() => [
      {
        name: 'Komma Setzung',
        children: [
          {name: 'Klasse 1', image: '', assignment: '', id: 0, availableUnits: 13, status: 'Offen', description: 'Bla'},
          {name: 'Klasse 2', image: '', assignment: '', id: 2, availableUnits: 13, status: 'Offen', description: 'Bla'},
          {name: 'Klasse 3', image: '', assignment: '', id: 3, availableUnits: 13, status: 'Offen', description: 'Bla'}
        ]
      },
      {
        name: 'Rechtschreibung',
        children: [
          {name: 'Klasse 1', image: '', assignment: '', id: 0, availableUnits: 13, status: 'Offen', description: 'Bla'},
          {name: 'Klasse 2', image: '', assignment: '', id: 2, availableUnits: 13, status: 'Offen', description: 'Bla'},
          {name: 'Klasse 3', image: '', assignment: '', id: 3, availableUnits: 13, status: 'Offen', description: 'Bla'}
        ]
      },
      {
        name: 'Sprachliche mittel',
        children: [
          {name: 'Personifikation', image: '', assignment: '', id: 0, availableUnits: 13, status: 'Offen', description: 'Bla'},
          {name: 'metapher', image: '', assignment: '', id: 2, availableUnits: 13, status: 'Offen', description: 'Bla'},
          {name: 'Anglizismus', image: '', assignment: '', id: 3, availableUnits: 13, status: 'Offen', description: 'Bla'}
        ]
      },
    ]))
  }
}
