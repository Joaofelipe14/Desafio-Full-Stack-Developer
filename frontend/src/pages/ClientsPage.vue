<template>
    <div class="container">
        <h2>Contatos</h2>
        <div class="logout" @click="logout">sair</div>


        <ClientDetails v-if="selectedClient && showClientDetails" :client="selectedClient"
            @close="closeClientDetails" />

        <AlertConfirmModalComponent v-if="showAlertConfirm" @close="handleModalClose" />
        <ClientFormComponent v-if="showClientForm" :client="selectedClient" @close="closeClientForm"
            @success="handleClientSuccess" />

        <div class="card">
            <div class="header-card">
                <div class="input-search">
                    <InputComponent type="search" v-model="inputValue" placeholder="Buscar contato"
                        @input="handleSearch" />
                </div>

                <div class="action-header">
                    <ButtonComponent @click="openClientForm(null)" label="Adicionar contato" :icon="'add'" />
                    <img @click="redirectToReport()" title="Clique para acessar os gráficos" class="icon-report"
                        src="../assets/icons/report.svg" alt="">
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
                    <tr v-if="!loading" v-for="client in clients.data" :key="client.id">
                        <td @click="openClientDetails(client.id)" data-label="Nome" class="name-client">
                            <span class="initial-client">{{ getInitials(client.name) }}</span>
                            {{ client.name }}
                        </td>
                        <td data-label="Email">{{ client.email }}</td>
                        <td data-label="Telefone">{{ client.mobile }}</td>

                        <td class="action-client">
                            <img @click.stop="openClientForm(client.id)" src="../assets/icons/edit.svg" alt="">
                            <img @click.stop="deleteClient(client.id)" src="../assets/icons/trash.svg" alt="">
                        </td>
                    </tr>

                </tbody>
            </table>

            <SpinnerComponent v-if="loading" />


            <div v-if="clients.data.length === 0 && !loading" class="no-contacts active">
                <img src="../assets/image.svg" alt="">
                <h3>Ainda não há contatos.</h3>
                <ButtonComponent label="Adicionar contato" :show-icon="true" @click="openClientForm(null)" />
            </div>

            <PaginationComponent v-if="!loading && clients.data.length > 0" :current-page="clients.current_page"
                :total-pages="clients.last_page" :has-next-page="!!clients.next_page_url"
                :has-previous-page="!!clients.prev_page_url" @page-change="fetchClients" />
        </div>


    </div>
</template>


<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { useRouter } from 'vue-router'
import ButtonComponent from '../components/ButtonComponent.vue'
import InputComponent from '../components/InputComponent.vue'
import PaginationComponent from '../components/PaginationComponent.vue'
import ClientDetails from '../components/ClientDetailsComponent.vue'
import ClientFormComponent from '../components/ClientFormComponent.vue'
import AlertConfirmModalComponent from '../components/AlertConfirmModalComponent.vue'
import AuthService from '../services/authService'
import { ClientService } from '../services/clientService'
import type { Client, PaginatedResponse } from '../types/clients'
import { getInitials } from '../utils/functions'
import SpinnerComponent from '../components/SpinnerComponent.vue'

const router = useRouter()

// Reactive state
const clients = ref<PaginatedResponse<Client>>({
    data: [],
    current_page: 1,
    last_page: 1,
    first_page_url: '',
    next_page_url: null,
    prev_page_url: null,
})

const inputValue = ref('')
const selectedClient = ref<Client | null>(null)
const showClientForm = ref(false)
const loading = ref(false)

const showClientDetails = ref(false)
const showAlertConfirm = ref(false)
const searchTimeout = ref<number | null>(null)
const clientToDeleteId = ref<number | null>(null)

const logout = () => {
    AuthService.logout()
}

const fetchClients = async (page = 1) => {

    loading.value = true;
    try {
        const response = await ClientService.getClients(
            page,
            inputValue.value.trim() || undefined
        )
        loading.value = false;

        clients.value = response
    } catch (error) {
        loading.value = false;

        console.error('Erro ao buscar os clientes:', error)
    }
}

const handleSearch = () => {
    if (searchTimeout.value) {
        clearTimeout(searchTimeout.value)
    }
    searchTimeout.value = setTimeout(() => {
        fetchClients(1)
    }, 500)
}

const openClientDetails = async (clientId: number) => {
    showClientDetails.value = true
    try {
        const client = await ClientService.getClient(clientId)
        selectedClient.value = client
    } catch (error) {
        console.error('Erro ao buscar detalhes do cliente:', error)
    }
}

