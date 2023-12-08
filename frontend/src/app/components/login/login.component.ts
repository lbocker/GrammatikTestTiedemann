import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import {PRIMENG_BARREL} from "../../barrel/primeng.barrel";

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, PRIMENG_BARREL],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.less']
})
export class LoginComponent {
}
