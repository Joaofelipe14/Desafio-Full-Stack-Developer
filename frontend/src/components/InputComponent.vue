<template>
    <div :class="['input-container', state, type]">
        <label v-if="label">{{ label }}</label>
        <div class="input-search">
            <span v-if="type === 'search'">
                <img class="icon-search" src="../assets/icons/search.svg" alt="">
            </span>
            <input 
            class="input" 
            :type="inputType" 
            :class="{ error: isError, 'padding-input': type === 'search' }"  
            :placeholder="placeholder"
            :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
        </div>
        <span v-if="isError" class="error-message">{{ errorMessage }}</span>
    </div>
</template>

<script>
export default {
    props: {
        modelValue: String,
        placeholder: String,
        label: String,
        type: { type: String, default: 'default' },
        errorMessage: String,
        isError: { default: false },

    },
    computed: {
        inputType() {
            return this.type === 'search' ? 'text' : 'text';
        },
    },
    methods: {

    },
    mounted() {
        console.log('Componente montado, estado inicial:', this.state);
    },
    watch: {
        state(newState) {
            // A cada mudança no valor de 'state', logue no console
            console.log('O valor de state foi alterado para:', newState);
        },
    },
};

</script>

<style>

.input-container {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.icon-search {
    position: absolute;
    margin-top: 8px;
    margin-left: 5px;
    /* filter: invert(1); */
    width: 20px;
    height: 20px;
}

.padding-input{
    padding-left: 30px;
}


input {
    display: flex;
    align-items: center;
    border: 1px solid var(--mine-shaft-30);
    background-color: var(--mine-shaft-10);
    padding: 8px;
    border-radius: 8px;
    padding: 9px 12px;
    font-size: 14px;
}

/*   */

input:hover {
    border-color: var(--mine-shaft-100);
}

input:focus {
    border-color: var(--persian-blue-600);
    outline: none;

}

input:active {
    border-color: var(--mine-shaft-30);
    color: var(--mine-shaft-10);

}

.error {
    border-color: var(--alizarin-crimson-500);
    background: var();
}

.error-message {
    color: var(--alizarin-crimson-500);
    font-size: 12px;
    font-weight: 500;
}

.icon {
    margin-right: 8px;
}
</style>