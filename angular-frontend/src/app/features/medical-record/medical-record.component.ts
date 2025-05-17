import { Component, HostListener, OnInit } from '@angular/core';
import { MedicalHistoryService } from '../../core/services/medical-history.service';

export interface MedicalRecordItem {
  id: string;
  type:  'LabResult' | 'Image' | 'Prescription';
  title: string;
  recordDate: string; // Date affichée sur la carte et dans le modal (e.g., "May 2, 2025")
  doctor?: string;
  summary: string; // Court résumé pour la carte
  details: string; // Détails complets pour le modal
  tagText: string;
  tagClass: string; // Classe CSS pour la couleur du tag

  // Champs spécifiques au type pour le modal
  resultDate?: string; // Pour LabResult
  performedBy?: string; // Pour LabResult
  imageDetails?: string; // Pour Image
  takenBy?: string; // Pour Image
  imageUrl?: string; // Pour Image (placeholder pour l'instant)
  status?: 'active' | 'completed';
}
export interface MedicalHistoryData {
  currentMedicalConditions: string[];
  pastSurgeries: string[];
  chronicDiseases: string[];
  currentMedications: string[];
  allergies: string[];
  vitalSigns?: VitalSignsData;
  lastUpdated: string | Date | null;
}
export interface VitalSign {
  label: string;
  value: string;
  unit: string;
  icon: string; // Classe Font Awesome
}
export interface VitalSignsData {
  lastRecorded: string | Date | null;
  bloodPressure?: VitalSign;
  pulse?: VitalSign;
  temperature?: VitalSign;
  respiratoryRate?: VitalSign;
  oxygenSaturation?: VitalSign;
  weight?: VitalSign;
  height?: VitalSign;
}

interface MedicalHistorySectionConfig {
  key: keyof MedicalHistoryData;
  title: string;
  color: string; // Tailwind color name (e.g., 'status-info', 'accent')
  emptyText: string;
}

@Component({
  selector: 'app-medical-record',
  standalone: false,
  templateUrl: './medical-record.component.html',
  styleUrl: './medical-record.component.css'
})
export class MedicalRecordComponent implements OnInit{
  tabs: string[] = ['MedicalHistory', 'LabResult', 'Image', 'Prescription'];
  activeTab: string = 'MedicalHistory'; // 'All', 'Examinations', 'LabResults', 'Images', 'Prescriptions'
  searchTerm: string = '';

  allRecords: MedicalRecordItem[] = [];
  filteredRecords: MedicalRecordItem[] = [];

  selectedRecord: MedicalRecordItem | null = null;
  isModalOpen: boolean = false;

  isDateFilterOpen: boolean = false;
  dateFrom: string = '';
  dateTo: string = '';
    // Nouvelles propriétés pour le filtre avancé
    isAdvancedFilterOpen: boolean = false;
    availableRecordTypes: string[] = ['LabResult', 'Image', 'Prescription'];
    availableDoctors: string[] = [];
  
    selectedRecordTypes: { [key: string]: boolean } = {};
    selectedDoctors: { [key: string]: boolean } = {};

      // Propriétés pour l'historique médical
  medicalHistory: MedicalHistoryData | null = null;
  isLoadingMedicalHistory: boolean = true;
  medicalHistoryErrorMessage: string | null = null;
  
  constructor(private medicalHistoryService: MedicalHistoryService) { } // Injection du service

  
  

