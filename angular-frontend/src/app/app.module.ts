import { NgModule, LOCALE_ID } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LayoutModule } from './core/layout/layout/layout.module';
import { ReactiveFormsModule } from '@angular/forms';
import { ProfileComponent } from './features/profile/profile.component';
import { HttpClientModule } from '@angular/common/http';
// Import pour la localisation
import { registerLocaleData } from '@angular/common';
import localeFr from '@angular/common/locales/fr';

// Enregistrer les données de la locale française
registerLocaleData(localeFr, 'fr-FR');
@NgModule({
  declarations: [
    AppComponent 
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    LayoutModule,
    ReactiveFormsModule,
    HttpClientModule
  ],
  providers: [
    // Définir la locale par défaut pour les pipes
    { provide: LOCALE_ID, useValue: 'fr-FR' }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
