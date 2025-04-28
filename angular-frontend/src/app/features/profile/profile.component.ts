import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { PatientService } from '../../core/services/patient.service';
 

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  standalone: false,
  styleUrls: ['./profile.component.css']

   
   
  
})
export class ProfileComponent implements OnInit {
  form: FormGroup;
  loading = false;
  photoPreview: string | null = null;
  constructor(private fb: FormBuilder, private patientService: PatientService)  
    {
    this.form = this.fb.group({
      photo: [null],
      email: ['', [Validators.required, Validators.email]],
      name: ['', Validators.required],
      surname: ['', Validators.required],
      birthdate: ['', Validators.required],
     
      gender: [''],
      address: [''],
      emergencyContact: [''],
      maritalStatus: [''],
      bloodType: [''],
      nationality: ['']
    });
     
  }
  ngOnInit(): void {
    this.loadProfile();
  }
  loadProfile(): void {
    this.loading = true;
    this.patientService.getProfile().subscribe({
      next: (data) => {
        this.form.patchValue(data); // Remplit le formulaire avec les données reçues
        if (data.photo) {
          this.photoPreview = data.photo; // Affiche l'aperçu de la photo si elle existe
        }
        this.loading = false;
      },
      error: (err) => {
        console.error('Erreur lors du chargement du profil :', err);
        this.loading = false;
      }
    });
  }
  saveProfile(): void {
    if (this.form.invalid) {
        console.error('Form validation errors:', this.form.errors);
        return;
    }

    this.loading = true;
    const formData = new FormData();

    // Add all form fields to FormData
    const formValue = this.form.value;
    Object.keys(formValue).forEach(key => {
        if (key === 'photo') {
            const photoFile = this.form.get('photo')?.value;
            if (photoFile instanceof File) {
                formData.append('photo', photoFile, photoFile.name);
            }
        } else if (formValue[key] !== null && formValue[key] !== undefined) {
            formData.append(key, formValue[key]);
        }
    });

    // Debug log
    formData.forEach((value, key) => {
        if (value instanceof File) {
            console.log(`${key}: File - ${value.name} (${value.type})`);
        } else {
            console.log(`${key}: ${value}`);
        }
    });

    this.patientService.updateProfile(formData).subscribe({
        next: (response) => {
            console.log('Profile updated successfully:', response);
            if (response.data?.photo) {
                this.photoPreview = response.data.photo;
            }
            this.loading = false;
            alert('Profile updated successfully');
        },
        error: (error) => {
            console.error('Error updating profile:', error);
            
            if (error.status === 422) {
                const validationErrors = error.error.errors;
                const errorMessages = Object.values(validationErrors)
                    .flat()
                    .join('\n');
                alert(`Validation errors:\n${errorMessages}`);
            } else {
                alert('An error occurred while updating the profile');
            }
            
            this.loading = false;
        }
    });
}

onFileSelected(event: Event): void {
  const input = event.target as HTMLInputElement;
  if (input.files && input.files[0]) {
    const file = input.files[0];
    this.form.patchValue({ photo: file }); // Ajoute le fichier au formulaire
    this.form.get('photo')?.updateValueAndValidity();

    // Générer un aperçu de l'image
    const reader = new FileReader();
    reader.onload = () => {
      this.photoPreview = reader.result as string;
    };
    reader.readAsDataURL(file);
  }
}}
