import type { Client, ClientFormData, PaginatedResponse } from "../types/clients";
import api from "./config";


export const ClientService = {
    async getClients(page: number = 1): Promise<PaginatedResponse<Client>> {
        try {
      const response = await api.get(`/clients?page=${page}`);
      return response.data;
    } catch (error) {
      throw new Error('Erro ao buscar clientes');
    }
  },

  async getClient(id: number): Promise<Client> {
    try {
      const response = await api.get(`/clients/${id}`);
      return response.data;
    } catch (error) {
      throw new Error('Erro ao buscar cliente');
    }
  },

  async createClient(clientData:ClientFormData): Promise<Client> {
    try {
      const response = await api.post('/clients', clientData);
      return response.data.data;
    } catch (error) {
      throw new Error('Erro ao criar cliente');
    }
  },

  async updateClient(id: number, clientData:ClientFormData): Promise<Client> {
    try {
      const response = await api.put(`/clients/${id}`, clientData);
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
