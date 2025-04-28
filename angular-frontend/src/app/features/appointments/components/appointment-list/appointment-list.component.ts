import { Component } from '@angular/core';

@Component({
  selector: 'app-appointment-list',
  standalone: false,
  templateUrl: './appointment-list.component.html',
  styleUrl: './appointment-list.component.css'
})
export class AppointmentListComponent {
  appointments = [
    { date: '2025-04-25', time: '10:00', reason: 'Consultation générale', status: 'Confirmé' },
    { date: '2025-04-26', time: '14:00', reason: 'Suivi médical', status: 'En attente' },
    { date: '2025-04-27', time: '09:00', reason: 'Vaccination', status: 'Annulé' }
  ];

  canCancel(appointment: any): boolean {
    // Simuler une logique pour vérifier si l'annulation est possible (> 24h avant)
    const appointmentDate = new Date(`${appointment.date}T${appointment.time}`);
    const now = new Date();
    const diff = appointmentDate.getTime() - now.getTime();
    return diff > 24 * 60 * 60 * 1000; // Plus de 24h
  }

  cancelAppointment(appointment: any): void {
    // Simuler l'annulation
    console.log('Rendez-vous annulé :', appointment);
    appointment.status = 'Annulé';
  }

  rescheduleAppointment(appointment: any): void {
    // Simuler la reprogrammation
    console.log('Reprogrammer le rendez-vous :', appointment);
  }
}
