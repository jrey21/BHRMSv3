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

// Function to handle logout with confirmation if confirmed, redirect to login page if not, prevent default behavior
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
    <div class="bg-slate-100">
        <!-- Navigation bar -->
        <header class="flex items-center justify-between bg-blue-700 text-white p-1">
            <!-- Logo and Title -->
            <div class="flex items-center space-x-2">
                <img src="../Pages/Components/image/patag_logo.png" alt="logo" class="w-10 h-10"/> 
                <p>BHRMS Barangay Patag</p>
            </div>

            <!-- Navigation Links -->
            <nav class="flex items-center space-x-6">
                <!-- Authentication Links -->
                <div v-if="!$page.props.auth.user" class="flex items-center space-x-6">
                    <Link v-if="$page.component === 'Auth/Login'" 
                          :href="route('register')" 
                          class="nav-link underline text-white">
                        Register    
                    </Link>
                    <Link v-if="$page.component === 'Auth/Register'" 
                          :href="route('login')" 
                          class="nav-link underline text-white">
                        Login    
                    </Link>
                    <div v-if="$page.component !== 'Auth/Login' && $page.component !== 'Auth/Register'" class="flex space-x-4">
                        <Link :href="route('register')" 
                              class="nav-link underline text-white">
                            Register    
                        </Link>
                        <Link :href="route('login')" 
                              class="nav-link underline text-white">
                            Login    
                        </Link>
                    </div>
                </div>

                <!-- User Info and Logout -->
                <div v-if="$page.props.auth.user" class="space-x-6 flex items-center">
            <span class="user">{{ $page.props.auth.user.name }}</span>
            <Link :href="route('logout')" 
                  method="post"
                  as="button"
                  type="button"
                  :class="{'underline decoration-3.75 decoration-white underline-offset-8 text-white': $page.component === 'Logout'}" 
                  class="nav-link"
                  @click.prevent="handleLogout">
                <i class="fas fa-sign-out-alt text-white text-xl hover:text-blue-500 hover:bg-white pl-2 pr-2"></i>
            </Link>
        </div>
            </nav>
        </header>
    </div>
    <main class="main-content">
        <slot />
    </main>
</template>

<style scoped>
.main-content {
    padding: 20px; /* Add padding to prevent overlay */
    /* Responsive design */
    @media (max-width: 768px) {
        padding: 10px; /* Adjust padding for smaller screens */
    }
}
</style>
