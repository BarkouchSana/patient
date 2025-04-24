import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ScannedScriptsComponent } from './scanned-scripts.component';

describe('ScannedScriptsComponent', () => {
  let component: ScannedScriptsComponent;
  let fixture: ComponentFixture<ScannedScriptsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ScannedScriptsComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ScannedScriptsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
