import { Component, Input } from '@angular/core';
interface PastSurgery {
  id: string;
  surgery: string;
  date: string;
  hospital: string;
  surgeon: string;
  notes?: string;
  icon?: string; // Pour l'icône à côté du titre de la section
}
@Component({
  selector: 'app-surgeries',
  standalone: false,
  templateUrl: './surgeries.component.html',
  styleUrl: './surgeries.component.css'
})
export class SurgeriesComponent {
  @Input() id: string = 'surgeries'; // Pour le défilement

  sectionTitle: string = "Chirurgies Passées";
  sectionSubtitle: string = "Interventions chirurgicales antérieures";
  sectionIcon: string = "fas fa-calendar-alt"; // Icône Font Awesome

  pastSurgeries: PastSurgery[] = [
    {
      id: 'surg1',
      surgery: 'Appendectomy',
      date: '8 nov. 2015',
      hospital: 'Central Hospital',
      surgeon: 'Dr. James Wilson',
      notes: 'No complications during surgery'
    },

    {
      id: 'surg2',
      surgery: 'Knee Arthroscopy',
      date: '14 juil. 2019',
      hospital: 'Orthopedic Specialty Center',
      surgeon: 'Dr. Emily Chen',
      notes: 'Performed to repair torn meniscus'
    }
  ];
  constructor() { }
}
