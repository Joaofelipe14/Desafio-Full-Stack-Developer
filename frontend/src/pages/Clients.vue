<template>
    <div class="container">
        <h2>Contatos</h2>

        <div class="card">
            <div class="header-card">
                <InputComponent type="search" v-model="inputValue" placeholder="Buscar contato"/>
                <div class="action-header">
                    <ButtonComponent label="Adicionar contato" :show-icon="true" @click="ButtonAddClient" />
                    <img title="Clique para acessar os gráficos" class="icon-report" src="../assets/icons/report.svg"
                        alt="">
                </div>
            </div>

            <table>
                <thead>
                    <tr class="caption">
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    <tr class="row-cliente" v-for="client in clients.data" :key="client.id">
                        <td class="name-client">
                            <span class="initial-client">{{ getInitials(client.name) }}</span>
                            {{ client.name }}
                        </td>
                        <td>{{ client.email }}</td>
                        <td>{{ client.mobile }}</td>

                        <td class="action-client">
                            <img src="../assets//icons/edit.svg" alt="">
                            <img src="../assets//icons/trash.svg" alt="">

                        </td>

                    </tr>
                </tbody>
            </table>

            <div v-if="clients.data.length == 0" class="no-contacts active">
                <img src="../assets/image.svg" alt="">
                <h3>Ainda não há contatos.</h3>
                <ButtonComponent label="Adicionar contato" :show-icon="true" @click="ButtonAddClient" />

            </div>
        </div>


    </div>
</template>

<script lang="ts">
import ButtonComponent from '../components/ButtonComponent.vue';
import InputComponent from '../components/InputComponent.vue';

export default {
    name: 'Clients',
    data() {
        return {
            //**  Dados mockados que emularão a resposta da API **//
            clients: {
                current_page: 1,
                data: [
                    {
                        id: 1,
                        name: 'Sr. Inácio Barros Caldeira',
                        mobile: '34958610771',
                        email: 'michele.davila@sepulveda.net',
                        birth_date: '1990-04-11',
                        url_perfil: 'https://via.placeholder.com/200x200.png/00aa11?text=people+omnis',
                        address_id: 1,
                        created_at: '2025-04-03T23:07:32.000000Z',
                        updated_at: '2025-04-03T23:07:32.000000Z',
                    },
                    {
                        id: 2,
                        name: 'Mário Eric Carrara',
                        mobile: '18974274755',
                        email: 'wdavila@ferraz.com.br',
                        birth_date: '2007-03-16',
                        url_perfil: 'https://via.placeholder.com/200x200.png/000011?text=people+cumque',
                        address_id: 2,
                        created_at: '2025-04-03T23:07:32.000000Z',
                        updated_at: '2025-04-03T23:07:32.000000Z',
                    },
                    {
                        id: 3,
                        name: 'Srta. Jasmin Esther Bonilha',
                        mobile: '24943707882',
                        email: 'iteles@salgado.com.br',
                        birth_date: '2009-09-13',
                        url_perfil: 'https://via.placeholder.com/200x200.png/006633?text=people+et',
                        address_id: 3,
                        created_at: '2025-04-03T23:07:32.000000Z',
                        updated_at: '2025-04-03T23:07:32.000000Z',
                    },
                    {
                        id: 4,
                        name: 'Marco Arruda Pedrosa Filho',
                        mobile: '22932185531',
                        email: 'vflores@yahoo.com',
                        birth_date: '2012-05-25',
                        url_perfil: 'https://via.placeholder.com/200x200.png/00ccff?text=people+expedita',
                        address_id: 4,
                        created_at: '2025-04-03T23:07:32.000000Z',
                        updated_at: '2025-04-03T23:07:32.000000Z',
                    },
                    {
                        id: 5,
                        name: 'Sr. Edilson Ramos',
                        mobile: '99993468516',
                        email: 'valentin48@r7.com',
                        birth_date: '1985-05-07',
                        url_perfil: 'https://via.placeholder.com/200x200.png/00aabb?text=people+sit',
                        address_id: 5,
                        created_at: '2025-04-03T23:07:32.000000Z',
                        updated_at: '2025-04-03T23:07:32.000000Z',
                    }
                ],
                first_page_url: 'http://127.0.0.1:8000/api/clients?page=1',
                last_page: 2,
                next_page_url: 'http://127.0.0.1:8000/api/clients?page=2',
                prev_page_url: null,
            },
            textValue: "",
            inputValue: "",
        }
    },
    components: {
        ButtonComponent,
        InputComponent
    },
    methods: {
        ButtonAddClient() {
            console.log('botaõ clicadao')
        },
        getInitials(name: string) {
            const names = name.split(" ");
            const initials = names.map(part => part.charAt(0).toUpperCase()).join("");
            return initials.slice(0, 2);
        }
    }
}
</script>

<style scoped>
.container {
    max-width: 930px;
    margin: 20px auto;
}

h2 {
    margin: 1rem 0;
}

.card {
    background-color: white;
    border: 1px #E1E1E1 solid;
    border-radius: 1rem;
    box-shadow: 0px 1px 2px 0px #00000026;
    height: 90vh;
    overflow-x: auto;
}

.header-card {
    display: flex;
    justify-content: space-between;
    padding: 1rem;
    flex-wrap: wrap;
}

.action-header {
    display: flex;
    gap: 16px;
    align-items: center;

}

.icon-report {
    cursor: pointer;
}

.icon-report:hover {
    cursor: pointer;
    transform: scale(1.1);
}



table {
    width: 100%;
    border-spacing: 0;
    padding: 8px;
}

.no-contacts {
    justify-content: center;
    align-items: center;
    text-align: center;
    height: 200px;
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-top: 250px;
}

.no-contacts img {
    margin-bottom: 10px;
}

.initial-client {
    width: 2rem;
    height: 2rem;
    background-color: var(--persian-blue-10);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin-right: 1rem;
    text-transform: uppercase;
    color: var(--persian-blue-800);
    font-weight: 500;
    min-width: 32px;
    
}

.name-client {
    display: flex;
    flex-direction: row;
    align-items: center;
    white-space: nowrap;
    
}

.row-cliente:hover {}

.action-client{
    display: flex;
    flex-direction: row;
    gap: 16px;
}

.action-client img{
    width: 15px;
    height: 15px;
}
table th {
    padding: 1rem;
    color: #505050;
    text-align: left;
    font-weight: 600;
}

table th {
    border-bottom: 1px solid var(--mine-shaft-30);
    width: 100vh;
    ;

}

td {
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 18px;
    color: var(--mine-shaft-700);
}

table td {
    padding: 1rem;
    border-collapse: collapse;
    cursor: pointer;
    word-break: keep-all;
}


table tbody tr:hover {
    background-color: var(--mine-shaft-10);
    border-radius: 20px !important;
    transition: ease-in-out 0.3s;

}



th:nth-child(1),
td:nth-child(1) {
    width: 40.86%;
}

th:nth-child(2),
td:nth-child(2) {
    width: 30.48%;
}

th:nth-child(3),
td:nth-child(3) {
    width: 19.78%;
}

th:nth-child(4),
td:nth-child(4) {
    width: 7.53%;
}

/* Esconde o botão de editar */
td:last-child {
    visibility: hidden;
}

/* Mostrar o botão editar quando a linha estiver sendo "hovered" */
tr:hover td:last-child {
    visibility: visible;
}
</style>
