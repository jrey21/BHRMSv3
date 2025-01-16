<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
    backgroundClass: {
        type: String,
        default: 'bg-default',
    }
});

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

// Function to handle logout with confirmation
const handleLogout = (event) => {
    if (confirm('Are you sure you want to log out?')) {
        window.location.href = route('login');
    } else {
        event.preventDefault();
    }
};
</script>
<template>
    <div :class="[$page.component === 'Auth/Register' ? 'bg-register' : 'layout']"></div>
    <Head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </Head>
    <div class="bg-gradient-to-r from-blue-100 via-white to-blue-400 h-screen">
    <!-- <div class="bg-slate-100 h-screen"> -->
        
        <!-- Navigation bar -->
        

        <main>
            <slot />
        </main>
    </div>
</template>

<style scoped>

nav {
    display: flex;
    flex-direction: column;
    align-items: center;
}

@media (min-width: 768px) {
    nav {
        flex-direction: row;
        justify-content: space-between;
    }
}

.bg-gradient-to-r {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6, #60a5fa, #93c5fd, #bfdbfe);
    background-size: 300% 300%;
    animation: gradientAnimation 15s ease infinite;
}

@keyframes gradientAnimation {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
</style>

