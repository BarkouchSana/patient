import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, of } from 'rxjs';

export interface Appointment {
  status: string;
  id: number;
  date: string;     
  time: string;    
  reason: string;
  doctor: { id: number; name: string; specialty: string; };
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

}
