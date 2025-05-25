import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { Router } from '@angular/router';
import { AppointmentService } from '../../../../core/services/appointment.service';
import { Appointment } from '../../../../core/domain/models/appointment.model';

@Component({
  selector: 'app-appointment-history',
  standalone: false,
  templateUrl: './appointment-history.component.html',
  styleUrl: './appointment-history.component.css'
})
export class AppointmentHistoryComponent implements OnInit {

    allAppointments: Appointment[] = [];
    filteredAppointments: Appointment[] = [];
    paginatedAppointments: Appointment[] = [];
  
    currentPage: number = 1;
    itemsPerPage: number = 5;
    searchTerm: string = '';
  
    doctorName: string = 'Dr. Sarah Johnson';
  
     
    isLoading: boolean = false;
    errorMessage: string | null = null;
    
    // Nouvelle propriété pour suivre les rendez-vous développés
    expandedAppointmentIds: Set<number> = new Set();
  
    constructor(
      private appointmentService: AppointmentService,
      private cdr: ChangeDetectorRef,
      private dialog: MatDialog,
      private router: Router
    ) {}
  
    ngOnInit(): void {
      this.loadAppointmentHistory();
    }
  
     loadAppointmentHistory(): void {
    this.isLoading = true;
    this.errorMessage = null;
    
    // Ne passe plus de patientId - le backend utilise le premier patient
    this.appointmentService.getAppointmentHistory().subscribe({
      next: (data) => {
        this.allAppointments = data.map(appointment => {
          let parsedDate: string = appointment.date as string; // Par défaut, on garde la chaîne originale
          if (typeof appointment.date === 'string') {
            // Supprimer les suffixes ordinaux (st, nd, rd, th) avant de tenter l'analyse
            const dateStringWithoutOrdinal = appointment.date.replace(/(\d+)(st|nd|rd|th)/, '$1');
            const tempDate = new Date(dateStringWithoutOrdinal);
            if (!isNaN(tempDate.getTime())) { // Vérifier si la conversion a réussi
              parsedDate = tempDate.toISOString(); // Convertir Date en chaîne ISO
            } else {
              console.warn(`Impossible d'analyser la chaîne de date: "${appointment.date}". Utilisation de l'original ou pourrait apparaître comme invalide.`);
            }
} else if (appointment.date && Object.prototype.toString.call(appointment.date) === '[object Date]') {
            parsedDate = (appointment.date as Date).toISOString(); // Convertir Date en chaîne ISO
          }

          return {
            ...appointment,
            // Ensure patientId and doctorId are present, defaulting if not found on the source object.
            // This addresses the type error if the source 'appointment' objects from 'data'
            // do not contain patientId or doctorId, which are required by the Appointment model.
          
            doctorId: (appointment as any).doctorId ?? -1,   // Using -1 as a default for missing ID
            date: parsedDate, // Garantir que date est toujours une chaîne
            status: this.mapServiceStatusToDomainStatus(appointment.status as string | undefined, 'Unknown')
          };
        });

console.log('Données brutes reçues (data):', JSON.stringify(data.slice(0, 10))); 
        console.log('allAppointments (après mapping, 10 premiers):', JSON.stringify(this.allAppointments.slice(0, 10)));
        
        this.applyFiltersAndPagination();
                  
        if (this.paginatedAppointments) {
          console.log('paginatedAppointments (première page):', JSON.stringify(this.paginatedAppointments));
          console.log('Nombre dans paginatedAppointments:', this.paginatedAppointments.length);
        }
        console.log('currentPage:', this.currentPage, 'itemsPerPage:', this.itemsPerPage);
        
        this.isLoading = false;
        this.cdr.detectChanges();
      },
      error: (error) => {
        console.error('Erreur lors de la récupération de l\'historique des rendez-vous:', error);
        this.errorMessage = 'Échec du chargement de l\'historique des rendez-vous. Veuillez réessayer plus tard.';
        this.isLoading = false;
        this.allAppointments = [];
        this.applyFiltersAndPagination();
        this.cdr.detectChanges(); 
      }
    });
  }


  
    applyFiltersAndPagination(): void {
      let tempAppointments = this.allAppointments;
      if (this.searchTerm.trim() !== '') {
        tempAppointments = this.allAppointments.filter((appointment) =>
          appointment.reason?.toLowerCase().includes(this.searchTerm.toLowerCase())
        );
      }
      this.filteredAppointments = tempAppointments;
      this.updatePaginatedAppointments();
    }
  
