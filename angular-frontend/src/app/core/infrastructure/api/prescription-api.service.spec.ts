import { TestBed } from '@angular/core/testing';

import { PrescriptionApiService } from './prescription-api.service';

describe('PrescriptionApiService', () => {
  let service: PrescriptionApiService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PrescriptionApiService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
