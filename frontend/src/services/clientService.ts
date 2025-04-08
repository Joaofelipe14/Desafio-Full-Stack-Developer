import type { Client, ClientFormData, PaginatedResponse } from "../types/clients";
import api from "./config";


export const ClientService = {
  async getClients(page: number, search?: string): Promise<PaginatedResponse<Client>> {
    const params = new URLSearchParams();
    params.append('page', page.toString());

    if (search) {
      params.append('search', search);
    }

    const response = await api.get(`/clients?${params.toString()}`);
    return response.data;
  },
  async getClient(id: number): Promise<Client> {
    try {
      const response = await api.get(`/clients/${id}`);
      return response.data;
    } catch (error) {
      throw new Error('Erro ao buscar cliente');
    }
  },

  async createClient(clientData: ClientFormData): Promise<Client> {
    try {
  

      const response = await api.post('/clients', clientData,{
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }); return response.data.data;
    } catch (error) {
      throw new Error('Erro ao criar cliente');
    }
  },

  async updateClient(id: number, clientData: ClientFormData): Promise<Client> {
    try {

      const response = await api.post(`/clients/${id}`, clientData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });
      return response.data.data;
    } catch (error) {
      throw new Error('Erro ao atualizar cliente');
    }
  },

  async deleteClient(id: number): Promise<void> {
    try {
      await api.delete(`/clients/${id}`);
    } catch (error) {
      throw new Error('Erro ao excluir cliente');
    }
  }
};
