export interface GrammarCourses {
  id: number;
  name: string;
  assignment: string;
  image: string;
  availableUnits: number;
  description: string;
  status: 'Fertig' | 'In Bearbeitung' | 'Offen';
}

export interface User {
  username: string;
  password: string;
  image: string;
}