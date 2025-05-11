import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, of } from 'rxjs';

export interface Appointment {
  status: string;
  id: number;
  date: string;    // 'YYYY-MM-DD'
  time: string;    // 'HH:mm'
  reason: string;
  doctor: { id: number; name: string; specialty: string; };
}



@Injectable({
  providedIn: 'root'
})
export class AppointmentService {
  private apiUrl = 'http://localhost:8000/api'; // Your Laravel API base URL

  constructor(private http: HttpClient) {}

  getAppointmentHistory(patientId: number): Observable<Appointment[]> {
    // Pass patientId as a query parameter
    const params = new HttpParams().set('patientId', patientId.toString());
    return this.http.get<Appointment[]>(`${this.apiUrl}/appointments/history`, { params });
  }

  // You can keep other methods if they are used elsewhere
  getAppointments(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/appointments`); // General endpoint, adjust if needed
  }

  getAppointment(id: number): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/appointments/${id}`); // Adjust endpoint
  }

}
