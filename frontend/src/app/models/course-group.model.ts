import { BigTask, Task } from './task.model';

export interface CourseGroup {
  id: number;
  title: string;
  description: string;
  category: string;
  quizSets: BigTask[];
}
