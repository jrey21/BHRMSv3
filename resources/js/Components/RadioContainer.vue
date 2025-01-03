<template>
  <div class="radio-container">
    <label><input type="radio" v-model="modelValue" value="Yes"> Yes</label>
    <label><input type="radio" v-model="modelValue" value="No"> No</label>
  </div>
</template>

<script setup>
const props = defineProps(['modelValue']);
const emit = defineEmits(['update:modelValue']);
</script>

<style scoped>
.radio-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}
</style>
