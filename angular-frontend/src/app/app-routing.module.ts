import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LayoutComponent } from './core/layout/layout/layout.component';
const routes: Routes = [
  {
    path: '',
    component: LayoutComponent, // Utilise le layout pour les routes principales
    children: [
      { path: 'dashboard', loadChildren: () => import('./features/dashboard/dashboard.module').then(m => m.DashboardModule) },
      { path: 'profile', loadChildren: () => import('./features/profile/profile.module').then(m => m.ProfileModule) },
      { path: 'medical-history', loadChildren: () => import('./features/medical-history/medical-history.module').then(m => m.MedicalHistoryModule) },
      { path: 'appointments', loadChildren: () => import('./features/appointments/appointments.module').then(m => m.AppointmentsModule) },
      { path: 'prescriptions', loadChildren: () => import('./features/prescriptions/prescriptions.module').then(m => m.PrescriptionsModule) },
      { path: 'medical-record', loadChildren: () => import('./features/medical-record/medical-record.module').then(m => m.MedicalRecordModule) },
      { path: 'reminders', loadChildren: () => import('./features/reminders/reminders.module').then(m => m.RemindersModule) },
      { path: 'chat', loadChildren: () => import('./features/chat/chat.module').then(m => m.ChatModule) },
      { path: 'guest-access', loadChildren: () => import('./features/guest-access/guest-access.module').then(m => m.GuestAccessModule) },
      { path: 'bills', loadChildren: () => import('./features/bills/bills.module').then(m => m.BillsModule) },
      { path: '', redirectTo: 'dashboard', pathMatch: 'full' },
    ]
  },
  { path: '**', redirectTo: '' } // Redirection pour les routes inconnues
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
