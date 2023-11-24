import {Component, Input, OnInit} from '@angular/core';
import { CommonModule } from '@angular/common';
import {DragDropGroup, Task} from "../../../models/grammar-courses";
import {PRIMENG_BARREL} from "../../../barrel/primeng.barrel";
import {DialogService} from "primeng/dynamicdialog";
import {DragGroupModalComponent} from "./drag-group-modal/drag-group-modal.component";

@Component({
  selector: 'app-drag-drop-group',
  standalone: true,
  imports: [CommonModule, PRIMENG_BARREL],
  templateUrl: './drag-drop-group.component.html',
  styleUrls: ['./drag-drop-group.component.less']
})
export class DragDropGroupComponent implements OnInit{
  @Input() task!: Task;
  protected editedTask?: DragDropGroup;
  protected undraggedItems: string[] = [];
  private dragingItem: {index: number; text: string; origin: number | 'undragged'} | null = null;

  constructor(private dialogService: DialogService) {
  }

  ngOnInit() {
    if (this.task.type !== 'DragDropGroup') {
      console.error('Type has to be type DragDropGroup')
    }
    this.editedTask = JSON.parse(JSON.stringify(this.task)) as DragDropGroup;
    for (let group of (this.editedTask as DragDropGroup).group) {
      this.undraggedItems.push(...group.items)
      group.items = []
    }

    this.undraggedItems = this.shuffle(this.undraggedItems)
  }

  drop(groupIndex: number) {
    if (this.dragingItem && this.editedTask) {
      this.editedTask.group[groupIndex].items.push(this.dragingItem!.text)
      if (this.dragingItem.origin == 'undragged') {
        this.undraggedItems.splice(this.dragingItem!.index, 1);
      } else {
        this.editedTask.group[this.dragingItem.origin].items.splice(this.dragingItem!.index, 1);
      }
      this.dragingItem = null;
    }
  }

  shuffle (array: string[])  {
    return array.sort(() => Math.random() - 0.5);
  };

  dragStart(item: string, index: number, origin: number|'undragged') {
    this.dragingItem = {text: item, index: index, origin: origin};
  }

  dragEnd() {
    this.dragingItem = null;
  }

  showModal(successful: boolean): void {
    const ref = this.dialogService.open(DragGroupModalComponent, {
      header: successful?'Gut gemacht!':'Leider Falsch',
      data: {
        successful: successful
      },
      width: '70%',
      contentStyle: { overflow: 'auto' },
      baseZIndex: 10000,
      maximizable: false
    });

    ref.onClose.subscribe(() => {
      console.log('Closed')
    });
  }

  check() {
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
