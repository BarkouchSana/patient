import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AppointmentsRoutingModule } from './appointments-routing.module';
import { AppointmentsComponent } from './appointments.component';
import { AppointmentListComponent } from './components/appointment-list/appointment-list.component';
import { AppointmentDetailComponent } from './components/appointment-detail/appointment-detail.component';
import { AppointmentCreateComponent } from './components/appointment-create/appointment-create.component';

import { FormsModule } from '@angular/forms';
@NgModule({
  declarations: [
    AppointmentsComponent,
    AppointmentListComponent,
    AppointmentDetailComponent,
    AppointmentCreateComponent
  ],
  imports: [
    CommonModule,
    AppointmentsRoutingModule,
    FormsModule
  ]
})
export class AppointmentsModule { 


  
}
