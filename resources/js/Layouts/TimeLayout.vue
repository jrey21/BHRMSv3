<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

// Reactive property for current time
const currentTime = ref('');

// Function to format the time
const updateTime = () => {
    const now = new Date();

    const dayName = now.toLocaleString('en-US', { weekday: 'short' }); 
    const monthName = now.toLocaleString('en-US', { month: 'long' });
    const day = now.getDate(); 
    const year = now.getFullYear(); 
    const time = now.toLocaleTimeString('en-US', { hour12: true }); 

    // Create the desired format: "Tuesday / Oct 28 2024 / 3:17:36PM"
    currentTime.value = `${monthName} ${day}, ${year} (${dayName}) ${time}`;
};

// Update time on mount and keep updating every second
onMounted(() => {
    updateTime();  // Set the time immediately
    const timer = setInterval(updateTime, 1000); // Update every second

    onBeforeUnmount(() => {
        clearInterval(timer);  // Cleanup timer when component is destroyed
    });
});
</script>

<template>
<!-- Real-time clock -->
    <div class="text-blue-800 text-right pt-1 w-auto">
        {{ currentTime }}
    </div>
</template>