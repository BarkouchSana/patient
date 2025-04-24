import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ChronicDiseasesComponent } from './chronic-diseases.component';

describe('ChronicDiseasesComponent', () => {
  let component: ChronicDiseasesComponent;
  let fixture: ComponentFixture<ChronicDiseasesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ChronicDiseasesComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ChronicDiseasesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
