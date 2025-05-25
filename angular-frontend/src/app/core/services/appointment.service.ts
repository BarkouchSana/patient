import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, of } from 'rxjs';

export interface Appointment {
  id: number;
  date: string;     
  time: string;    
  reason: string;
  status: string;
  doctorName: string;
  doctorSpecialty?: string;
  cancelReason?: string;
  location?: string;
  followUp?: boolean;
  notes?: string[];
}



@Injectable({
  providedIn: 'root'
})
export class AppointmentService {
  private apiUrl = 'http://localhost:8000/api';  

  constructor(private http: HttpClient) {}

  getAppointmentHistory(patientId: number): Observable<Appointment[]> {
    
    const params = new HttpParams().set('patientId', patientId.toString());
    return this.http.get<Appointment[]>(`${this.apiUrl}/appointments/history`, { params });
  }

   
  getAppointments(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/appointments`);  
  }

  getAppointment(id: number): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/appointments/${id}`);  
  }

  cancelAppointment(id: number, reason?: string): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/appointments/${id}/cancel`, { reason });
  }
  
  rescheduleAppointment(id: number, newDate: string, newTimeSlotId: number): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/appointments/${id}/reschedule`, {
      date: newDate,
      time_slot_id: newTimeSlotId
    });
  }



  getAppointmentDetails(id: number): Observable<Partial<Appointment>> {
    return this.http.get<Partial<Appointment>>(`${this.apiUrl}/appointments/${id}`);
  }

 


}
