import api from './config';
import type { LoginData, LoginResponse } from '../types/auth';

// Constantes
const API_URL = import.meta.env.VITE_API_URL;

export const AuthService = {
  /**
   * Login normal usando credenciais
   */
  async login(data: LoginData): Promise<LoginResponse> {
    try {
      const response = await api.post('/login', data);
      this.saveToken(response.data.token);

      return response.data;
    } catch (error) {
      throw new Error('Erro ao fazer login');
    }
  },

  /**
   * Inicia o fluxo de login com Huggy em uma nova janela
   */
  async loginWithHuggy(): Promise<Window | null> {
    const authUrl = `${API_URL}huggy/auth`;
    const windowFeatures = "width=800,height=600,scrollbars=yes";

    return window.open(authUrl, "_blank", windowFeatures);
  },

  /**
   * Monitora a janela de autenticação para detectar quando for fechada
   * @param authWindow 
   * @param onSuccess 
   */
  monitorAuthWindow(authWindow: Window | null, onSuccess: (token: string) => void): void {
    if (!authWindow) return;

    const interval = setInterval(() => {
      try {
        if (authWindow.closed) {
          clearInterval(interval);

          const token = this.getToken();
          if (token) {
            onSuccess(token);
          }
        }
      } catch (error) {
        clearInterval(interval);
        console.error('Erro ao monitorar janela:', error);
      }
    }, 1000);
  },

  /**
   * Processa o callback de autenticação do Huggy
   * @param token 
   */
  processHuggyCallback(token: string): void {
    this.saveToken(token);

    if (window.opener) {
      window.opener.postMessage({ token }, window.location.origin);
      setTimeout(() => window.close(), 500);
    }
  },

  saveToken(token: string): void {
    localStorage.setItem(import.meta.env.VITE_AUTH_TOKEN_KEY, token);
  },

  getToken(): string | null {
    return localStorage.getItem(import.meta.env.VITE_AUTH_TOKEN_KEY);
  },

  async isAuthenticated(): Promise<boolean> {
    if (!this.getToken()) {
      return false;
    }

    try {
      await api.post('/me');
      return true;
    } catch (error) {
      return false;
    }
  },
  /**
   * Realiza logout
   */
  async logout(): Promise<void> {
    try {
      await api.post('/logout');
    } catch (error) {
      console.error('Erro no logout:', error);
    } finally {
      localStorage.removeItem(import.meta.env.VITE_AUTH_TOKEN_KEY);
      window.location.href = '/login';
    }
  },

  /**
   * Extrai parâmetros da URL
   */
  getQueryParameter(name: string): string | null {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
  }
};

export default AuthService;