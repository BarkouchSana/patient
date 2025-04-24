import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { GuestAccessComponent } from './guest-access.component';

const routes: Routes = [{ path: '', component: GuestAccessComponent }];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class GuestAccessRoutingModule { }
