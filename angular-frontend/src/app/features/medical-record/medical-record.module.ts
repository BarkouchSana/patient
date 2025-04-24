import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { MedicalRecordRoutingModule } from './medical-record-routing.module';
import { MedicalRecordComponent } from './medical-record.component';
import { LabResultsComponent } from './components/lab-results/lab-results.component';
import { ScannedScriptsComponent } from './components/scanned-scripts/scanned-scripts.component';
import { LabTestsComponent } from './components/lab-tests/lab-tests.component';
import { MedicalImagesComponent } from './components/medical-images/medical-images.component';
import { GeneralRecordsComponent } from './components/general-records/general-records.component';
import { AiAnalysisComponent } from './components/ai-analysis/ai-analysis.component';


@NgModule({
  declarations: [
    MedicalRecordComponent,
    LabResultsComponent,
    ScannedScriptsComponent,
    LabTestsComponent,
    MedicalImagesComponent,
    GeneralRecordsComponent,
    AiAnalysisComponent
  ],
  imports: [
    CommonModule,
    MedicalRecordRoutingModule
  ]
})
export class MedicalRecordModule { }
