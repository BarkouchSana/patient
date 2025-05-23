import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PrescriptionListComponent } from './prescription-list.component';

describe('PrescriptionListComponent', () => {
  let component: PrescriptionListComponent;
  let fixture: ComponentFixture<PrescriptionListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [PrescriptionListComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(PrescriptionListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
