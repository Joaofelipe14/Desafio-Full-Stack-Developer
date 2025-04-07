import api from './config';

class TwilioService {
  async makeCall(from: string): Promise<any> { 
    try {
      const response = await api.post('/make-call', {
        from: from
      });
      return response.data;
    } catch (error) {
      console.error('Erro ao realizar chamada:', error);
      throw error;
    }
  }
}

export const twilioService = new TwilioService();