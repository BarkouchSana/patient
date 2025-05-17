import { Component, Input } from '@angular/core';
interface MedicalCondition {
  id: string;
  condition: string;
  diagnosisDate: string;
  status: string;
  notes?: string;
}
@Component({
  selector: 'app-current-medical-conditions',
  standalone: false,
  templateUrl: './current-medical-conditions.component.html',
  styleUrl: './current-medical-conditions.component.css'
})
export class CurrentMedicalConditionsComponent {
  @Input() id: string = 'medical-conditions';

  sectionTitle: string = "Conditions Médicales Actuelles";
  sectionSubtitle: string = "Conditions médicales diagnostiquées et actuellement traitées";
  sectionIcon: string = "fas fa-stethoscope";

  conditions: MedicalCondition[] = [
    {
      id: 'cond1',
      condition: 'Hypertension',
      diagnosisDate: '12 mai 2021',
      status: 'Controlled',
      notes: 'Patient needs to check blood pressure regularly'
    },
    {
      id: 'cond2',
      condition: 'Type 2 Diabetes',
      diagnosisDate: '22 mars 2020',
      status: 'Controlled',
      notes: 'Diet and exercise management, regular glucose monitoring'
    }
  ];
  constructor() { }
}
