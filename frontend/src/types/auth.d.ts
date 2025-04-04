
  export interface LoginResponse {
    token: string;
    user: User;
  }
  
  export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    created_at: string;
    updated_at: string;
  }
  

  export interface LoginData {
    email: string;
    password: string;
  }
  