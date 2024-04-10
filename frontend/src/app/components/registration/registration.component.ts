import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PRIMENG_BARREL } from '../../barrel/primeng.barrel';
import { UserService } from '../../services/user/user.service';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { MessageService } from 'primeng/api';
import { switchMap } from 'rxjs';
import { Router } from '@angular/router';
import { InputGroupAddonModule } from "primeng/inputgroupaddon";
import { InputGroupModule } from "primeng/inputgroup";
import { RippleModule } from "primeng/ripple";

@Component({
  selector: 'app-registration',
  standalone: true,
  imports: [
    CommonModule,
    PRIMENG_BARREL,
    ReactiveFormsModule,
    InputGroupAddonModule,
    InputGroupModule,
    RippleModule
  ],
  templateUrl: './registration.component.html',
  styleUrls: ['./registration.component.less']
})
export class RegistrationComponent implements OnInit {
  protected form!: FormGroup;
  protected loading = false;
  protected fieldTextType = false;
  protected mobileWindow = false;

  constructor(
    private readonly userService: UserService,
    private readonly formBuilder: FormBuilder,
    private readonly messageService: MessageService,
    private readonly router: Router
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

  register(): void {
    this.loading = true;
    this.userService.stayLoggedIn = this.form.value.stayLoggedIn;

    this.userService.register(
      this.form.value.email,
      this.form.value.password
    ).pipe(
      switchMap(() => this.userService.login(this.form.value.email, this.form.value.password))
    ).subscribe({
      next: () => {
        this.messageService.add({ severity: 'success', summary: 'User registered' });
        this.router.navigate(['/']);
      },
      error: () => {
        this.messageService.add({ severity: 'error', summary: 'Registration failed' });
        this.loading = false;
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
