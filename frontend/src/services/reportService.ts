
import type { ClientReportByAge, ClientReportByCity, ClientReportByState } from '../types/report';
import api from './config';

class ReportService {

  async getClientsByCity(): Promise<ClientReportByCity[]> {
    try {
      const response = await api.get('/reports/clients-by-city');
      return response.data;
    } catch (error) {
      console.error('Erro ao buscar clientes por cidade:', error);
      throw error;
    }
  }

  // Método para buscar os clientes agrupados por estado
  async getClientsByState(): Promise<ClientReportByState[]> {
    try {
      const response = await api.get('/reports/clients-by-state');
      return response.data;
    } catch (error) {
      console.error('Erro ao buscar clientes por estado:', error);
      throw error;
    }
  }

  async getClientsByAge(): Promise<ClientReportByAge[]> {
    try {
      const response = await api.get('/reports/clients-by-age');
      return response.data;
    } catch (error) {
      console.error('Erro ao buscar clientes por idade:', error);
      throw error;
    }
  }
}

export const reportService = new ReportService();
