import { Component, Input } from '@angular/core';
import { Bill } from '../../../../core/domain/models/bill.model';

@Component({
  selector: 'app-bill-detail',
  templateUrl: './bill-detail.component.html',
  standalone: false,
  styleUrls: ['./bill-detail.component.css']
})
export class BillDetailComponent {
  @Input() bill: Bill | undefined = undefined;

  constructor() { }

  downloadPdfFromDetail(): void {
    if (this.bill?.pdf_link) {
      window.open(this.bill.pdf_link, '_blank');
    }
  }
}