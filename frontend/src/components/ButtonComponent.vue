<template>
  <button class='btn-primary' @click="emit('click')" >
    {{ label }}
  </button>
</template>

<script setup lang="ts">
const props = defineProps<{ label: string }>()
const emit = defineEmits<{
  (e: 'click'): void
}>()
</script>


<style>

button {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 16px;
  font-weight: bold;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s, opacity 0.2s;
}

.btn-primary {
  background-color: var(--persian-blue-600);
  color: var(--white);
}

.btn-primary:hover {
  background-color: var(--persian-blue-300);
}


.btn-primary:focus {
  background-color: var(--persian-blue-700);
}


</style>