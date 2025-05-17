import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CurrentMedicalConditionsComponent } from './current-medical-conditions.component';

describe('CurrentMedicalConditionsComponent', () => {
  let component: CurrentMedicalConditionsComponent;
  let fixture: ComponentFixture<CurrentMedicalConditionsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [CurrentMedicalConditionsComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CurrentMedicalConditionsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
