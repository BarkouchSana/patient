import { Component } from '@angular/core';

@Component({
  selector: 'app-general-records',
  standalone: false,
  templateUrl: './general-records.component.html',
  styleUrl: './general-records.component.css'
})
export class GeneralRecordsComponent {
  documents = [
    { title: 'Ordonnance 1', date: '2025-04-20', fileUrl: 'assets/images/ord1.webp' },
    { title: 'Ordonnance 2', date: '2025-04-18', fileUrl: 'assets/images/ord2.jpg' }
  ];

  viewDocument(document: any): void {
    window.open(document.fileUrl, '_blank');
  }

  downloadDocument(document: any): void {
    const link = document.createElement('a');
    link.href = document.fileUrl;
    link.download = document.title;
    link.click();
  }
}
