import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MultipleChoice, Task } from '../../../models/grammar-courses';
import { PRIMENG_BARREL } from '../../../barrel/primeng.barrel';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { DragGroupModalComponent } from '../drag-drop-group/drag-group-modal/drag-group-modal.component';
import { DialogService } from 'primeng/dynamicdialog';

@Component({
  selector: 'app-multiple-choice',
  standalone: true,
  imports: [CommonModule, PRIMENG_BARREL, ReactiveFormsModule],
  templateUrl: './multiple-choice.component.html',
  styleUrls: ['./multiple-choice.component.less']
})
export class MultipleChoiceComponent {
  protected _task!: MultipleChoice;
  protected choices!: string[];
  protected form!: FormGroup;

  constructor(
    private readonly formBuilder: FormBuilder,
    private readonly dialogService: DialogService
  ) {
  }

  @Input() set task(task: Task) {
    if (!this.isMultipleChoice(task)) {
      console.error('Type has to be type MultipleChoice');
      return;
    }
    this._task = task;

    this.choices = this.shuffle([...this._task.right, ...this._task.wrong]);

    this.form = this.formBuilder.group({});
    for (const choice in this.choices) {
      const control = this.formBuilder.control(false);
      this.form.addControl(`choice-${choice}`, control);
    }
  }

  shuffle (array: string[]): string[]  {
    return array.sort(() => Math.random() - 0.5);
  }

  isMultipleChoice(task: Task): task is MultipleChoice {
    if (!task) {
      throw new Error('task undefined');
    }
    return task.type === 'MultipleChoice';
  }

  showModal(successful: boolean): void {
    const ref = this.dialogService.open(DragGroupModalComponent, {
      header: successful ? 'Gut gemacht!' : 'Leider Falsch',
      data: {
        successful: successful
      },
      width: '70%',
      contentStyle: {overflow: 'auto'},
      baseZIndex: 10000,
      maximizable: false
    });

    ref.onClose.subscribe(() => {
      console.log('Closed')
    });
  }

  check(): void {
    let correct = true;
    const checkedAnswers: string[] = Object.entries(this.form.getRawValue())
      .filter(([_, value]) => value)
      .map(([key, _]) => this.choices[ parseInt(key.replace('choice-', '')) ] );

    if (checkedAnswers.length !== this._task.right.length) {
      correct = false;
    } else {
      for (const right of this._task.right) {
        if (!checkedAnswers.includes(right)) {
          correct = false;
          break;
        }
      }
    }

    console.log(correct, checkedAnswers, this._task.right);
    this.showModal(correct)
  }
}
