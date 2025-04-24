import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { GuestAccessRoutingModule } from './guest-access-routing.module';
import { GuestAccessComponent } from './guest-access.component';


@NgModule({
  declarations: [
    GuestAccessComponent
  ],
  imports: [
    CommonModule,
    GuestAccessRoutingModule
  ]
})
export class GuestAccessModule { }
