export interface PaginatedResponse<T> {
    current_page: number;
    data: Client[];
    first_page_url: string;
    last_page: number;
    next_page_url: string | null;
    prev_page_url: string | null;
}
export interface City {
    id: number;
    name: string;
    state_id: number;
    state?: State;  
}

export interface State {
    id: number;
    name: string;
    uf: string;
}

export interface Address {
    id: number;
    address: string | null;
    neighborhood: string | null;
    city_id: number | null;
    city?: City | null;  
}

export interface Client {
    id: number;
    name: string;
    mobile: string;
    email: string;
    birth_date: string;
    url_perfil: string;
    address_id: number;
    created_at: string;
    updated_at: string;
    address?: Address | null;
}
