import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PRIMENG_BARREL } from '../../barrel/primeng.barrel';
import { RippleModule } from 'primeng/ripple';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { UserService } from '../../services/user/user.service';
import { Router } from '@angular/router';
import { MessageService } from 'primeng/api';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [
    CommonModule,
    PRIMENG_BARREL,
    RippleModule,
    ReactiveFormsModule
  ],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.less']
})
export class LoginComponent {
  protected form!: FormGroup;
  protected loading = false;

  constructor(
    private readonly userService: UserService,
    private readonly formBuilder: FormBuilder,
    private readonly router: Router,
    private readonly messageService: MessageService
  ) {
    this.form = this.formBuilder.group({
      email: ['', Validators.required],
      password: ['', Validators.required],
      stayLoggedIn: [false]
    });
  }

  login(): void {
    this.loading = true;
    this.userService.stayLoggedIn = this.form.value.stayLoggedIn;
    this.userService.login(
      this.form.value.email,
      this.form.value.password
    ).subscribe({
      next: () => this.router.navigate(['/']),
      error: () => {
        this.messageService.add({ severity: 'error', summary: 'Login failed' });
        this.loading = false
      }
    });
  }
}