  ngOnInit(): void {
    this.initializeStaticData();
    this.populateAvailableDoctors();
    this.initializeAdvancedFilters();
    this.filterRecords();
    this.loadMedicalHistory();
  }
  initializeStaticData(): void {
    this.allRecords = [
 
      // Lab Results
      {
        id: 'lab1', type: 'LabResult', title: 'Complete Blood Count', recordDate: 'Apr 15, 2025', doctor: 'Dr. Sarah Johnson',
        summary: 'All values within normal range. White blood cell count: 7.5, Red blood cell count: 4.8, Hemoglobin: 14.2, Hematocrit: 42.0%',
        details: 'All values within normal range. White blood cell count: 7.5 x 10^9/L, Red blood cell count: 4.8 x 10^12/L, Hemoglobin: 14.2 g/dL, Hematocrit: 42.0%. No abnormalities detected.',
        tagText: 'Lab Result', tagClass: 'tag-lab', resultDate: 'April 16th, 2025', performedBy: 'Central Laboratory'
      },
      {
        id: 'lab2', type: 'LabResult', title: 'Lipid Panel', recordDate: 'Apr 15, 2025', doctor: 'Dr. Sarah Johnson',
        summary: 'Total Cholesterol: 185 mg/dL, HDL: 55 mg/dL, LDL: 110 mg/dL, Triglycerides: 100 mg/dL.',
        details: 'Total Cholesterol: 185 mg/dL (Desirable), HDL Cholesterol: 55 mg/dL (Good), LDL Cholesterol: 110 mg/dL (Near Optimal), Triglycerides: 100 mg/dL (Normal).',
        tagText: 'Lab Result', tagClass: 'tag-lab', resultDate: 'April 16th, 2025', performedBy: 'Central Laboratory'
      },
      // Images
      {
        id: 'img1', type: 'Image', title: 'Chest X-Ray', recordDate: 'Mar 10, 2025', doctor: 'Dr. Emily Chen',
        summary: 'Standard PA and lateral views of chest. No evidence of acute cardiopulmonary disease.',
        details: 'Standard PA and lateral views of chest. Lungs are clear. Heart size is normal. No evidence of acute cardiopulmonary disease. Minor degenerative changes in the thoracic spine.',
        tagText: 'Medical Image', tagClass: 'tag-image', imageDetails: 'PA and lateral views', takenBy: 'Radiology Department', imageUrl: 'assets/images/round-pneumonia.jpg' // Replace with actual image path or logic
      },
      {
        id: 'img2', type: 'Image', title: 'Right Knee MRI', recordDate: 'Mar 15, 2025', doctor: 'Dr. Emily Chen',
        summary: 'MRI of right knee shows mild meniscus tear in the medial compartment. No evidence of ligament damage or fracture.',
        details: 'MRI of right knee shows mild degenerative fraying and a small radial tear of the posterior horn of the medial meniscus. ACL, PCL, and collateral ligaments are intact. No fracture or dislocation.',
        tagText: 'Medical Image', tagClass: 'tag-image', imageDetails: 'Sagittal view of right knee', takenBy: 'Radiology Department', imageUrl: 'assets/placeholder-image.png'
      },
       // Prescriptions
       {
        id: 'presc1', type: 'Prescription', title: 'Amoxicillin Prescription', recordDate: 'May 2, 2025', doctor: 'Dr. Sarah Johnson',
        summary: 'Amoxicillin 500mg, 3 times daily for 7 days. For treatment of sinus infection.',
        details: 'Amoxicillin 500mg. Take one capsule by mouth three times daily for 7 days. For treatment of acute bacterial sinusitis. Complete the entire course of antibiotics.',
        tagText: 'Prescription', tagClass: 'tag-prescription', status: 'active' // <-- Add status
      },
      {
        id: 'presc2', type: 'Prescription', title: 'Amoxicillin Prescription', recordDate: 'May 2, 2025', doctor: 'Dr. Sarah Johnson',
        summary: 'Doliprane 500mg, 2 times daily for 3 days. For treatment of sinus infection.',
        details: 'Amoxicillin 500mg. Take one capsule by mouth three times daily for 7 days. For treatment of acute bacterial sinusitis. Complete the entire course of antibiotics.',
        tagText: 'Prescription', tagClass: 'tag-prescription', status: 'active' // <-- Add status
      },
      {
        id: 'presc3', type: 'Prescription', title: 'Lisinopril Renewal', recordDate: 'Apr 20, 2025', doctor: 'Dr. Sarah Johnson',
        summary: 'Lisinopril 10mg, once daily. 90-day supply with 3 refills. For blood pressure management.',
        details: 'Lisinopril 10mg. Take one tablet by mouth once daily. 90-day supply with 3 refills. For management of hypertension. Monitor blood pressure regularly.',
        tagText: 'Prescription', tagClass: 'tag-prescription', status: 'completed' // <-- Add status
      }
    ];
  }
  populateAvailableDoctors(): void {
    const doctors = new Set<string>();
    this.allRecords.forEach(record => {
      if (record.doctor) {
        doctors.add(record.doctor);
      }
    });
    this.availableDoctors = Array.from(doctors).sort();
  }

