<template>
  <button :class="['btn', buttonStyle]" :disabled="disabled" @click="handleClick">
    <img v-if="icon" :src="iconData.src" :alt="iconData.alt" class="icon" />
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
    icon: {
      type: String,
      default: null,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    buttonStyle: {
      type: String,
      default: 'btn-primary',
    },
  },
  computed: {
    iconData() {
      const icons = {
        left: { src: "/src/assets/icons/back-left.svg", alt: "Left Icon" },
        add: { src: "/src/assets/icons/add.svg", alt: "Add Icon" },
      };
      return this.icon ? icons[this.icon] || {} : {};
    }
  },
  methods: {
    handleClick() {
    },
  },
};
</script>


<style>
button {
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

.icon {
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

.btn-primary:active {
  background-color: var(--persian-blue-700);
}

.btn-primary:disabled {
  background-color: var(--mine-shaft-100);
  cursor: not-allowed;
}

.btn-secondary {
  background-color: var(--white);
  color: var(--mine-shaft-400);
}

.btn-secondary:hover {
  background-color: var(--mine-shaft-10);
}

.btn-secondary:focus {
  background-color: var(--mine-shaft-30);
  color: var(--mine-shaft-700);
}

.btn-secondary:active {
  background-color: var(--mine-shaft-30);
  color: var(--mine-shaft-700);

}

.btn-secondary:disabled {
  background-color: var(--white);
  cursor: not-allowed;
  color: var(--mine-shaft-80);
}

.btn-danger {
  background-color: var(--white);
  color: var(--alizarin-crimson-400);
}

.btn-danger:hover {
  background-color: var(--alizarin-crimson-10);
}

.btn-danger:focus {
  background-color: var(--alizarin-crimson-30);
  color: var(--alizarin-crimson-500);
}

.btn-danger:active {
  background-color: var(--alizarin-crimson-0);
  color: var(--alizarin-crimson-500);

}

.btn-danger:disabled {
  background-color: var(--white);
  cursor: not-allowed;
  color: var(--mine-shaft-80);
}
</style>