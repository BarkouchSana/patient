export interface Bill {
    id: string;
    billId: string;
    issueDate: string;
    dueDate: string;
    amount: number;
    status: 'Paid' | 'Unpaid' | 'Overdue' | 'Pending';
    notes?: string;
    detailsActionText?: string;
    isPaid?: boolean;
  }