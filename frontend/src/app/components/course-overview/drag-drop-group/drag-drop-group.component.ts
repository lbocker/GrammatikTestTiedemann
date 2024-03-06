import { Component, Input, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DragDropGroup, Task } from '../../../models/task.model';
import { PRIMENG_BARREL } from '../../../barrel/primeng.barrel';
import { DialogService } from 'primeng/dynamicdialog';
import { DragGroupModalComponent } from './drag-group-modal/drag-group-modal.component';

@Component({
  selector: 'app-drag-drop-group',
  standalone: true,
  imports: [CommonModule, PRIMENG_BARREL],
  templateUrl: './drag-drop-group.component.html',
  styleUrls: ['./drag-drop-group.component.less']
})
export class DragDropGroupComponent implements OnInit {
  @Input() _task!: DragDropGroup;
  protected editedTask?: DragDropGroup;
  protected undraggedItems: string[] = [];
  private draggingItem: { index: number; text: string; origin: number | 'undragged' } | null = null;

  constructor(private readonly dialogService: DialogService) {
  }

  @Input() set task(task: Task) {
    if (!this.isDragDropGroun(task)) {
      console.error('Type has to be type DragDropGroup');
      return;
    }
    this._task = task;
  }

  get task(): DragDropGroup {
    return this._task;
  }

  ngOnInit(): void {
    if (!this.isDragDropGroun(this.task)) {
      console.error('Type has to be type DragDropGroup');
      return;
    }
    this.editedTask = this.task;
    for (const group of (this.editedTask as DragDropGroup).group) {
      this.undraggedItems.push(...group.items);
      group.items = []
    }

    this.undraggedItems = this.shuffle(this.undraggedItems)
  }

  trackByGroup(index: number, group: any): string {
    return group.text;
  }

  trackByItem(index: number, item: any): string {
    return item;
  }

  isDragDropGroun(task: Task): task is DragDropGroup {
    if (!task) {
      throw new Error('task undefined');
    }
    return task.type === 'DragDropGroup';
  }

  drop(groupIndex: number): void {
    if (this.draggingItem && this.editedTask) {
      this.editedTask.group[groupIndex].items.push(this.draggingItem!.text)
      if (this.draggingItem.origin == 'undragged') {
        this.undraggedItems.splice(this.draggingItem!.index, 1);
      } else {
        this.editedTask.group[this.draggingItem.origin].items.splice(this.draggingItem!.index, 1);
      }
      this.draggingItem = null;
    }
  }

  shuffle(array: string[]): string[] {
    return array.sort(() => Math.random() - 0.5);
  }

  dragStart(item: string, index: number, origin: number | 'undragged'): void {
    this.draggingItem = {text: item, index: index, origin: origin};
  }

  dragEnd(): void {
    this.draggingItem = null;
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

  }

  check(): void {
    if (this.undraggedItems.length > 0 || !this.editedTask) {
      return
    }

    let successful: boolean = true;
    const taskGroups = (this.task as DragDropGroup).group
    for (const groupIndex in taskGroups) {
      for (const groupItem of taskGroups[groupIndex].items) {
        if (!this.editedTask.group[groupIndex].items.includes(groupItem)) {
          successful = false;
        }
      }
    }
    this.showModal(successful)
  }
}
