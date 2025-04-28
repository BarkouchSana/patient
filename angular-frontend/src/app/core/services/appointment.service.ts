import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class AppointmentService {

  constructor(private http: HttpClient) {}

  getAvailableSlots(): Observable<string[]> {
    return this.http.get<string[]>('https://api.example.com/available-slots');
  }
}
