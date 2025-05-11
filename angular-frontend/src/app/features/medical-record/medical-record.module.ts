import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { MedicalRecordRoutingModule } from './medical-record-routing.module';
import { MedicalRecordComponent } from './medical-record.component';
import { LabResultsComponent } from './components/lab-results/lab-results.component';
import { ScannedScriptsComponent } from './components/scanned-scripts/scanned-scripts.component';

import { MedicalImagesComponent } from './components/medical-images/medical-images.component';
import { GeneralRecordsComponent } from './components/general-records/general-records.component';
import { AiAnalysisComponent } from './components/ai-analysis/ai-analysis.component';
import { TreatmentsComponent } from './components/treatments/treatments.component';
import { FormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    MedicalRecordComponent,
    LabResultsComponent,
    ScannedScriptsComponent,
     
    MedicalImagesComponent,
    GeneralRecordsComponent,
    AiAnalysisComponent,
    TreatmentsComponent
  ],
  imports: [
    CommonModule,
    MedicalRecordRoutingModule,
    FormsModule
  ]
})
export class MedicalRecordModule { }
