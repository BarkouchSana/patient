import { Component, OnInit, Inject } from '@angular/core';
import { AppointmentService } from '../../../../core/services/appointment.service';
@Component({
  selector: 'app-appointment-create',
  standalone: false,
  templateUrl: './appointment-create.component.html',
  styleUrl: './appointment-create.component.css',
  providers: [AppointmentService]
})
export class AppointmentCreateComponent implements OnInit {
  appointment = {
    date: '',
    time: '',
    reason: ''
  };
  
  availableSlots: string[] = [];
  confirmationMessage: string | null = null;

  // constructor(@Inject(AppointmentService) private appointmentService: AppointmentService) {}
  constructor() {}
  ngOnInit(): void {
    // Simuler l'appel à une API pour récupérer les créneaux disponibles
    this.availableSlots = ['09:00', '10:00', '11:00', '14:00', '15:00'];

    // this.appointmentService.getAvailableSlots().subscribe(
    //   (slots: string[]) => {
    //     this.availableSlots = slots;
    //   },
    //   (error: any) => {
    //     console.error('Erreur lors de la récupération des créneaux :', error);
    //   }
    // );
  }

  submitAppointment(): void {
    // Simuler l'envoi des données à une API
    console.log('Rendez-vous pris :', this.appointment);
    this.confirmationMessage = 'Votre rendez-vous a été pris avec succès !';
  }
}
