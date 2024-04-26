import { Component, EventEmitter, Input, Output } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MultipleChoice, Task } from '../../../models/task.model';
import { PRIMENG_BARREL } from '../../../barrel/primeng.barrel';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { DragGroupModalComponent } from '../drag-drop-group/drag-group-modal/drag-group-modal.component';
import { DialogService } from 'primeng/dynamicdialog';
import { UserService } from '../../../services/user/user.service';
import { MultipleChoiceModalComponent } from './multiple-choice-modal/multiple-choice-modal.component';

@Component({
  selector: 'app-multiple-choice',
  standalone: true,
  imports: [CommonModule, PRIMENG_BARREL, ReactiveFormsModule],
  templateUrl: './multiple-choice.component.html',
  styleUrls: ['./multiple-choice.component.less']
})
export class MultipleChoiceComponent {
  @Output() taskCompleted = new EventEmitter<void>();

  protected _task!: MultipleChoice;
  protected choices!: string[];
  protected form!: FormGroup;

  constructor(
    private readonly formBuilder: FormBuilder,
    private readonly dialogService: DialogService,
    private readonly userService: UserService
  ) {
  }

  trackByChoice(index: number, choice: string): string {
    return choice;
  }

  @Input() set task(task: Task) {
    if (!this.isMultipleChoice(task)) {
      console.error('Type has to be type MultipleChoice');
      return;
    }
    this._task = task;
    if (typeof this._task.rightAnswer === 'string') {
      this._task.rightAnswer = this._task.rightAnswer.split(',');
    }
    if (typeof this._task.wrongAnswer === 'string') {
      this._task.wrongAnswer = this._task.wrongAnswer.split(',');
    }

    this.choices = this.shuffle([...this._task.rightAnswer, ...this._task.wrongAnswer]);

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
    return task.type === 'MULTIPLE_CHOICE';
  }

  showModal(successful: boolean): void {
    const ref = this.dialogService.open(MultipleChoiceModalComponent, {
      header: successful ? 'Gut gemacht!' : 'Leider Falsch',
      data: {
        successful: successful,
        points: this._task.points
      },
      width: '70%',
      contentStyle: {overflow: 'auto'},
      baseZIndex: 10000,
      maximizable: false
    });

    if (successful) {
      ref.onClose.subscribe(() => {
        this.userService.increasePoints(this._task.points).subscribe();
        this.taskCompleted.emit();
      });
    }
  }

  check(): void {
    let correct = true;
    const checkedAnswers: string[] = Object.entries(this.form.getRawValue())
      .filter(([_, value]) => value)
      .map(([key, _]) => this.choices[ parseInt(key.replace('choice-', '')) ] );

    if (checkedAnswers.length !== this._task.rightAnswer.length) {
      correct = false;
    } else {
      for (const right of this._task.rightAnswer) {
        if (!checkedAnswers.includes(right)) {
          correct = false;
          break;
        }
      }
    }

    this.showModal(correct)
  }
}
