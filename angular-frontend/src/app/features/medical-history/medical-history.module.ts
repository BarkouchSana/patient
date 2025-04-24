import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { MedicalHistoryRoutingModule } from './medical-history-routing.module';
import { MedicalHistoryComponent } from './medical-history.component';
import { AllergiesComponent } from './components/allergies/allergies.component';
import { SurgeriesComponent } from './components/surgeries/surgeries.component';
import { ChronicDiseasesComponent } from './components/chronic-diseases/chronic-diseases.component';
import { CurrentMedicationsComponent } from './components/current-medications/current-medications.component';


@NgModule({
  declarations: [
    MedicalHistoryComponent,
    AllergiesComponent,
    SurgeriesComponent,
    ChronicDiseasesComponent,
    CurrentMedicationsComponent
  ],
  imports: [
    CommonModule,
    MedicalHistoryRoutingModule
  ]
})
export class MedicalHistoryModule { }
