import axios from 'axios';
import type { LoginData, LoginResponse } from '../types/auth';
const apiUrl = import.meta.env.VITE_API_URL;


const login = async (data: LoginData): Promise<LoginResponse> => {
  try {
    const response = await axios.post(`${apiUrl}/login`, data);
    return response.data;
  } catch (error: any) {
    throw new Error(error.response?.data?.message || 'Erro ao fazer login');
  }
};

export default {
  login,
};
