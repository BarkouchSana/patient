import { Component, Input } from '@angular/core';

interface ChronicDisease {
  id: string;
  disease: string;
  diagnosisDate: string;
  severity: 'Légère' | 'Modérée' | 'Sévère';
  notes?: string;
}

@Component({
  selector: 'app-chronic-diseases',
  standalone: false,
  templateUrl: './chronic-diseases.component.html',
  styleUrl: './chronic-diseases.component.css'
})
export class ChronicDiseasesComponent {
  @Input() id: string = 'chronic-diseases';

  sectionTitle: string = "Maladies Chroniques";
  sectionSubtitle: string = "Maladies chroniques diagnostiquées";
  sectionIcon: string = "fas fa-heartbeat";

  diseases: ChronicDisease[] = [
    {
      id: 'cd1',
      disease: 'Asthma',
      diagnosisDate: '15 févr. 2010',
      severity: 'Modérée',
      notes: 'Occasional exacerbations during spring allergy season'
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
