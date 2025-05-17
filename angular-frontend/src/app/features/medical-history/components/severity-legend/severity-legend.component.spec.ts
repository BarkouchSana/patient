import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SeverityLegendComponent } from './severity-legend.component';

describe('SeverityLegendComponent', () => {
  let component: SeverityLegendComponent;
  let fixture: ComponentFixture<SeverityLegendComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [SeverityLegendComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SeverityLegendComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
