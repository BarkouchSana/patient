import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GeneralRecordsComponent } from './general-records.component';

describe('GeneralRecordsComponent', () => {
  let component: GeneralRecordsComponent;
  let fixture: ComponentFixture<GeneralRecordsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [GeneralRecordsComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(GeneralRecordsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
