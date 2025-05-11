import { Component, OnInit } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormBuilder, FormGroup } from '@angular/forms';
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
  
    currentPatientId: number = 1; // <<--- EXAMPLE: Replace with actual patientId source
  
    isLoading: boolean = false;
    errorMessage: string | null = null;
  
    constructor(
      private appointmentService: AppointmentService
    ) {}
  
    ngOnInit(): void {
      if (this.currentPatientId) {
        this.loadAppointmentHistory();
      } else {
        this.errorMessage = 'Patient ID is not set. Cannot load history.';
        console.error(this.errorMessage);
      }
    }
  
    loadAppointmentHistory(): void {
      if (!this.currentPatientId) {
        this.errorMessage = 'Cannot load history: Patient ID is missing.';
        console.error(this.errorMessage);
        return;
      }
      this.isLoading = true;
      this.errorMessage = null;
      this.appointmentService.getAppointmentHistory(this.currentPatientId).subscribe(
        (data) => {
          this.allAppointments = data.map(appointment => ({
            ...appointment,
            status: appointment.status || 'Unknown' // Provide a default value if status is missing
          }));
          this.applyFiltersAndPagination();
          this.isLoading = false;
        },
        (error) => {
          console.error('Error fetching appointment history:', error);
          this.errorMessage = 'Failed to load appointment history. Please try again later.';
          this.isLoading = false;
          this.allAppointments = [];
          this.applyFiltersAndPagination();
        }
      );
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
  
    // Nouvelle méthode pour obtenir la classe CSS du statut
    getStatusClass(status: string | null | undefined): string {
      if (!status) {
        return '';
      }
      return status.toLowerCase().replace(/\s+/g, '-');
    }
   
  
}
