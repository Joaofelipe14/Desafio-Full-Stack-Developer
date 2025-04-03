import axios from 'axios';

const apiUrl = import.meta.env.VITE_API_URL;

interface LoginData {
  username: string;
  password: string;
}

interface LoginResponse {
  token: string;
  user: {
    id: string;
    username: string;
  };
}

const login = async (data: LoginData): Promise<LoginResponse> => {
  try {
    const response = await axios.post(`${apiUrl}/login`, data);
    return response.data;
  } catch (error: any) {
    // Aqui você pode personalizar a mensagem de erro
    throw new Error(error.response?.data?.message || 'Erro ao fazer login');
  }
};

export default {
  login,
};
