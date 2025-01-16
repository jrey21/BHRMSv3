<script setup>
defineProps({
    success: Object,
});
</script>

<template>
    <div class="mb-4" v-if="Object.keys(success).length">
        <p class="text-sm text-green-500">Data has been successfully saved!</p>
    </div>
</template>