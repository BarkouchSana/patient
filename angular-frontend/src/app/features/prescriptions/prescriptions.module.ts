import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { PrescriptionsRoutingModule } from './prescriptions-routing.module';
import { PrescriptionsComponent } from './prescriptions.component';
import { PrescriptionListComponent } from './components/prescription-list/prescription-list.component';
import { PrescriptionDetailComponent } from './components/prescription-detail/prescription-detail.component';


@NgModule({
  declarations: [
    PrescriptionsComponent,
    PrescriptionListComponent,
    PrescriptionDetailComponent
  ],
  imports: [
    CommonModule,
    PrescriptionsRoutingModule
  ]
})
export class PrescriptionsModule { }
