import { Component, OnInit, OnDestroy } from '@angular/core';
import { Subscription } from 'rxjs';
// Importer le Router si vous prévoyez de naviguer vers une page de graphique dédiée
// import { Router } from '@angular/router'; 
// Importer un service pour un Modal si vous utilisez des modaux pour les graphiques
// import { ModalService } from 'src/app/core/services/modal.service';
// import { ChartModalComponent } from './chart-modal/chart-modal.component'; // Exemple de composant modal

interface VitalSignReading {
  id: string;
  patientId: string;
  date: Date;
  type: 'BloodPressure' | 'HeartRate' | 'Temperature' | 'Weight' | 'Height' | 'BMI' | 'BloodSugar' | 'OxygenSaturation' | 'RespiratoryRate';
  value1: string | number;
  value2?: string | number;
  unit: string;
  notes?: string;
}

interface DisplayedVitalSign {
  label: string;
  value: string;
  unit?: string;
  iconClass?: string;
  type: VitalSignReading['type'] | 'Combined'; // 'Combined' est gardé pour la flexibilité de la méthode viewChart même si non généré pour l'affichage direct
}

// Configuration pour les types de signes vitaux à afficher
const VITAL_CONFIG_PATIENT_VIEW = [
  { type: 'BloodPressure' as VitalSignReading['type'], label: 'Blood Pressure', unit: 'mmHg', icon: 'fas fa-heartbeat' },
  { type: 'HeartRate' as VitalSignReading['type'], label: 'Pulse', unit: 'bpm', icon: 'fas fa-heart-pulse' },
  { type: 'Temperature' as VitalSignReading['type'], label: 'Temperature', unit: '°C', icon: 'fas fa-thermometer-half' },
  { type: 'RespiratoryRate' as VitalSignReading['type'], label: 'Respiratory Rate', unit: 'breaths/min', icon: 'fas fa-wind' },
  { type: 'OxygenSaturation' as VitalSignReading['type'], label: 'O₂ Saturation', unit: '%', icon: 'fas fa-lungs' },
  { type: 'Weight' as VitalSignReading['type'], label: 'Weight', unit: 'kg', icon: 'fas fa-weight-scale' },
  { type: 'Height' as VitalSignReading['type'], label: 'Height', unit: 'cm', icon: 'fas fa-ruler-vertical' },
];

@Component({
  selector: 'app-vital-signs',
  templateUrl: './vital-signs.component.html',
  standalone: false,
  styleUrls: ['./vital-signs.component.css']
})
export class VitalSignsComponent implements OnInit, OnDestroy {
  latestVitalsForDisplay: DisplayedVitalSign[] = [];
  lastRecordedDate: Date | null = null;
  isLoading: boolean = true;

  private rawPatientReadings: VitalSignReading[] = [
    { id: 'vs1', patientId: 'patient123', date: new Date('2025-05-07T08:00:00'), type: 'BloodPressure', value1: '120', value2: '80', unit: 'mmHg' },
    { id: 'vs1b', patientId: 'patient123', date: new Date('2025-04-15T09:00:00'), type: 'BloodPressure', value1: '122', value2: '78', unit: 'mmHg' },
    { id: 'vs1c', patientId: 'patient123', date: new Date('2025-03-10T10:00:00'), type: 'BloodPressure', value1: '118', value2: '75', unit: 'mmHg' },
    { id: 'vs1d', patientId: 'patient123', date: new Date('2024-06-01T11:00:00'), type: 'BloodPressure', value1: '125', value2: '82', unit: 'mmHg' },

    { id: 'vs2', patientId: 'patient123', date: new Date('2025-05-07T08:00:00'), type: 'HeartRate', value1: '72', unit: 'bpm' },
    { id: 'vs2b', patientId: 'patient123', date: new Date('2025-04-20T08:05:00'), type: 'HeartRate', value1: '68', unit: 'bpm' },
    { id: 'vs2c', patientId: 'patient123', date: new Date('2025-02-10T08:10:00'), type: 'HeartRate', value1: '75', unit: 'bpm' },

    { id: 'vs3', patientId: 'patient123', date: new Date('2025-05-07T08:00:00'), type: 'Temperature', value1: '36.7', unit: '°C' },
    { id: 'vs3b', patientId: 'patient123', date: new Date('2025-04-20T08:05:00'), type: 'Temperature', value1: '36.5', unit: '°C' },

    { id: 'vs4', patientId: 'patient123', date: new Date('2025-05-06T10:00:00'), type: 'RespiratoryRate', value1: '16', unit: 'breaths/min' },
    { id: 'vs5', patientId: 'patient123', date: new Date('2025-05-05T11:00:00'), type: 'OxygenSaturation', value1: '98', unit: '%' },

    { id: 'vs6', patientId: 'patient123', date: new Date('2025-05-04T09:00:00'), type: 'Weight', value1: '75', unit: 'kg' },
    { id: 'vs6b', patientId: 'patient123', date: new Date('2025-03-01T09:00:00'), type: 'Weight', value1: '74.5', unit: 'kg' },
    { id: 'vs6c', patientId: 'patient123', date: new Date('2025-01-12T09:00:00'), type: 'Weight', value1: '73.2', unit: 'kg' },

    { id: 'vs7', patientId: 'patient123', date: new Date('2025-05-04T09:00:00'), type: 'Height', value1: '176', unit: 'cm' },
   ];

