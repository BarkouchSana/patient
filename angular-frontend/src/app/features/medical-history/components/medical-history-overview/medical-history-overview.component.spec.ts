import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MedicalHistoryOverviewComponent } from './medical-history-overview.component';

describe('MedicalHistoryOverviewComponent', () => {
  let component: MedicalHistoryOverviewComponent;
  let fixture: ComponentFixture<MedicalHistoryOverviewComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [MedicalHistoryOverviewComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MedicalHistoryOverviewComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
