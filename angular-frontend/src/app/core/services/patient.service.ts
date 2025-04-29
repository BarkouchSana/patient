import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PatientService {
  private baseUrl = 'http://127.0.0.1:8000/api';
  
  constructor(private http: HttpClient) {}
  
  getProfile(): Observable<any> {
    return this.http.get(`${this.baseUrl}/profile`);
  }
  
  updateProfile(payload: any): Observable<any> {
    return this.http.put(`${this.baseUrl}/profile/update`, payload);
  }
  
  updateProfileImage(formData: FormData): Observable<any> {
    return this.http.post(`${this.baseUrl}/profile/update-image`, formData);
  }
}
