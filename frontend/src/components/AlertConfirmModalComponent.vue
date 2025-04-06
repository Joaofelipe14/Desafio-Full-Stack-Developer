<template>
    <div class="modal" @click.self="handleClose(false)">
        <div class="modal-content">
            <div class="header-modal">
                <h2>Excluir este contato?</h2>
            </div>

            <div class="content-modal">
                <div class="actions">
                    <ButtonComponent label="Cancelar" :buttonStyle="'btn-secondary'" @click="handleClose(false)" />
                    <ButtonComponent label="Confirmar" :buttonStyle="'btn-danger'" @click="handleClose(true)" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import ButtonComponent from './ButtonComponent.vue'

const emit = defineEmits<{
    (e: 'close', confirmed: boolean): void
}>()

const handleClose = (confirmed: boolean) => {
    emit('close', confirmed)
}
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
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding: 0px;
    width: 360px;
    height:144px;
    background: #FFFFFF;
    border: 1px solid #E1E1E1;
    box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.15);
    border-radius: 12px;
}

.header-modal {

    padding: 24px;
}

.header-modal h2 {
    font-size: 1.25rem;
    color: #333;
}

.content-modal {

    display: flex;
    justify-content: flex-end;
    width: 100%;
}

.actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    /* margin-top: 24px; */
    padding: 16px;
}
</style>