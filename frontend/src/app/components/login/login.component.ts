import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PRIMENG_BARREL } from '../../barrel/primeng.barrel';
import { RippleModule } from 'primeng/ripple';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { UserService } from '../../services/user/user.service';
import { Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { InputGroupAddonModule } from 'primeng/inputgroupaddon';
import { InputGroupModule } from 'primeng/inputgroup';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [
    CommonModule,
    PRIMENG_BARREL,
    RippleModule,
    ReactiveFormsModule,
    InputGroupAddonModule,
    InputGroupModule
  ],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.less']
})
export class LoginComponent implements OnInit {
  protected form!: FormGroup;
  protected loading = false;
  protected fieldTextType = false;
  protected mobileWindow = false;

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

  ngOnInit(): void {
    if (window.screen.width <= 950) {
      this.mobileWindow = true;
    }
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
  toggleFieldTextType(): void {
    this.fieldTextType = !this.fieldTextType;
  }

  setFocus(element: string): void {
    document.getElementById(element)?.focus();
  }
}
