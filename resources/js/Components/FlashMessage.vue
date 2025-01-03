<template>
    <transition name="fade">
        <div v-if="show" class="flash-modal">
            <div class="flash-content">{{ message }}</div>
        </div>
    </transition>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    show: { type: Boolean, required: true },
    message: { type: String, required: true },
});
</script>

<style scoped>
.flash-modal {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #4CAF50;
    color: white;
    padding: 15px 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}
.flash-content {
    font-size: 16px;
    font-weight: bold;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
</style>