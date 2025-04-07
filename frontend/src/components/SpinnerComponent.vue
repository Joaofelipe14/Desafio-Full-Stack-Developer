<template>
    <div class="spinner-overlay">
      <div class="spinner"></div>
      <span>Carregando...</span>
    </div>
  </template>
  
  <script lang="ts">
  export default {
    name: 'SpinnerComponent',
  };
  </script>
  
  <style scoped>
  
  .spinner-overlay {
    display: flex
;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 80%;
    font-family: 'Roboto', sans-serif;
  }
  
  .spinner {
    border: 5px solid var(--mine-shaft-10);
    border-top: 5px solid var(--persian-blue-300);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  
  span {
    margin-top: 10px;
    color: var(--persian-blue-600);
  }
  </style>
  