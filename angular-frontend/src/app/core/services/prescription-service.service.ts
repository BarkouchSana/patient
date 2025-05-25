import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';
import { MedicalRecordItem } from '../../features/medical-record/components/prescription-list/prescription-list.component';  

@Injectable({
  providedIn: 'root'
})
export class PrescriptionService {
  private apiUrl = 'http://127.0.0.1:8000/api'; // URL de votre API Laravel

  constructor(private http: HttpClient) { }
 
getPrescriptions(): Observable<MedicalRecordItem[]> {
    console.log('PrescriptionService: Fetching prescriptions from the backend');
    
    // URL modifiée pour utiliser l'endpoint qui travaille avec le premier patient
    return this.http.get<{ data: MedicalRecordItem[] }>(`${this.apiUrl}/prescriptions`).pipe(
      tap(response => console.log('PrescriptionService: Raw response', response)),
      map(response => {
        if (!response || !response.data) {
          console.warn('PrescriptionService: Response or response.data is undefined. Returning empty array.');
          return [];
        }
        console.log('PrescriptionService: Mapped data', response.data);
        return response.data;
      }),
      catchError(this.handleError)
    );
  }

  private handleError(error: HttpErrorResponse) {
    let errorMessage = 'An unknown error occurred!';
    if (error.error instanceof ErrorEvent) {
      // Erreur côté client
      errorMessage = `Error: ${error.error.message}`;
    } else {
      // Erreur côté serveur
      errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
      if (error.error && error.error.message) {
        errorMessage += `\nServer Message: ${error.error.message}`;
      }
    }
    console.error('PrescriptionService: Error caught', errorMessage, error);
    return throwError(() => new Error(errorMessage));
  }
}