  initializeAdvancedFilters(): void {
    this.availableRecordTypes.forEach(type => this.selectedRecordTypes[type] = false);
    this.availableDoctors.forEach(doc => this.selectedDoctors[doc] = false);
  }
  loadMedicalHistory(): void {
    this.isLoadingMedicalHistory = true;
    const patientId = 1; // Ou récupérez l'ID du patient dynamiquement
    this.medicalHistoryService.getMedicalHistory(patientId).subscribe({
      next: (data) => {
  // Données fictives pour VitalSigns pour l'instant
  const vitalSignsData: VitalSignsData = {
    lastRecorded: data.vitalSigns?.lastRecorded || new Date('2025-05-07T10:00:00Z'), // Exemple de date
    bloodPressure: data.vitalSigns?.bloodPressure || { label: 'Blood Pressure', value: '120/80', unit: 'mmHg', icon: 'fas fa-heartbeat' },
    pulse: data.vitalSigns?.pulse || { label: 'Pulse', value: '72', unit: 'bpm', icon: 'fas fa-pulse' }, // fas fa-pulse est plus spécifique
    temperature: data.vitalSigns?.temperature || { label: 'Temperature', value: '36.7', unit: '°C', icon: 'fas fa-thermometer-half' },
    respiratoryRate: data.vitalSigns?.respiratoryRate || { label: 'Respiratory Rate', value: '16', unit: 'breaths/min', icon: 'fas fa-wind' },
    oxygenSaturation: data.vitalSigns?.oxygenSaturation || { label: 'O₂ Saturation', value: '98', unit: '%', icon: 'fas fa-lungs' },
    weight: data.vitalSigns?.weight || { label: 'Weight', value: '75', unit: 'kg', icon: 'fas fa-weight' },
    height: data.vitalSigns?.height || { label: 'Height', value: '176', unit: 'cm', icon: 'fas fa-ruler-vertical' },
  };

    this.medicalHistory = {
      currentMedicalConditions: data.currentMedicalConditions || [],
      pastSurgeries: data.pastSurgeries || [],
      chronicDiseases: data.chronicDiseases || [],
      currentMedications: data.currentMedications || [],
      allergies: data.allergies || [],
      vitalSigns: vitalSignsData, // LIGNE CORRIGÉE : Assignation de vitalSignsData
      lastUpdated: data.lastUpdated || null,
    };
    this.medicalHistoryErrorMessage = null;
    this.isLoadingMedicalHistory = false;
  },
      error: (err) => {
        console.error('Error fetching medical history:', err);
        this.medicalHistoryErrorMessage = 'Failed to load medical history. Please try again later.';
        this.isLoadingMedicalHistory = false;
      }
    });
  }
  setActiveTab(tabName: string): void {
    this.activeTab = tabName;
    this.closeAllDropdowns();
    this.filterRecords();
  }
  onSearchChange(): void {
    // La recherche ne s'applique que si l'onglet actif n'est pas MedicalHistory
    if (this.activeTab !== 'MedicalHistory') {
      this.filterRecords();
    }
  }
  toggleDateFilter(event: MouseEvent): void {
    event.stopPropagation();
    this.isAdvancedFilterOpen = false; // Ferme l'autre dropdown
    this.isDateFilterOpen = !this.isDateFilterOpen;
  }

  applyDateFilter(): void {
    if (this.activeTab !== 'MedicalHistory') {
      this.filterRecords();
    }
    this.isDateFilterOpen = false;
  }
  clearDateFilter(): void {
    this.dateFrom = '';
    this.dateTo = '';
    if (this.activeTab !== 'MedicalHistory') {
      this.filterRecords();
    }
    this.isDateFilterOpen = false;
  }
  toggleAdvancedFilter(event: MouseEvent): void {
    event.stopPropagation();
    this.isDateFilterOpen = false; // Ferme l'autre dropdown
    this.isAdvancedFilterOpen = !this.isAdvancedFilterOpen;
  }

  applyAdvancedFilters(): void {
    if (this.activeTab !== 'MedicalHistory') {
      this.filterRecords();
    }
    this.isAdvancedFilterOpen = false;
  }
  clearAdvancedFilters(): void {
    this.initializeAdvancedFilters(); 
    if (this.activeTab !== 'MedicalHistory') {
      this.filterRecords();
    }
    this.isAdvancedFilterOpen = false;
  }

  closeAllDropdowns(): void {
    this.isDateFilterOpen = false;
    this.isAdvancedFilterOpen = false;
  }

