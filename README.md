

#### Backend (Laravel)
### Profile Management Endpoints
#### Get Patient Profile

```
GET /api/profile
```

Retrieves the authenticated patient's profile information.

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
```


**Success Response (200 OK):**
(Based on `ProfileController` snippet)
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "email": "patient@example.com",
    "name": "John",
    "surname": "Doe",
    "birthdate": "1990-01-01",
    "gender": "Male",
    "address": "123 Main St, Anytown",
    "emergencyContact": "Jane Doe - 555-1234",
    "maritalStatus": "Married",
    "bloodType": "O+",
    "nationality": "American",
    "profile_image": "/storage/profile_images/patient_1.jpg" // Example URL
  }
}
```

#### Update Patient Profile

```
PUT /api/profile/update
```
 
 Updates the authenticated patient's profile information.

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
Content-Type: application/json
```

**Request Body:**
```json
{
  "name": "Johnathan",
  "surname": "Doe",
  "birthdate": "1990-01-15",
  "gender": "Male",
  "address": "456 Oak Ave, Anytown",
  "emergencyContact": "Jane Doe - 555-5678",
  "maritalStatus": "Married",
  "bloodType": "O+",
  "nationality": "American"
  // Only include fields to be updated
}
```

**Success Response (200 OK):**
```json
{
  "status": "success",
  "message": "Profile updated successfully.",
  "data": {
   
  }
}
```

**Error Response (422 Unprocessable Entity):**
(For validation errors on the input fields)

#### Change Password

```
POST /api/change-password
```

Changes the authenticated user's password.

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
Content-Type: application/json
```

**Request Body (based on `ChangePasswordDTO`):**
```json
{
  "current_password": "old_secure_password",
  "new_password": "new_strong_password",
  "new_password_confirmation": "new_strong_password"
}
```


**Success Response (200 OK):**
```json
{
  "status": "success",
  "message": "Password changed successfully."
}
```



**Error Response (422 Unprocessable Entity - Validation Error):**
```json
{
  "status": "error",
  "message": "The given data was invalid.",
  "errors": {
    "current_password": ["The current password field is required."],
    "new_password": ["The new password must be at least 8 characters.", "The new password confirmation does not match."]
  }
}
```


**Error Response (401 Unauthorized or 400 Bad Request - Current password incorrect):**
```json
{
  "status": "error",
  "message": "Current password does not match."
}
```


#### Upload Profile Image

```
POST /api/profile/update-image
```

Uploads or updates the user's profile image.

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
Content-Type: multipart/form-data
``

**Request Body (form-data):**
-   `profile_image`: (file) The image file to upload (e.g., jpg, png).

**Success Response (200 OK):**
```json
{
  "status": "success",
  "message": "Profile image uploaded successfully.",
  "data": {
    "profile_image": "/storage/profile_images/new_image.jpg"
  }
}
```

**Error Response (422 Unprocessable Entity):**
(For validation errors like file type, size, etc.)


### Patient Data Endpoints
#### Dashboard Endpoints
##### Get Patient Dashboard Data
 
```
GET /api/patient/dashboard
```

Retrieves aggregated data for the authenticated patient's dashboard.

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
```


#### Medical History Endpoints
##### Get Patient Medical History
```
GET /api/patients/medical-history
```
Retrieves the medical history for the authenticated patient.

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
```

**Success Response (200 OK - based on `MedicalHistoryResource` and `MedicalHistoryWithVitalsDto`):**
```json
{
    "data": {
        "currentMedicalConditions": [
            "Depression",
            "Anxiety"
        ],
        "pastSurgeries": [
            "Gallbladder removal in 2012",
            "Appendectomy in 2010"
        ],
        "chronicDiseases": [
            "Multiple Sclerosis"
        ],
        "currentMedications": [
            "Levothyroxine 75mcg daily",
            "Escitalopram 10mg daily",
            "Metformin 500mg twice daily"
        ],
        "allergies": [
            "Sulfa drugs",
            "Penicillin",
            "Latex"
        ],
        "vitalSigns": {
            "lastRecorded": null,
            "bloodPressure": {
                "label": "Blood Pressure",
                "value": "114/60",
                "unit": "mmHg",
                "icon": "fas fa-heartbeat"
            },
            "pulse": {
                "label": "Pulse",
                "value": "65",
                "unit": "bpm",
                "icon": "fas fa-heart"
            },
            "temperature": {
                "label": "Temperature",
                "value": "35.9",
                "unit": "°C",
                "icon": "fas fa-thermometer-half"
            },
            "respiratoryRate": {
                "label": "Respiratory Rate",
                "value": "13",
                "unit": "breaths/min",
                "icon": "fas fa-wind"
            },
            "oxygenSaturation": {
                "label": "O₂ Saturation",
                "value": "97",
                "unit": "%",
                "icon": "fas fa-lungs"
            },
            "weight": {
                "label": "Weight",
                "value": "63.3",
                "unit": "kg",
                "icon": "fas fa-weight"
            },
            "height": {
                "label": "Height",
                "value": "180",
                "unit": "cm",
                "icon": "fas fa-ruler-vertical"
            }
        },
        "lastUpdated": "2025-05-25T09:52:22+00:00"
    }
}
```

