import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { MedicalHistoryComponent } from './medical-history.component';
import { MedicalHistoryOverviewComponent } from './components/medical-history-overview/medical-history-overview.component';
import { VitalSignsComponent } from './components/vital-signs/vital-signs.component';

const routes: Routes = [
  {
     path: '',
      component: MedicalHistoryComponent,
      children: [
        { path: '', redirectTo: 'overview', pathMatch: 'full' },
        { path: 'overview', component: MedicalHistoryOverviewComponent },
        // { path: 'timeline', component: TimelineComponent }, // Route pour la chronologie
        { path: 'vital-signs', component: VitalSignsComponent } // Nouvelle route pour les signes vitaux
   
      ]
    
    
    }];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class MedicalHistoryRoutingModule { }
