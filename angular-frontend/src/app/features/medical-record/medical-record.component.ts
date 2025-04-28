import { Component } from '@angular/core';

@Component({
  selector: 'app-medical-record',
  standalone: false,
  templateUrl: './medical-record.component.html',
  styleUrl: './medical-record.component.css'
})
export class MedicalRecordComponent {
  // tabs: string[] = ['Ordonnances', 'Résultats d\'analyse', 'Certificats'];
  // selectedTab: string = 'Ordonnances';

  // selectTab(tab: string): void {
  //   this.selectedTab = tab;
  // }


  activeTab: string = 'prescriptions';

  medicalRecords = {
    prescriptions: [
      {
        date: '20/04/2024',
        doctor: 'Dr. Smith',
        medications: ['Amoxicillin 500mg', 'Ibuprofen 400mg']
      },
      {
        date: '15/04/2024',
        doctor: 'Dr. Johnson',
        medications: ['Omeprazole 20mg']
      }
    ],
    labResults: [
      {
        testName: 'Blood Test',
        date: '18/04/2024',
        status: 'Completed'
      },
      {
        testName: 'X-Ray',
        date: '25/04/2024',
        status: 'Pending'
      }
    ],
    certificates: [
      {
        title: 'Medical Fitness Certificate',
        date: '10/04/2024',
        doctor: 'Dr. Smith'
      },
      {
        title: 'Vaccination Certificate',
        date: '15/03/2024',
        doctor: 'Dr. Johnson'
      }
    ]  };
    setActiveTab(tab: string): void {
      this.activeTab = tab;
    }
}
