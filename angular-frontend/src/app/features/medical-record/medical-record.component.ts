import { Component, HostListener, OnInit } from '@angular/core';

export interface MedicalRecordItem {
  id: string;
  type: 'Examination' | 'LabResult' | 'Image' | 'Prescription';
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
}


@Component({
  selector: 'app-medical-record',
  standalone: false,
  templateUrl: './medical-record.component.html',
  styleUrl: './medical-record.component.css'
})
export class MedicalRecordComponent implements OnInit{
 
  activeTab: string = 'All'; // 'All', 'Examinations', 'LabResults', 'Images', 'Prescriptions'
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
    availableRecordTypes: string[] = ['Examination', 'LabResult', 'Image', 'Prescription'];
    availableDoctors: string[] = [];
  
    selectedRecordTypes: { [key: string]: boolean } = {};
    selectedDoctors: { [key: string]: boolean } = {};
  
  constructor() { }

  ngOnInit(): void {
    this.initializeStaticData();
    this.populateAvailableDoctors();
    this.initializeAdvancedFilters();
    this.filterRecords();
  }
  initializeStaticData(): void {
    this.allRecords = [
      // Examinations
      {
        id: 'exam1', type: 'Examination', title: 'Annual Physical Examination', recordDate: 'Apr 12, 2025', doctor: 'Dr. Sarah Johnson',
        summary: 'Routine annual physical examination. Blood pressure: 120/80, Heart rate: 72 bpm, Temperature: 98.6°F. No significant findings.',
        details: 'Routine annual physical examination. Blood pressure: 120/80, Heart rate: 72 bpm, Temperature: 98.6°F. No significant findings. Patient advised to continue healthy lifestyle.',
        tagText: 'Examination', tagClass: 'tag-examination'
      },
      {
        id: 'exam2', type: 'Examination', title: 'Dermatology Consultation', recordDate: 'Feb 5, 2025', doctor: 'Dr. James Wilson',
        summary: 'Consultation for skin rash on arms. Diagnosed as contact dermatitis. Prescription provided.',
        details: 'Patient presented with itchy red rash on both forearms, consistent with contact dermatitis. Advised to avoid suspected allergens and prescribed a topical corticosteroid cream.',
        tagText: 'Examination', tagClass: 'tag-examination'
      },
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
        tagText: 'Prescription', tagClass: 'tag-prescription'
      },
      {
        id: 'presc2', type: 'Prescription', title: 'Lisinopril Renewal', recordDate: 'Apr 20, 2025', doctor: 'Dr. Sarah Johnson',
        summary: 'Lisinopril 10mg, once daily. 90-day supply with 3 refills. For blood pressure management.',
        details: 'Lisinopril 10mg. Take one tablet by mouth once daily. 90-day supply with 3 refills. For management of hypertension. Monitor blood pressure regularly.',
        tagText: 'Prescription', tagClass: 'tag-prescription'
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
  setActiveTab(tabName: string): void {
    this.activeTab = tabName;
    this.closeAllDropdowns();
    this.filterRecords();
  }

  onSearchChange(): void {
    this.filterRecords();
  }
  toggleDateFilter(event: MouseEvent): void {
    event.stopPropagation();
    this.isAdvancedFilterOpen = false; // Ferme l'autre dropdown
    this.isDateFilterOpen = !this.isDateFilterOpen;
  }

  applyDateFilter(): void {
    this.filterRecords();
    this.isDateFilterOpen = false;
  }
  clearDateFilter(): void {
    this.dateFrom = '';
    this.dateTo = '';
    this.filterRecords();
    this.isDateFilterOpen = false;
  }
  toggleAdvancedFilter(event: MouseEvent): void {
    event.stopPropagation();
    this.isDateFilterOpen = false; // Ferme l'autre dropdown
    this.isAdvancedFilterOpen = !this.isAdvancedFilterOpen;
  }

  applyAdvancedFilters(): void {
    this.filterRecords();
    this.isAdvancedFilterOpen = false;
  }
  clearAdvancedFilters(): void {
    this.initializeAdvancedFilters(); // Réinitialise les sélections
    this.filterRecords();
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
    let recordsToDisplay = [...this.allRecords];

    // 1. Filtre par onglet actif (si ce n'est pas 'All')
    if (this.activeTab !== 'All') {
      recordsToDisplay = recordsToDisplay.filter(record => record.type === this.activeTab);
    }
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
      case 'Examination':
        return 'fas fa-stethoscope'; // Ou fa-file-medical-alt
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
