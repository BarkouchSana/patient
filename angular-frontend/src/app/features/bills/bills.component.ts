import { Component } from '@angular/core';
import { Bill } from '../../core/domain/models/bill.model';
 
@Component({
  selector: 'app-bills',
  standalone: false,
  templateUrl: './bills.component.html',
  styleUrl: './bills.component.css'
})
export class BillsComponent {
  selectedBill: Bill | null = null;

  onBillSelected(bill: Bill): void {
    this.selectedBill = bill;
  }
}
