import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DynamicDialogConfig, DynamicDialogRef } from 'primeng/dynamicdialog';

@Component({
  selector: 'app-multiple-choice-modal',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './multiple-choice-modal.component.html',
  styleUrls: ['./multiple-choice-modal.component.less']
})
export class MultipleChoiceModalComponent implements OnInit {
  protected successful?: boolean;

  constructor(private readonly ref: DynamicDialogRef, private readonly config: DynamicDialogConfig) {}

  ngOnInit(): void {
    this.successful = this.config.data.successful
  }
}
