import { Component, Input } from '@angular/core';
interface Allergy {
  id: string;
  allergen: string;
  reaction: string;
  severity: 'Légère' | 'Modérée' | 'Sévère';
  diagnosisDate: string;
  notes?: string;
}
@Component({
  selector: 'app-allergies',
  standalone: false,
  templateUrl: './allergies.component.html',
  styleUrl: './allergies.component.css'
})
export class AllergiesComponent {
  @Input() id: string = 'allergies';

  sectionTitle: string = "Allergies";
  sectionSubtitle: string = "Allergies et réactions connues";
  sectionIcon: string = "fas fa-allergies"; // ou "fas fa-exclamation-triangle" pour l'icône orange

  allergies: Allergy[] = [
    {
      id: 'alg1',
      allergen: 'Penicillin',
      reaction: 'Rash, difficulty breathing',
      severity: 'Sévère',
      diagnosisDate: '10 juin 2008',
      notes: 'Avoid all penicillin-based antibiotics'
    },
    {
      id: 'alg2',
      allergen: 'Pollen',
      reaction: 'Sneezing, runny nose, watery eyes',
      severity: 'Modérée',
      diagnosisDate: '3 mai 2005',
      notes: 'Seasonal allergies, worse in spring'
    }
  ];
  constructor() { }

  getSeverityClass(severity: 'Légère' | 'Modérée' | 'Sévère'): string {
    switch (severity) {
      case 'Légère': return 'bg-status-success text-status-success-dark';
      case 'Modérée': return 'bg-status-warning text-status-warning-dark';
      case 'Sévère': return 'bg-status-urgent text-status-urgent-dark';
      default: return 'bg-gray-200 text-gray-800';
    }
  }
}
