import { Component, Input } from '@angular/core';

interface Medication {
  id: string;
  medication: string;
  dosage: string;
  frequency: string;
  startDate: string;
  prescribedBy: string;
}
@Component({
  selector: 'app-current-medications',
  standalone: false,
  templateUrl: './current-medications.component.html',
  styleUrl: './current-medications.component.css'
})
export class CurrentMedicationsComponent {
  @Input() id: string = 'medications';

  sectionTitle: string = "Médicaments Actuels";
  sectionSubtitle: string = "Médicaments actuellement prescrits";
  sectionIcon: string = "fas fa-pills";

  medications: Medication[] = [
    {
      id: 'med1',
      medication: 'Lisinopril',
      dosage: '10mg',
      frequency: 'Once daily',
      startDate: '15 mai 2021',
      prescribedBy: 'Dr. Sarah Johnson'
    },
    {
      id: 'med2',
      medication: 'Metformin',
      dosage: '500mg',
      frequency: 'Twice daily',
      startDate: '25 mars 2020',
      prescribedBy: 'Dr. Sarah Johnson'
    },
    {
      id: 'med3',
      medication: 'Albuterol inhaler',
      dosage: '2 puffs',
      frequency: 'As needed',
      startDate: '20 févr. 2010',
      prescribedBy: 'Dr. Michael Brown'
    }
  ];
  constructor() { }
}
