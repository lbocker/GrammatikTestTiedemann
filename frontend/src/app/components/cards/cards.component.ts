import { Component } from '@angular/core';
import { CommonModule, NgOptimizedImage } from '@angular/common';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { GrammarCourses } from '../../models/grammar-courses';
import { Router } from '@angular/router';
import { RouterLink } from "@angular/router";

@Component({
  selector: 'app-card',
  standalone: true,
  imports: [CommonModule, MatButtonModule, MatCardModule, NgOptimizedImage, RouterLink],
  templateUrl: './cards.component.html',
  styleUrls: ['./cards.component.less']
})
export class CardComponent {
  grammarCourses: GrammarCourses[] = [
    {
      id: 0,
      name: 'Acme Fresh Start Housing',
      assignment: 'Chicago',
      image: 'https://blog.cengage.com/wp-content/uploads/2020/07/How-to-improve-grammar-1110x380.jpg',
      availableUnits: 4,
      description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mattis pretium massa. Aliquam erat volutpat. Nulla facilisi.',
      status: 'Fertig'
    },
    {
      id: 1,
      name: 'A113 Transitional Housing',
      assignment: 'Santa Monica',
      image: 'https://blog.cengage.com/wp-content/uploads/2020/07/How-to-improve-grammar-1110x380.jpg',
      availableUnits: 0,
      description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mattis pretium massa. Aliquam erat volutpat. Nulla facilisi.',
      status: 'Fertig'
    },
    {
      id: 2,
      name: 'Warm Beds Housing Support',
      assignment: 'Juneau',
      image: 'https://blog.cengage.com/wp-content/uploads/2020/07/How-to-improve-grammar-1110x380.jpg',
      availableUnits: 1,
      description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mattis pretium massa. Aliquam erat volutpat. Nulla facilisi.',
      status: 'Fertig'
    },
    {
      id: 3,
      name: 'Homesteady Housing',
      assignment: 'Chicago',
      image: 'https://blog.cengage.com/wp-content/uploads/2020/07/How-to-improve-grammar-1110x380.jpg',
      availableUnits: 1,
      description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mattis pretium massa. Aliquam erat volutpat. Nulla facilisi.',
      status: 'Fertig'
    },
    {
      id: 4,
      name: 'Happy Homes Group',
      assignment: 'Gary',
      image: 'https://blog.cengage.com/wp-content/uploads/2020/07/How-to-improve-grammar-1110x380.jpg',
      availableUnits: 1,
      description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mattis pretium massa. Aliquam erat volutpat. Nulla facilisi.',
      status: 'Fertig'
    },
    {
      id: 5,
      name: 'Hopeful Apartment Group',
      assignment: 'Oakland',
      image: 'https://blog.cengage.com/wp-content/uploads/2020/07/How-to-improve-grammar-1110x380.jpg',
      availableUnits: 2,
      description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mattis pretium massa. Aliquam erat volutpat. Nulla facilisi.',
      status: 'Fertig'
    },
    {
      id: 6,
      name: 'Seriously Safe Towns',
      assignment: 'Oakland',
      image: 'https://blog.cengage.com/wp-content/uploads/2020/07/How-to-improve-grammar-1110x380.jpg',
      availableUnits: 5,
      description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mattis pretium massa. Aliquam erat volutpat. Nulla facilisi.',
      status: 'Fertig'
    },
    {
      id: 7,
      name: 'Hopeful Housing Solutions',
      assignment: 'Oakland',
      image: 'https://blog.cengage.com/wp-content/uploads/2020/07/How-to-improve-grammar-1110x380.jpg',
      availableUnits: 2,
      description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mattis pretium massa. Aliquam erat volutpat. Nulla facilisi.',
      status: 'Fertig'
    },
    {
      id: 8,
      name: 'Seriously Safe Towns',
      assignment: 'Oakland',
      image: 'https://blog.cengage.com/wp-content/uploads/2020/07/How-to-improve-grammar-1110x380.jpg',
      availableUnits: 10,
      description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mattis pretium massa. Aliquam erat volutpat. Nulla facilisi.',
      status: 'Fertig'
    },
    {
      id: 9,
      name: 'Capital Safe Towns',
      assignment: 'Portland',
      image: 'https://blog.cengage.com/wp-content/uploads/2020/07/How-to-improve-grammar-1110x380.jpg',
      availableUnits: 6,
      description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mattis pretium massa. Aliquam erat volutpat. Nulla facilisi.',
      status: 'Fertig'
    }
  ];

  constructor(private readonly router: Router) {
  }

  openCourse(course: GrammarCourses): void {
    this.router.navigate([`course/${ course.id }/overview`])
  }
}
