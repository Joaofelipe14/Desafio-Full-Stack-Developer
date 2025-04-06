// interfaces/ReportInterfaces.ts

export interface ClientReportByCity {
    city: string;
    total: number;
    percentage: number;
  }
  
  export interface ClientReportByState {
    uf: any;
    state: string;
    total: number;
    percentage: number;
  }
  
  // src/types/report.ts
export interface ClientReportByAge {
    age_range: string;
    total: number;
    percentage: number;
  }