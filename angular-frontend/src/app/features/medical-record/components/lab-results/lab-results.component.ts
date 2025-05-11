import { Component, OnInit  } from '@angular/core';

@Component({
  selector: 'app-lab-results',
  standalone: false,
  templateUrl: './lab-results.component.html',
  styleUrl: './lab-results.component.css'
})
export class LabResultsComponent implements OnInit {
  labResults = [
    {
      id: 'LR001',
      date: '2025-04-10',
      testName: 'HbA1c',
      result: '6.2%',
      referenceRange: '<5.7%',
      interpretation: 'Indicates good diabetes control'
    },
    {
      id: 'LR002',
      date: '2025-04-10',
      testName: 'Blood Pressure',
      result: '138/85 mmHg',
      referenceRange: '<120/80 mmHg',
      interpretation: 'Slightly elevated'
    },
    {
      id: 'LR003',
      date: '2025-03-15',
      testName: 'Lipid Panel',
      result: 'LDL: 110 mg/dL',
      referenceRange: '<100 mg/dL',
      interpretation: 'Slightly elevated LDL cholesterol'
    },
    {
      id: 'LR004',
      date: '2025-02-20',
      testName: 'Kidney Function',
      result: 'eGFR: 85 mL/min',
      referenceRange: '>90 mL/min',
      interpretation: 'Mild reduction in kidney function'
    }
  ];
  constructor() {}

  ngOnInit(): void {}
}