const closeClientDetails = () => {
    selectedClient.value = null
    showClientDetails.value = false
}

const handleModalClose = (confirmed: boolean) => {
    showAlertConfirm.value = false

    if (confirmed && clientToDeleteId.value) {
        deleteClientConfirmed(clientToDeleteId.value)
    }

    clientToDeleteId.value = null

}

const deleteClientConfirmed = async (id: number) => {
    try {
        await ClientService.deleteClient(id)
        fetchClients(clients.value.current_page)
    } catch (error) {
        console.error('Erro ao excluir cliente:', error)
    }
}
const openClientForm = async (clientId: number | null) => {
    showClientForm.value = true
    if (clientId) {
        try {
            const client = await ClientService.getClient(clientId)
            selectedClient.value = client
        } catch (error) {
            console.error('Erro ao buscar detalhes do cliente:', error)
        }
    } else {
        selectedClient.value = null
    }
}

const deleteClient = (clientId: number | null) => {
    showAlertConfirm.value = true
    clientToDeleteId.value = clientId
    console.log('ID do cliente para deletar:', clientId)
}

const closeClientForm = () => {
    showClientForm.value = false
    selectedClient.value = null
}

const handleClientSuccess = () => {
    showClientForm.value = false
    selectedClient.value = null
    fetchClients(clients.value.current_page)
}

const redirectToReport = () => {
    router.push('/reports')
}

// Lifecycle hooks
onMounted(async () => {
    try {
        
        await fetchClients(1)
    } catch (error) {
        console.error('Erro ao buscar os clientes:', error)
    }
})

onBeforeUnmount(() => {
    if (searchTimeout.value) {
        clearTimeout(searchTimeout.value)
    }
})
</script>

<style scoped>
.logout {
    cursor: pointer;
    top: 10px;
    right: 50%;
    position: absolute;
}

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
}



.header-card {
    display: flex;
    justify-content: space-between;
    padding: 1rem;
    flex-wrap: wrap;
    gap: 10px;
}

.action-header {
    display: flex;
    gap: 16px;
    align-items: center;
}

.input-search {
    width: 250px;
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


.name-client {
    display: flex;
    flex-direction: row;
    align-items: center;
    white-space: nowrap;

}

.row-cliente:hover {
    cursor: pointer;
}

.action-client {
    display: flex;
    flex-direction: row;
    gap: 16px;
    z-index: 1;
    position: relative;
}

.action-client img {
    width: 15px;
    height: 15px;
}

.action-client img:hover {
    transform: scale(1.1);
}

table th {
    padding: 1rem;
    color: #505050;
    text-align: left;
    font-weight: 600;
}

table th {
    width: 100vh;
    position: relative;

}

table th::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: -8px;
    right: -8px;
    height: 1px;
    background-color: var(--mine-shaft-30);
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

/* Esconde o botão de editar */
td:last-child {
    visibility: hidden;
}

/* Mostrar o botão editar quando a linha estiver sendo "hovered" */
tr:hover td:last-child {
    visibility: visible;
}

@media (max-width: 768px) {
    .container {
        padding: 0 15px;
        max-width: 100%;
    }

    .logout {
        right: 15px;
    }

    .card {
        height: auto;
        min-height: 90vh;
        overflow-x: auto;
    }

    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    .header-card {
        flex-direction: column;
    }

    .input-search {
        width: 100%;
    }

    .action-header {
        width: 100%;
        justify-content: space-between;
    }

    .no-contacts {
        margin-top: 100px;
        padding: 20px;
    }

    table th,
    table td {
        padding: 0.75rem;
        font-size: 0.85rem;
    }

    .action-client img {
        width: 12px;
        height: 12px;
    }
}

@media (max-width: 480px) {


    table {
        display: flex;
        flex-direction: column;
    }

    thead {
        display: none;
    }

    tbody tr {
        display: flex;
        flex-direction: column;
        border-bottom: 1px solid #eee;
        padding: 10px 0;
    }

    td {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
    }

    td::before {
        content: attr(data-label);
        font-weight: bold;
        margin-right: auto;
        padding-right: 10px;
        font-style: normal;
        font-weight: 500;
        font-size: 12px;
        line-height: 16px;
        letter-spacing: 0.4px;
        color: var(--mine-shaft-700);
    }




}
</style>
