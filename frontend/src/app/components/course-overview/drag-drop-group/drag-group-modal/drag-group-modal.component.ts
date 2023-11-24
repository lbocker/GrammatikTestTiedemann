import {Component, OnInit} from '@angular/core';
import { CommonModule } from '@angular/common';
import {DynamicDialogConfig, DynamicDialogRef} from 'primeng/dynamicdialog';

@Component({
  selector: 'app-drag-group-modal',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './drag-group-modal.component.html',
  styleUrls: ['./drag-group-modal.component.less']
})
export class DragGroupModalComponent implements OnInit{
  protected successful?: boolean;

  constructor(private readonly ref: DynamicDialogRef, private readonly config: DynamicDialogConfig) {}

  ngOnInit(): void {
    this.successful = this.config.data.successful
  }
}
