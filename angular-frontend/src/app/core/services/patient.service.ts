import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PatientService {
  private api = 'http://127.0.0.1:8000/api/profile';
  constructor(private http: HttpClient) {}
  getProfile(): Observable<any> {
    return this.http.get(this.api);
  }
  updateProfile(payload: any): Observable<any> {
    return this.http.put(this.api, payload);
  }
}
