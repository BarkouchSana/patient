import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { MedicalRecordItem } from '../../features/medical-record/medical-record.component'; // Ajustez le chemin si nécessaire

@Injectable({
  providedIn: 'root'
})
export class LabResultService { 
 
  private apiUrl = 'http://localhost:8000/api/lab-results'; // Exemple d'URL de développement local

  constructor(private http: HttpClient) { }
getLabResults(): Observable<MedicalRecordItem[]> {
    return this.http.get<{ data: MedicalRecordItem[] }>(this.apiUrl).pipe(
      map(response => {
        console.log('LabResult response from API:', response);
        return response.data || [];
      })
    );
  }
}