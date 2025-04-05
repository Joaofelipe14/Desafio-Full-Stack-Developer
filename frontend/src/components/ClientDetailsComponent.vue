<template>
    <div class="modal" @click.self="close">
        <div class="modal-content">
            <div class="header-modal">

                <div class="header-name">
                    <span class="initial-client">{{ getInitials(client.name) }}</span>
                    <h2>{{ client.name }}</h2>
                </div>

                <div class="header-actions">
                    <img src="../assets/icons/edit.svg" alt="">
                    <img src="../assets/icons/trash.svg" alt="">
                    <img @click="close" src="../assets/icons/close.svg" alt="">
                </div>

            </div>

            <div class="content-modal ">
                <div class="info-line ">
                    <span>Email:</span>
                    <p>{{ client.email }}</p>
                </div>
                <div class="info-line">
                    <span>Endereço:</span>
                    <p>{{ client.address?.address || 'Endereço não disponível' }}</p>
                </div>
                <div class="info-line">
                    <span>Bairro:</span>
                    <p>{{ client.address?.neighborhood || 'Bairro não disponível' }}</p>
                </div>
                <div class="info-line">
                    <span>Cidade:</span>
                    <p>{{ client.address?.city?.name || 'Cidade não disponível' }}</p>
                </div>
                <div class="info-line">
                    <span>Estado:</span>
                    <p>{{ client.address?.city?.state?.name || 'Estado não disponível' }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import type { Client } from '../types/clients';
import { getInitials } from '../utils/functions'


export default {
    name: 'ClientDetails',
    props: {
        client: {
            type: Object as () => Client,
            required: true
        }
    },
    methods: {
        close() {
            this.$emit('close');
        },
        getInitials
    }

};

</script>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    max-width: 610px;
    width: 100%;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}


.header-modal {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    flex-direction: row;
    margin-bottom: 20px;
}

.header-name {
    display: flex;
    flex-direction: row;
    gap: 5px;
}

.header-actions {
    display: flex;
    flex-direction: row;
    gap: 25px;
    align-items: center;
}


.header-actions img {
    width: 15px;
    height: 15px;
}

.header-actions img:hover {
    transform: scale(1.1);
    cursor: pointer;
}

.content-modal {
    border-top: 1px solid var(--mine-shaft-30);
    padding: 24px;
    gap: 24px;
    display: flex;
    flex-direction: column;

}

.info-line {
    display: flex;
    justify-content: flex-start;
    gap: 24px;

}

.info-line span {
    font-family: 'Roboto';
    font-style: normal;
    font-weight: 500;
    font-size: 12px;
    line-height: 16px;
    letter-spacing: 0.4px;
    color: var(--mine-shaft-100);
    text-align: right;
    min-width: 57px;

}

p{
    font-weight: 400;;
    font-size: 14px;
    letter-spacing: 0.15px;
    line-height: 18px;
    color: var(--mine-shaft-700);
    text-align: left;
}
</style>