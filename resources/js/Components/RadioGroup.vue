<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  modelValue: String,
  options: Array
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
  <div class="radio-container">
    <label v-for="option in props.options" :key="option">
      <input type="radio" :value="option" :checked="props.modelValue === option" @change="$emit('update:modelValue', option)">
      {{ option }}
    </label>
  </div>
</template>

<style scoped>
.radio-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}
</style>
