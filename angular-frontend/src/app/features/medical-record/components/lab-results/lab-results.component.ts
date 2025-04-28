import { Component } from '@angular/core';

@Component({
  selector: 'app-lab-results',
  standalone: false,
  templateUrl: './lab-results.component.html',
  styleUrl: './lab-results.component.css'
})
export class LabResultsComponent {
  documents = [
    { title: 'Résultat Analyse 1', date: '2025-04-18', fileUrl: 'assets/documents/analyse1.pdf' },
    { title: 'Résultat Analyse 2', date: '2025-04-15', fileUrl: 'assets/documents/analyse2.pdf' }
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
