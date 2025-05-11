import { Component, OnInit } from '@angular/core';
import { MedicalHistoryService } from '../../core/services/medical-history.service';

@Component({
  selector: 'app-medical-history',
  standalone: false,
  templateUrl: './medical-history.component.html',
  styleUrl: './medical-history.component.css'
})
export class MedicalHistoryComponent  implements OnInit {

  medicalHistory: any = null;
  errorMessage: string | null = null;
  showCurrentConditions = true;
  showPastSurgeries = true;
  showChronicDiseases = true;
  showCurrentMedications = true;
  showAllergies = true;
  isLoading = true;
  constructor(private medicalHistoryService: MedicalHistoryService) {}

  ngOnInit(): void {
    this.loadMedicalHistory();
  }
  loadMedicalHistory(): void {
    this.isLoading = true;
    const patientId = 1;
    this.medicalHistoryService.getMedicalHistory(patientId).subscribe({
      next: (data) => {
        this.medicalHistory = {
          currentMedicalConditions: data.currentMedicalConditions || [],
          pastSurgeries: data.pastSurgeries || [],
          chronicDiseases: data.chronicDiseases || [],
          currentMedications: data.currentMedications || [],
          allergies: data.allergies || [],
          lastUpdated: data.lastUpdated || null,
         
        };

        this.errorMessage = null;
        this.isLoading = false;
      },
      error: (err) => {
        console.error('Error fetching medical history:', err);
        this.errorMessage = 'Failed to load medical history. Please try again later.';
        this.isLoading = false;
      }
    });
  }
  
  toggleSection(section: string): void {
    switch (section) {
      case 'currentConditions':
        this.showCurrentConditions = !this.showCurrentConditions;
        break;
      case 'pastSurgeries':
        this.showPastSurgeries = !this.showPastSurgeries;
        break;
      case 'chronicDiseases':
        this.showChronicDiseases = !this.showChronicDiseases;
        break;
      case 'currentMedications':
        this.showCurrentMedications = !this.showCurrentMedications;
        break;
      case 'allergies':
        this.showAllergies = !this.showAllergies;
        break;
    }
  }
}
