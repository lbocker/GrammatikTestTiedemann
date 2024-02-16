import { Component, Input, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DragDropWords, Task } from '../../../models/grammar-courses';
import { PRIMENG_BARREL } from '../../../barrel/primeng.barrel';

@Component({
  selector: 'app-drag-drop-words',
  standalone: true,
  imports: [CommonModule, PRIMENG_BARREL],
  templateUrl: './drag-drop-words.component.html',
  styleUrls: ['./drag-drop-words.component.less']
})
export class DragDropWordsComponent implements OnInit {
  @Input() _task!: DragDropWords;
  protected splittedWords: string[] = [];
  protected shuffledWords: string[] = [];

  protected draggingItem: {index: number; text: string; origin: number|'undragged'} | null = null;

  @Input() set task(task: Task) {
    if (!this.isDragDropWords(task)) {
      console.error('Type has to be type DragDropWords');
      return;
    }
    this._task = task;
  }

  ngOnInit(): void {
    this.splittedWords = this._task.text.split('%');
    this.shuffledWords = this.shuffle([...this._task.fillTexts]);
  }

  isDragDropWords(task: Task): task is DragDropWords {
    return task.type === 'DragDropWords';
  }

  shuffle (array: string[]): string[]  {
    return array.sort(() => Math.random() - 0.5);
  }

  startDrag(index: number, text: string, origin: number|'undragged'): void {
    this.draggingItem = {index: index, text: text, origin: origin};
  }

  dragEnd(): void {
    this.draggingItem = null;
  }

  drop(index: number): void {
    if (!this.draggingItem) {
      return
    }

    if (this.draggingItem.origin == 'undragged') {
      if (this.splittedWords[index].includes('WORD')) {
        this.splittedWords[index] = this.draggingItem.text;
        this.shuffledWords.splice(this.draggingItem.index, 1);
      } else {
        const item = this.splittedWords[index];
        this.splittedWords[index] = this.draggingItem.text;
        this.shuffledWords[this.draggingItem.index] = item;
      }
      return
    }

    const item = this.splittedWords[index];
    this.splittedWords[index] = this.draggingItem.text;
    this.splittedWords[this.draggingItem.origin] = item;
  }

  check(): void {
    let index = 0;
    let success = true;
    for (const item of this._task.text.split('%')) {
      if (index%2 != 0) {
        const shouldIndex = item.replace('WORD:', '');
        const shouldItem = this._task.fillTexts[parseInt(shouldIndex)];

        const isItem = this.splittedWords[index];
        if (isItem != shouldItem) {
          success = false;
        }
      }

      index++;
    }

    if (success) {
      console.log('YAY')
    } else {
      console.log('Nope')
    }
  }
}
