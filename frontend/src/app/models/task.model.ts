export interface TaskDefault {
  name: string;
  title?: string;
  status: 'Fertig' | 'In Bearbeitung' | 'Offen';
  points: number;
}

export interface MultipleChoice extends TaskDefault {
  type: 'MULTIPLE_CHOICE';
  question: string;
  rightAnswer: string[] | string;
  wrongAnswer: string[] | string;
}

export interface DragDropGroup extends TaskDefault {
  type: 'DRAG_AND_DROP_GROUP';
  group: {
    text: string;
    items: string[];
  }[]
}

export interface Description {
  title: string;
  description: string;
}

export interface DragDropWords extends TaskDefault {
  type: 'DRAG_AND_DROP_WORDS';
  question: string;
  fillTexts: string[];
}

export interface TypeMissingWords extends TaskDefault {
  type: 'TYPE_MISSING_WORDS';
  text: string;
  fillWords: string[];
}

export interface FindWrongWords extends TaskDefault {
  type: 'FIND_WRONG_WORDS';
  text: string;
  wordIndex: number[]
}

export interface BigTask {
  title: string;
  description: string;
  quizzes: Task[];
}

export type Task = MultipleChoice | DragDropGroup | DragDropWords | TypeMissingWords | FindWrongWords;
