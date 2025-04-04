<template>
  <button  class='btn-primary' @click="handleClick" >
    <img v-if="showIcon"src="../assets/icons/add.svg" alt="Add Icon" class="icon" />
    {{ label }}
  </button>
</template>

<script>


export default {
  props: {
    label: {
      type: String,
      default: "Clique Aqui",
    },
    showIcon: {
      type: Boolean,
      default: false 
  },
},
  methods: {
    handleClick() {
    },
  },
};
</script>

<style>
button {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 9px 12px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s, opacity 0.2s;

  /* Button */
  font-style: normal;
  font-weight: 400;
  font-size: 14px;
  line-height: 18px;
  display: flex;
  align-items: center;
  letter-spacing: 1.25px;

}

.icon{
  filter: invert(1);
  width: 20px;
  height: 20px;
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