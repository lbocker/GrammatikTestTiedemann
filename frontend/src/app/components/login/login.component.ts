import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PRIMENG_BARREL } from '../../barrel/primeng.barrel';
import { RippleModule } from 'primeng/ripple';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, PRIMENG_BARREL, RippleModule],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.less']
})
export class LoginComponent {
}
