<template>
    <div :class="['input-container', type]">
        <label class="caption" v-if="label">{{ label }}</label>
            <span v-if="type === 'search'">
                <img class="icon-search" src="../assets/icons/search.svg" alt="">
            </span> 
            <input 
            :type="type" 
            :class="{ error: isError, 'padding-input': type === 'search' }"  
            :placeholder="placeholder"
            :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
        <div v-if="isError" class="error-message">{{ errorMessage }}</div>
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
    methods: {

    },
};

</script>

<style>

.input-container {
    display: flex;
    flex-direction: column;
    gap: 6px;
    width: 100%;
}

.icon-search {
    position: absolute;
    margin-left: 5px;
    width: 20px;
    height: 20px;
    margin-top: 11px;
}

.padding-input{
    padding-left: 30px;
    max-width: 300px;

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