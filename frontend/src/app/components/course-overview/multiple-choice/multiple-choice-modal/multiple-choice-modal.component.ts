import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DynamicDialogConfig, DynamicDialogRef } from 'primeng/dynamicdialog';
import { ButtonModule } from 'primeng/button';

@Component({
  selector: 'app-multiple-choice-modal',
  standalone: true,
  imports: [CommonModule, ButtonModule],
  templateUrl: './multiple-choice-modal.component.html',
  styleUrls: ['./multiple-choice-modal.component.less']
})
export class MultipleChoiceModalComponent implements OnInit {
  protected successful?: boolean;
  protected points?: number;
  private images = {
    successful: [
      'assets/images/Good/img.png',
      'assets/images/Good/img_1.png',
      'assets/images/Good/img_2.png',
      'assets/images/Good/img_3.png',
      'assets/images/Good/img_4.png',
    ],
    unsuccessful: [
      'assets/images/Bad/img.png',
      'assets/images/Bad/img_1.png',
      'assets/images/Bad/img_2.png',
      'assets/images/Bad/img_3.png',
      'assets/images/Bad/img_4.png',
      'assets/images/Bad/img_5.png',
      'assets/images/Bad/img_6.png',
      'assets/images/Bad/img_7.png',
      'assets/images/Bad/img_8.png',
    ]
  };
  protected image?: string;

  constructor(private readonly ref: DynamicDialogRef, private readonly config: DynamicDialogConfig) {}

  ngOnInit(): void {
    this.successful = this.config.data.successful;
    this.points = this.config.data.points;

    let tempImages = this.images[this.successful ? 'successful' : 'unsuccessful'];
    this.image = tempImages[Math.floor(Math.random() * tempImages.length)];
  }

  next() {
    this.ref.close();
  }
}