#### Appointments Endpoints

##### Get Appointment History

```
GET /api/appointments/history
```
Retrieves the appointment history for the authenticated patient. (Note: `AppointmentHistoryController` logic for patient ID should use authenticated user).

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
```
**Success Response (200 OK - based on `AppointmentDTO` and `GetAppointmentHistoryService`):**
```json
[
    {
        "id": 1,
        "date": "May 26th, 2025",
        "time": "09:00 - 09:30",
        "reason": "Back pain",
        "status": "Completed",
        "doctorName": "Dr. Smith 3",
        "doctorSpecialty": "Neurologist",
        "cancelReason": null,
        "location": "Medical Center, Room 349",
        "followUp": false,
        "notes": null
    },
    {
        "id": 7,
        "date": "May 26th, 2025",
        "time": "08:00 - 08:30",
        "reason": "Back pain",
        "status": "Completed",
        "doctorName": "Dr. Smith 5",
        "doctorSpecialty": "Orthopedic Surgeon",
        "cancelReason": null,
        "location": "Medical Center, Room 993",
        "followUp": false,
        "notes": null
    },
    {
        "id": 13,
        "date": "May 19th, 2025",
        "time": "15:30 - 16:00",
        "reason": "Skin rash",
        "status": "Cancelled",
        "doctorName": "Dr. Smith 5",
        "doctorSpecialty": "Orthopedic Surgeon",
        "cancelReason": "Patient requested cancellation",
        "location": "Medical Center, Room 904",
        "followUp": false,
        "notes": null
    },
    {
        "id": 30,
        "date": "April 29th, 2025",
        "time": "09:00 - 09:30",
        "reason": "Headache",
        "status": "Cancelled",
        "doctorName": "Dr. Smith 1",
        "doctorSpecialty": "Cardiologist",
        "cancelReason": "Patient requested cancellation",
        "location": "Medical Center, Room 258",
        "followUp": false,
        "notes": null
    }
]

```
##### Get Appointment Details

```
GET /api/appointments/{id}
```
**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
```
**Path Parameters:**
-   `{id}` (integer, required): The ID of the appointment.

**Success Response (200 OK - based on `AppointmentDTO` from `AppointmentHistoryController`):**
```json
{
    "id": 1,
    "date": "May 26th, 2025",
    "time": "09:00 - 09:30",
    "reason": "Back pain",
    "status": "Completed",
    "doctorName": "Dr. Smith 3",
    "doctorSpecialty": "Neurologist",
    "cancelReason": null,
    "location": "Medical Center, Room 339",
    "followUp": false,
    "notes": [
        "Patient requested morning appointment",
        "Bring previous test results"
    ]
}
```
**Error Response (404 Not Found):**
```json
{
  "status": "error",
  "message": "Appointment not found."
}
```
##### Cancel Appointment

```
POST /api/appointments/{id}/cancel
```

Cancels a specific appointment.

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
Content-Type: application/json
```
**Path Parameters:**
-   `{id}` (integer, required): The ID of the appointment to cancel.

**Request Body (Optional):**
```json
{
  "cancel_reason": "Patient unable to attend."
}
```

**Success Response (200 OK):**
```json
{
  "status": "success",
  "message": "Appointment cancelled successfully.",
  "data": {
    // Updated appointment details with status "Cancelled"
    "id": 2,
    "doctor_name": "Dr. John Smith",
    "doctor_specialty": "General Medicine",
    "date": "15/06/2025",
    "time": "14:00 - 14:30",
    "status": "Cancelled",
    "reason": "Follow-up",
    "cancel_reason": "Patient unable to attend."
  }
}
```
#### Prescriptions Endpoints

##### Get Patient Prescriptions

```
GET /api/prescriptions
```
Retrieves a list of prescriptions for the authenticated patient.
**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
```
**Success Response (200 OK - based on `PrescriptionResource`):**
```json

{
    "data": [
        {
            "id": "1",
            "type": "Prescription",
            "title": "Sertraline",
            "recordDate": "2025-05-14T09:52:22+00:00",
            "doctor": "Dr. Smith",
            "summary": "100mg - Before meals (10 days)",
            "details": "May cause sensitivity to sunlight",
            "tagText": "active",
            "tagClass": "bg-status-success/20 text-status-success border border-status-success/30",
            "status": "active",
            "medicationName": "Sertraline",
            "dosage": "100mg",
            "frequency": "Before meals",
            "duration": "10 days",
            "startDate": "2025-05-14T09:52:22+00:00",
            "endDate": "2025-07-21T09:52:22+00:00",
            "instructions": "May cause sensitivity to sunlight",
            "refills": "No refills authorized",
            "dbStatus": "active"
        }
    ]
}
```
#### Lab Results Endpoints

