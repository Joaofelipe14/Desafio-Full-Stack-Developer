export interface PaginatedResponse<T> {
    current_page: number;
    data: Client[];
    first_page_url: string;
    last_page: number;
    next_page_url: string | null;
    prev_page_url: string | null;
}

export interface Address {
    id: number;
    address: string | null;
    neighborhood: string | null;
    city_id: number | null;
    city?: City | null;
}

export interface Client {
    city_id: any;
    neighborhood: string;
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

export interface ClientFormData {
    id?: number;
    name: string;
    mobile: string;
    email: string;
    birth_date: string;
    city_id: number | null;
    address: string | null;
    neighborhood: string | null;
    city_id: number | null;
    avatar?: File | null;
    url_perfil?: string;
}