    onSearchTermChange(): void {
      this.currentPage = 1;
      this.applyFiltersAndPagination();
    }
  
    updatePaginatedAppointments(): void {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      this.paginatedAppointments = this.filteredAppointments.slice(
        startIndex,
        endIndex
      );
    }
  
    totalPages(): number {
      return Math.ceil(this.filteredAppointments.length / this.itemsPerPage);
    }
  
    totalPagesArray(): number[] {
      const total = this.totalPages();
      if (total === 0) return [];
      return Array(total)
        .fill(0)
        .map((x, i) => i + 1);
    }
  
    goToPage(page: number): void {
      if (page >= 1 && page <= this.totalPages()) {
        this.currentPage = page;
        this.updatePaginatedAppointments();
      }
    }
  
    nextPage(): void {
      if (this.currentPage < this.totalPages()) {
        this.currentPage++;
        this.updatePaginatedAppointments();
      }
    }
  
    previousPage(): void {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.updatePaginatedAppointments();
      }
    }
  
    openFilterModal(): void {
      console.log('Filter button clicked');
    }
  
    exportData(): void {
      console.log('Export button clicked');
    }
  
    trackByAppointmentId(index: number, appointment: Appointment): number {
      return appointment.id;
    }
  
    // Méthode pour obtenir la classe CSS du statut
    getStatusClass(status: string | null | undefined): string {
      if (!status) {
        return '';
      }
      
      switch (status.toLowerCase()) {
        case 'confirmed':
        case 'completed':
          return 'bg-status-success/20 text-status-success border border-status-success/30';
        case 'pending':
          return 'bg-status-warning/20 text-status-warning border border-status-warning/30';
        case 'cancelled':
          return 'bg-status-urgent/20 text-status-urgent border border-status-urgent/30';
        default:
          return 'bg-hover text-text-muted border border-border';
      }
    }
    
    // Méthodes pour la vue détaillée
    toggleAppointmentDetails(appointment: Appointment): void {
      if (this.expandedAppointmentIds.has(appointment.id)) {
        this.expandedAppointmentIds.delete(appointment.id);
      } else {
        this.expandedAppointmentIds.add(appointment.id);
        
        // Charger des détails supplémentaires si nécessaire
        if (!appointment.doctorSpecialty) {
          this.loadAppointmentDetails(appointment.id);
        }
      }
    }
  
    isAppointmentExpanded(id: number): boolean {
      return this.expandedAppointmentIds.has(id);
    }
  
    loadAppointmentDetails(id: number): void {
      // Charger des détails supplémentaires depuis l'API
      this.appointmentService.getAppointmentDetails(id).subscribe(
        (details: Partial<Omit<Appointment, 'status'> & { status?: string }>) => {
          // Mettre à jour les détails du rendez-vous
          const index = this.allAppointments.findIndex(a => a.id === id);
          if (index !== -1) {
            const existingAppointment = this.allAppointments[index];
            const newStatus = this.mapServiceStatusToDomainStatus(details.status, existingAppointment.status);

            this.allAppointments[index] = {
              ...existingAppointment,
              ...details, // Spread other properties from details
              status: newStatus, // Override status with the correctly mapped and typed one
              // S'assurer que les propriétés spécifiques sont correctement mises à jour
              doctorSpecialty: details.doctorSpecialty || existingAppointment.doctorSpecialty || 'General Practice',
              location: details.location || existingAppointment.location || 'Main Medical Center',
              notes: details.notes || existingAppointment.notes || [],
              followUp: typeof details.followUp === 'boolean' ? details.followUp : (existingAppointment.followUp || false)
            };
            
            // Mettre à jour également dans les rendez-vous paginés
            const pageIndex = this.paginatedAppointments.findIndex(a => a.id === id);
            if (pageIndex !== -1) {
              this.paginatedAppointments[pageIndex] = this.allAppointments[index];
            }
            
            this.cdr.detectChanges();
          }
        },
        error => {
          console.error('Failed to load appointment details:', error);
        }
      );
    }
  
    viewMedicalRecord(id: number): void {
      // Naviguer vers la page du dossier médical
      this.router.navigate(['/medical-records'], { queryParams: { appointmentId: id } });
    }
  
    rescheduleAppointment(id: number): void {
      // Naviguer vers la page de reprogrammation
      this.router.navigate(['/appointments/reschedule', id]);
    }
  
    printConfirmation(id: number): void {
      const appointmentIndex = this.paginatedAppointments.findIndex(a => a.id === id);
      if (appointmentIndex !== -1) {
        const appointment = this.paginatedAppointments[appointmentIndex];
        
        // Créer une nouvelle fenêtre pour l'impression
        const printWindow = window.open('', '_blank');
        if (printWindow) {
          printWindow.document.write(`
            <html>
              <head>
                <title>Appointment Confirmation</title>
                <style>
                  body { font-family: Arial, sans-serif; padding: 20px; }
                  h1 { color: #3b82f6; }
                  .details { margin-top: 20px; }
                  .label { font-weight: bold; width: 120px; display: inline-block; }
                  .footer { margin-top: 30px; border-top: 1px solid #ccc; padding-top: 10px; font-size: 0.9em; }
                </style>
              </head>
              <body>
                <h1>Appointment Confirmation</h1>
                <div class="details">
                  <p><span class="label">Date:</span> ${appointment.date}</p>
                  <p><span class="label">Time:</span> ${appointment.time}</p>
                  <p><span class="label">Doctor:</span> ${appointment.doctorName}</p>
                  <p><span class="label">Status:</span> ${appointment.status}</p>
                  <p><span class="label">Reason:</span> ${appointment.reason || 'Not specified'}</p>
                  ${appointment.location ? `<p><span class="label">Location:</span> ${appointment.location}</p>` : ''}
                </div>
                <div class="footer">
                  <p>Please arrive 15 minutes before your appointment time.</p>
                  <p>If you need to reschedule or cancel, please call at least 24 hours in advance.</p>
                </div>
              </body>
            </html>
          `);
          printWindow.document.close();
          printWindow.print();
        }
      }
    }
  
    cancelAppointment(id: number): void {
      if (confirm('Are you sure you want to cancel this appointment?')) {
        this.appointmentService.cancelAppointment(id, 'Cancelled by patient').subscribe(
          () => {
            // Mettre à jour le statut du rendez-vous en local
            const index = this.allAppointments.findIndex(a => a.id === id);
            if (index !== -1) {
              this.allAppointments[index].status = 'Cancelled';
              this.allAppointments[index].cancelReason = 'Cancelled by patient';
              
              // Mettre à jour également dans les rendez-vous paginés
              const pageIndex = this.paginatedAppointments.findIndex(a => a.id === id);
              if (pageIndex !== -1) {
                this.paginatedAppointments[pageIndex].status = 'Cancelled';
                this.paginatedAppointments[pageIndex].cancelReason = 'Cancelled by patient';
              }
              
              this.cdr.detectChanges();
            }
          },
          error => {
            console.error('Failed to cancel appointment:', error);
          }
        );
      }
    }
  
    canReschedule(appointment: Appointment): boolean {
      // Un rendez-vous peut être reprogrammé s'il est confirmé ou en attente
      // et s'il n'est pas dans le passé
      return ['Confirmed', 'Pending'].includes(appointment.status || '') && 
             !this.isAppointmentInPast(appointment);
    }
  
    canCancel(appointment: Appointment): boolean {
      // Un rendez-vous peut être annulé s'il est confirmé ou en attente
      // et s'il n'est pas dans le passé
      return ['Confirmed', 'Pending'].includes(appointment.status || '') && 
             !this.isAppointmentInPast(appointment);
    }
  
    isAppointmentInPast(appointment: Appointment): boolean {
      if (!appointment.date) return false;
      
      const appointmentDate = new Date(appointment.date);
      const today = new Date();
      // Set time to 00:00:00 for today to compare dates only, not times
      today.setHours(0, 0, 0, 0); 
      // Retourner true si le rendez-vous est dans le passé
      return appointmentDate < today;
    }

    private mapServiceStatusToDomainStatus(
      serviceStatus: string | undefined, 
      currentStatus: Appointment['status']
    ): Appointment['status'] {
      if (serviceStatus === undefined || serviceStatus === null || serviceStatus.trim() === '') {
        return currentStatus; // Use fallback status if serviceStatus is not provided
      }
      const validStatuses: ReadonlyArray<Appointment['status']> = ["Pending", "Confirmed", "Completed", "Cancelled", "Unknown"];
      const normalizedServiceStatus = serviceStatus.trim();

      for (const validStatus of validStatuses) {
        if (validStatus.toLowerCase() === normalizedServiceStatus.toLowerCase()) {
          return validStatus; // Return the matched status with correct casing
        }
      }
      // If serviceStatus is provided but not recognized, default to 'Unknown'
      return 'Unknown';
    }
}