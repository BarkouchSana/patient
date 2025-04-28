import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-medical-history',
  standalone: false,
  templateUrl: './medical-history.component.html',
  styleUrl: './medical-history.component.css'
})
export class MedicalHistoryComponent {
  medicalHistory = {
    allergies: ['Pollen', 'Arachides', 'Poussière'],
    chronicDiseases: ['Diabète de type 2', 'Hypertension'],
    currentMedications: ['Metformine', 'Lisinopril'],
    surgeries: ['Appendicectomie (2015)', 'Chirurgie du genou (2018)']
  };

  constructor() {}

  ngOnInit(): void {
    // Vous pouvez remplacer les données statiques par un appel API ici
  }
}
