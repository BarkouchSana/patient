import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { MedicalHistoryRoutingModule } from './medical-history-routing.module';
import { MedicalHistoryComponent } from './medical-history.component';
import { AllergiesComponent } from './components/allergies/allergies.component';
import { SurgeriesComponent } from './components/surgeries/surgeries.component';
import { ChronicDiseasesComponent } from './components/chronic-diseases/chronic-diseases.component';
import { CurrentMedicationsComponent } from './components/current-medications/current-medications.component';
import { MedicalHistoryOverviewComponent } from './components/medical-history-overview/medical-history-overview.component';
import { SeverityLegendComponent } from './components/severity-legend/severity-legend.component';
import { CurrentMedicalConditionsComponent } from './components/current-medical-conditions/current-medical-conditions.component';
import { Router, RouterModule } from '@angular/router';
import { VitalSignsComponent } from './components/vital-signs/vital-signs.component';
import { FormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    MedicalHistoryComponent,
    AllergiesComponent,
    SurgeriesComponent,
    ChronicDiseasesComponent,
    CurrentMedicationsComponent,
    MedicalHistoryOverviewComponent,
    SeverityLegendComponent,
    CurrentMedicalConditionsComponent,
    VitalSignsComponent
  ],
  imports: [
    CommonModule,
    RouterModule,
    FormsModule,
    MedicalHistoryRoutingModule
  ]
})
export class MedicalHistoryModule { }
