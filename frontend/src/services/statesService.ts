import type { City } from '../types/city';
import type { State } from '../types/state';

import api from './config';

class LocationService {

   // src/services/locationService.js
    async getStates(): Promise<State[]> {
      try {
        const response = await api.get('/states');
        return response.data; 
      } catch (error) {
        console.error('Erro ao buscar estados:', error);
        throw error;
      }
    }
  

    async getCitiesByState(stateId: number): Promise<City[]> {
        try {
            const response = await api.get<{ data: City[] }>(
                `/states/${stateId}/cities`
            );
            return response.data.data;
        } catch (error) {
            console.error('Error fetching cities:', error);
            throw new Error('Failed to fetch cities');
        }
    }
}

export const locationService = new LocationService();