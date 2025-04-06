import axios from 'axios';
import AuthService from './authService';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
});

api.interceptors.request.use(
  (config) => {
    const token = AuthService.getToken()
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

/**Interceptor para tratamento global de erros**/
api.interceptors.response.use(
  response => response,
  error => {
    if (error.response?.status === 401  && error.response.data.message =='Unauthenticated.') {

      window.alert('Sessão expirada, por favor entre novamente.')
      window.location.href = '/login';
    }
    return Promise.reject(error.response?.data?.message || 'Erro na requisição');
  }
);

export default api;