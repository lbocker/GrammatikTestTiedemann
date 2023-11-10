export interface Course {
  id: number;
  name: string;
  assignment: string;
  image: string;
  availableUnits: number;
  description: string;
  status: 'Fertig' | 'In Bearbeitung' | 'Offen';
}

export interface User {
  name: string;
  password: string;
  image?: string;
  score: number;
}

interface taskDefault {
  name: string;
  status: 'Fertig' | 'In Bearbeitung' | 'Offen';
}

export interface MultipleChoice extends taskDefault {
  type: 'MultipleChoice';
  right: string[];
  wrong: string[];
}

export interface DragDropGroup extends taskDefault {
  type: 'DragDropGroup';
  group: {
    text: string;
    items: string[];
  }[]
}

export interface DragDropWords extends taskDefault {
  type: 'DragDropWords';
  text: string;
  fillTexts: string[];
}

export interface TypeMissingWords extends taskDefault {
  type: 'TypeMissingWords';
  text: string;
  fillWords: string[];
}

export interface FindWrongWords extends taskDefault {
  type: 'FindWrongWords';
  text: string;
  wordIndex: number[]
}

export type Task = MultipleChoice | DragDropGroup | DragDropWords | TypeMissingWords | FindWrongWords;

export interface CourseGroup {
  id: number;
  title: string;
  description: string;
  category: string;
  options: Task[]
}
