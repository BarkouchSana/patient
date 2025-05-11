import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-scanned-scripts',
  standalone: false,
  templateUrl: './scanned-scripts.component.html',
  styleUrl: './scanned-scripts.component.css'
})
export class ScannedScriptsComponent implements OnInit {
  // documents = [
  //   { title: 'Certificat Médical 1', date: '2025-04-20', fileUrl: 'assets/documents/certificat1.pdf' },
  //   { title: 'Certificat Médical 2', date: '2025-04-18', fileUrl: 'assets/documents/certificat2.pdf' }
  // ];

  // viewDocument(document: any): void {
  //   window.open(document.fileUrl, '_blank');
  // }

  // downloadDocument(document: any): void {
  //   const link = document.createElement('a');
  //   link.href = document.fileUrl;
  //   link.download = document.title;
  //   link.click();
  // }
  scannedScripts = [
    {
      id: 'SS001',
      date: '2025-04-15',
      fileName: 'diabetes_prescription.pdf',
      fileUrl: '/assets/documents/diabetes_prescription.pdf',
      description: 'Prescription for diabetes medication',
      doctor: 'Dr. Smith'
    },
    {
      id: 'SS002',
      date: '2025-03-22',
      fileName: 'emergency_treatment.pdf',
      fileUrl: '/assets/documents/emergency_treatment.pdf',
      description: 'Emergency room treatment plan',
      doctor: 'Dr. Johnson'
    }
  ];

  constructor() {}

  ngOnInit(): void {}

  viewScript(script: any): void {
    window.open(script.fileUrl, '_blank');
  }

  downloadScript(script: any): void {
    const link = document.createElement('a');
    link.href = script.fileUrl;
    link.download = script.fileName;
    link.click();
  }

}
