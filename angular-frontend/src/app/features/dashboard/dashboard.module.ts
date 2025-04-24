import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { DashboardRoutingModule } from './dashboard-routing.module';
import { DashboardComponent } from './dashboard.component';
import { DashboardOverviewComponent } from './components/dashboard-overview/dashboard-overview.component';
import { AppointmentSummaryComponent } from './components/appointment-summary/appointment-summary.component';
import { LabResultsComponent } from './components/lab-results/lab-results.component';
import { RemindersComponent } from './components/reminders/reminders.component';
import { PrescriptionsComponent } from './components/prescriptions/prescriptions.component';


@NgModule({
  declarations: [
    DashboardComponent,
    DashboardOverviewComponent,
    AppointmentSummaryComponent,
    LabResultsComponent,
    RemindersComponent,
    PrescriptionsComponent
  ],
  imports: [
    CommonModule,
    DashboardRoutingModule
  ]
})
export class DashboardModule { }