  constructor(
    // private router: Router,
    // private modalService: ModalService 
  ) { }

  ngOnInit(): void {
    this.isLoading = true;
    // Simuler un appel de service pour charger this.rawPatientReadings
    // this.patientVitalSignsService.getAllReadingsForLastYear(this.currentPatientId).subscribe(allReadings => {
    //   this.rawPatientReadings = allReadings; // S'assurer que rawPatientReadings contient les données pour la période souhaitée
    //   this.processVitalSignsForDisplay(allReadings);
    //   this.isLoading = false;
    // });
    this.processVitalSignsForDisplay(this.rawPatientReadings);
    this.isLoading = false;
  }

  processVitalSignsForDisplay(readings: VitalSignReading[]): void {
    const processedVitals: DisplayedVitalSign[] = [];
    let overallMostRecentDate: Date | null = null;

    const sortedReadings = [...readings].sort((a, b) => new Date(b.date).getTime() - new Date(a.date).getTime());

    VITAL_CONFIG_PATIENT_VIEW.forEach(config => {
      const mostRecentReadingForType = sortedReadings.find(r => r.type === config.type);
      let displayValue = "N/A";
      let unit = config.unit; // Unité par défaut de la configuration

      if (mostRecentReadingForType) {
        if (mostRecentReadingForType.type === 'BloodPressure') {
          displayValue = `${mostRecentReadingForType.value1}/${mostRecentReadingForType.value2}`;
        } else {
          displayValue = `${mostRecentReadingForType.value1}`;
        }
        unit = mostRecentReadingForType.unit; // Utiliser l'unité de la lecture réelle
        if (!overallMostRecentDate || new Date(mostRecentReadingForType.date) > overallMostRecentDate) {
          overallMostRecentDate = new Date(mostRecentReadingForType.date);
        }
      }
      processedVitals.push({
        label: config.label,
        value: displayValue,
        unit: displayValue !== "N/A" ? unit : undefined,
        type: config.type, // Sera VitalSignReading['type'] car 'Combined' n'est pas dans VITAL_CONFIG_PATIENT_VIEW
        iconClass: config.icon
      });
    });

    this.latestVitalsForDisplay = processedVitals;
    this.lastRecordedDate = overallMostRecentDate;
  }

  viewChart(vitalType: VitalSignReading['type'] | 'Combined', vitalLabel: string): void {
    if (vitalType === 'Combined') {
      console.log("L'affichage de graphiques pour les types combinés n'est pas géré pour les clics sur carte individuelle.");
      return;
    }
    if (vitalType === 'Height') {
        console.log("Un graphique pour la taille sur une période n'est généralement pas affiché. Aucune action.");
        return;
    }

    console.log(`Préparation du graphique pour: ${vitalLabel} (${vitalType})`);

    const oneYearAgo = new Date();
    oneYearAgo.setFullYear(oneYearAgo.getFullYear() - 1);

    const chartDataRaw = this.rawPatientReadings
      .filter(r => r.type === vitalType && new Date(r.date) >= oneYearAgo)
      .sort((a, b) => new Date(a.date).getTime() - new Date(b.date).getTime());

    if (chartDataRaw.length === 0) {
      console.log(`Aucune donnée pour ${vitalLabel} sur la dernière année.`);
      // Ici, vous pourriez ouvrir un modal avec un message "Aucune donnée disponible"
      // Exemple: this.modalService.open(ChartModalComponent, { data: { title: `${vitalLabel} (Dernière Année)`, chartData: [], message: 'Aucune donnée disponible pour la dernière année.' }});
      return;
    }
    
    let preparedChartData;
    const chartTitle = `${vitalLabel} (Dernière Année)`;

    if (vitalType === 'BloodPressure') {
      preparedChartData = [
        {
          name: 'Systolique',
          series: chartDataRaw.map(r => ({ name: new Date(r.date), value: Number(r.value1) }))
        },
        {
          name: 'Diastolique',
          series: chartDataRaw.map(r => ({ name: new Date(r.date), value: Number(r.value2) }))
        }
      ];
    } else {
      preparedChartData = [
        {
          name: vitalLabel,
          series: chartDataRaw.map(r => ({ name: new Date(r.date), value: Number(r.value1) }))
        }
      ];
    }

    console.log("Données préparées pour le graphique:", preparedChartData);
    console.log("Titre du graphique:", chartTitle);

    // ÉTAPE SUIVANTE : Intégrer une bibliothèque de graphiques et afficher ces données
    // Exemple avec un service de modal (à créer) et un composant de modal pour le graphique (à créer) :
    // this.modalService.open(ChartModalComponent, { 
    //   data: { 
    //     title: chartTitle, 
    //     chartData: preparedChartData,
    //     isBloodPressure: vitalType === 'BloodPressure' // Pour aider le composant de graphique à savoir comment rendre
    //   },
    //   width: '800px' 
    // });
    
    // Ou naviguer vers une route de graphique dédiée:
    // this.router.navigate(['/medical-history/chart', vitalType], { state: { chartData: preparedChartData, title: chartTitle, isBloodPressure: vitalType === 'BloodPressure' } });
  }

  ngOnDestroy(): void {
    // Nettoyer les souscriptions si nécessaire
    // if (this.patientSubscription) {
    //   this.patientSubscription.unsubscribe();
    // }
  }
}