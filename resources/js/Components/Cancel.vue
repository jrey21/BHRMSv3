<template>
  <button @click="confirmCancel" class="px-6 py-2 rounded-lg text-white text-sm done-btn">Done</button>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const confirmCancel = () => {
    window.location.href = route('dashboard');
};
</script>

<style scoped>
.done-btn {
  background-color: rgb(66, 66, 66);
  border: none;
  cursor: pointer;
}
.done-btn:hover {
  background-color: rgb(1, 0, 0, 0.6);
  color: white;
}
</style>
