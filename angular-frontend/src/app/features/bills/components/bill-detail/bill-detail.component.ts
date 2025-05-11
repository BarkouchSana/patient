import { Component, Input, SimpleChanges } from '@angular/core';
import { Bill } from '../../../../core/domain/models/bill.model';
 
@Component({
  selector: 'app-bill-detail',
  standalone: false,
  templateUrl: './bill-detail.component.html',
  styleUrl: './bill-detail.component.css'
})
export class BillDetailComponent {
  @Input() bill: Bill | null = null;

  constructor() { }

  ngOnChanges(changes: SimpleChanges): void {
    if (changes['bill'] && changes['bill'].currentValue) {
      // Potentially handle changes, e.g., reset a form if bill changes
    }
  }
}