  @HostListener('document:click', ['$event'])
  onDocumentClick(event: Event): void {
    // Ferme les dropdowns si le clic est à l'extérieur
    const dateFilterButton = document.querySelector('.btn-filter-date');
    const dateDropdown = document.querySelector('.date-filter-dropdown');
    const advancedFilterButton = document.querySelector('.btn-filter-advanced');
    const advancedDropdown = document.querySelector('.advanced-filter-dropdown');

    let clickedInsideDateFilter = false;
    if (dateFilterButton && dateFilterButton.contains(event.target as Node)) clickedInsideDateFilter = true;
    if (dateDropdown && dateDropdown.contains(event.target as Node)) clickedInsideDateFilter = true;

    let clickedInsideAdvancedFilter = false;
    if (advancedFilterButton && advancedFilterButton.contains(event.target as Node)) clickedInsideAdvancedFilter = true;
    if (advancedDropdown && advancedDropdown.contains(event.target as Node)) clickedInsideAdvancedFilter = true;

    if (!clickedInsideDateFilter && !clickedInsideAdvancedFilter) {
      this.closeAllDropdowns();
    }
  }
  filterRecords(): void {
    // Si l'onglet MedicalHistory est actif, on vide filteredRecords et on ne fait rien d'autre ici.
    // L'affichage de l'historique médical est géré par *ngIf dans le template.
    if (this.activeTab === 'MedicalHistory') {
      this.filteredRecords = [];
      return;
    }

    let recordsToDisplay = [...this.allRecords];

    // 1. Filtre par onglet actif (pour les types d'enregistrements)
    recordsToDisplay = recordsToDisplay.filter(record => record.type === this.activeTab);
    
    // 2. Filtre par plage de dates
    if (this.dateFrom) {
      const fromDate = new Date(this.dateFrom);
      fromDate.setHours(0, 0, 0, 0);
      recordsToDisplay = recordsToDisplay.filter(record => {
        const recordDateObj = new Date(record.recordDate);
        return recordDateObj >= fromDate;
      });
    }
    if (this.dateTo) {
      const toDate = new Date(this.dateTo);
      toDate.setHours(23, 59, 59, 999);
      recordsToDisplay = recordsToDisplay.filter(record => {
        const recordDateObj = new Date(record.recordDate);
        return recordDateObj <= toDate;
      });
    }
    
    // 3. Filtre par types d'enregistrements sélectionnés (depuis le dropdown "Filters")
    const activeSelectedTypes = this.availableRecordTypes.filter(type => this.selectedRecordTypes[type]);
    if (activeSelectedTypes.length > 0) {
      recordsToDisplay = recordsToDisplay.filter(record => activeSelectedTypes.includes(record.type));
    }
  
    // 4. Filtre par médecins sélectionnés (depuis le dropdown "Filters")
    const activeSelectedDoctors = this.availableDoctors.filter(doc => this.selectedDoctors[doc]);
    if (activeSelectedDoctors.length > 0) {
      recordsToDisplay = recordsToDisplay.filter(record => record.doctor && activeSelectedDoctors.includes(record.doctor));
    }
    // 5. Filtre par terme de recherche
    if (this.searchTerm) {
      const lowerSearchTerm = this.searchTerm.toLowerCase();
      recordsToDisplay = recordsToDisplay.filter(record =>
        record.title.toLowerCase().includes(lowerSearchTerm) ||
        (record.doctor && record.doctor.toLowerCase().includes(lowerSearchTerm)) ||
        record.summary.toLowerCase().includes(lowerSearchTerm) ||
        record.details.toLowerCase().includes(lowerSearchTerm)
      );
    }
    this.filteredRecords = recordsToDisplay;
  }

   
    openModal(record: MedicalRecordItem): void {
      this.selectedRecord = record;
      this.isModalOpen = true;
      this.closeAllDropdowns();
    }

  closeModal(): void {
    this.isModalOpen = false;
    this.selectedRecord = null;
  }

  downloadRecord(record: MedicalRecordItem | null): void {
    if (record) {
      // Logique de téléchargement à implémenter
      // Par exemple, créer un blob et un lien de téléchargement
      const recordData = JSON.stringify(record, null, 2);
      const blob = new Blob([recordData], { type: 'application/json' });
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = `${record.title.replace(/\s+/g, '_')}_${record.id}.json`; // Nom de fichier suggéré
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      window.URL.revokeObjectURL(url);
      console.log(`Downloading record: ${record.title}`);
      // Ne fermez pas la modale ici, laissez l'utilisateur le faire s'il le souhaite
    }
  }
  exportRecords(): void {
    // Logique d'exportation à implémenter (par exemple, tous les filteredRecords)
    console.log('Exporting records...', this.filteredRecords);
    alert('Exporting records functionality to be implemented.');
  }

  requestRecords(): void {
    // Logique de demande de dossiers à implémenter
    console.log('Requesting new records...');
    alert('Requesting records functionality to be implemented.');
  }

  getRecordIconClass(type: MedicalRecordItem['type']): string {
    switch (type) {
      case 'LabResult':
        return 'fas fa-vial'; // Ou fa-flask
      case 'Image':
        return 'fas fa-x-ray'; // Ou fa-image
      case 'Prescription':
        return 'fas fa-file-prescription';
      default:
        return 'fas fa-file-alt';
    }
  }
  
}
