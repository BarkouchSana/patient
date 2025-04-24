import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { BillsRoutingModule } from './bills-routing.module';
import { BillsComponent } from './bills.component';
import { BillListComponent } from './components/bill-list/bill-list.component';
import { BillDetailComponent } from './components/bill-detail/bill-detail.component';


@NgModule({
  declarations: [
    BillsComponent,
    BillListComponent,
    BillDetailComponent
  ],
  imports: [
    CommonModule,
    BillsRoutingModule
  ]
})
export class BillsModule { }
