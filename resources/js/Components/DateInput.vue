<template>
  <input type="date" class="date-input" v-model="modelValue">
</template>

<script setup>
const props = defineProps(['modelValue']);
const emit = defineEmits(['update:modelValue']);
</script>

<style scoped>
.date-input {
  width: 90%;
  text-align: center;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
  font-size: 14px;
  font-weight: normal;
}
</style>
