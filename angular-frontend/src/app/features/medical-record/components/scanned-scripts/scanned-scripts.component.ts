import { Component } from '@angular/core';

@Component({
  selector: 'app-scanned-scripts',
  standalone: false,
  templateUrl: './scanned-scripts.component.html',
  styleUrl: './scanned-scripts.component.css'
})
export class ScannedScriptsComponent {
  documents = [
    { title: 'Certificat Médical 1', date: '2025-04-20', fileUrl: 'assets/documents/certificat1.pdf' },
    { title: 'Certificat Médical 2', date: '2025-04-18', fileUrl: 'assets/documents/certificat2.pdf' }
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
