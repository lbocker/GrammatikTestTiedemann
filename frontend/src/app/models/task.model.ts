export interface TaskDefault {
  name: string;
  status: 'Fertig' | 'In Bearbeitung' | 'Offen';
}

export interface MultipleChoice extends TaskDefault {
  type: 'MultipleChoice';
  right: string[];
  wrong: string[];
}

export interface DragDropGroup extends TaskDefault {
  type: 'DragDropGroup';
  group: {
    text: string;
    items: string[];
  }[]
}

export interface DragDropWords extends TaskDefault {
  type: 'DragDropWords';
  text: string;
  fillTexts: string[];
}

export interface TypeMissingWords extends TaskDefault {
  type: 'TypeMissingWords';
  text: string;
  fillWords: string[];
}

export interface FindWrongWords extends TaskDefault {
  type: 'FindWrongWords';
  text: string;
  wordIndex: number[]
}

export type Task = MultipleChoice | DragDropGroup | DragDropWords | TypeMissingWords | FindWrongWords;