##### Get Patient Lab Results


```
GET /api/lab-results
```

Retrieves a list of lab results for the authenticated patient.

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
```

**Success Response (200 OK - based on `LabResultResource`):**
```json
{
    "data": [
        {
            "id": "13",
            "type": "LabResult",
            "title": "Complete Blood Count (CBC)",
            "recordDate": "2025-05-24T09:52:23+00:00",
            "doctor": "Dr. Smith 1",
            "summary": "Routine blood test results.",
            "details": "All values within normal range. White blood cell count: 7.5, Red blood cell count: 4.8, Hemoglobin: 14.2,...",
            "tagText": "Completed",
            "tagClass": "bg-status-success/20 text-status-success border border-status-success/30",
            "resultDate": "2025-05-24T21:52:23+00:00",
            "performedBy": "Central Lab Services",
            "status": "completed"
        },
        {
            "id": "14",
            "type": "LabResult",
            "title": "Lipid Panel",
            "recordDate": "2025-05-23T09:52:23+00:00",
            "doctor": "Dr. Smith 1",
            "summary": "Cholesterol and triglyceride levels.",
            "details": "Total Cholesterol: 185 mg/dL, HDL: 55 mg/dL, LDL: 110 mg/dL, Triglycerides: 100 mg/dL. Overall good lipid profile.",
            "tagText": "Reviewed",
            "tagClass": "bg-status-info/20 text-status-info border border-status-info/30",
            "resultDate": "2025-05-24T04:52:23+00:00",
            "performedBy": "Advanced Diagnostics Lab",
            "status": "reviewed"
        }
    ]
}
```
#### Bills Endpoints

##### Get Patient Bills

```
GET /api/bills
```
(Note: `BillController` in snippet uses `/first-patient` and hardcodes patient ID. This should be updated to use authenticated user and a general `/api/bills` route).

**Headers:**
```
Authorization: Bearer {access_token}
Accept: application/json
```

**Query Parameters (Based on `BillController`):**
-   `status` (string): Filter by bill status (e.g., `paid`, `pending`, `overdue`).
-   `date_from` (date `YYYY-MM-DD`): Filter bills issued from this date.
-   `date_to` (date `YYYY-MM-DD`): Filter bills issued up to this date.
-   `sort_by` (string): Field to sort by (`id`, `issue_date`, `due_date`, `amount`, `status`). Default: `issue_date`.
-   `sort_direction` (string): `asc` or `desc`. Default: `desc`.
-   `per_page` (integer): Number of items per page. Default: 10.
-   `page` (integer): Page number.


**Success Response (200 OK - based on `BillResource`):**
```json

{
    "data": [
        {
            "id": 2,
            "patient_id": 1,
            "amount": 132.95,
            "issue_date": "2024-07-13",
            "due_date": "2025-05-27",
            "status": "paid",
            "notes": null,
            "pdf_link": null,
            "created_at": "2025-05-25T09:52:23+00:00",
            "updated_at": "2025-05-25T09:52:23+00:00",
            "doctor_name": "Dr. Smith 1",
            "doctor_specialty": "Cardiologist",
            "payment_method": "Espèces",
            "services_rendered": [
                {
                    "id": 42,
                    "name": "Analyse sanguine",
                    "quantity": 1,
                    "unit_price": 86.35,
                    "total_price": 86.35
                },
                {
                    "id": 43,
                    "name": "Soin dentaire",
                    "quantity": 2,
                    "unit_price": 23.3,
                    "total_price": 46.6
                }

            ]
        }
         // ... more bills
    ],
    "links": {
        "first": "/?page=1",
        "last": "/?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "/?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "/",
        "per_page": 10,
        "to": 5,
        "total": 5
    }
}
```

#### Frontend (Angular)

