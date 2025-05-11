import { Component, EventEmitter, Output } from '@angular/core';
import { Bill } from '../../../../core/domain/models/bill.model';
 

@Component({
  selector: 'app-bill-list',
  standalone: false,
  templateUrl: './bill-list.component.html',
  styleUrl: './bill-list.component.css'
})
export class BillListComponent {
  @Output() billSelected = new EventEmitter<Bill>();

  bills: Bill[] = [
    {
      id: '1',
      billId: 'B-001',
      issueDate: '2023-04-15',
      dueDate: '2023-05-15',
      amount: 85.50,
      status: 'Paid',
      notes: 'Regular consultation fee',
      isPaid: true
    },
    {
      id: '2',
      billId: 'B-002',
      issueDate: '2023-06-10',
      dueDate: '2023-07-10',
      amount: 120.00,
      status: 'Unpaid',
      notes: 'Lab tests and consultation',
      detailsActionText: 'Pay Now',
      isPaid: false
    },
    {
      id: '3',
      billId: 'B-003',
      issueDate: '2023-08-22',
      dueDate: '2023-09-22',
      amount: 45.75,
      status: 'Overdue',
      notes: 'Prescription medication',
      isPaid: false
    },
    {
      id: '4',
      billId: 'B-004',
      issueDate: '2023-10-05',
      dueDate: '2023-11-05',
      amount: 65.25,
      status: 'Pending',
      notes: 'Follow-up appointment',
      isPaid: false
    }
  ];

  selectedBillId: string | null = null;

  constructor() { }

  ngOnInit(): void { }

  selectBill(bill: Bill): void {
    this.selectedBillId = bill.id;
    this.billSelected.emit(bill);
  }
}
