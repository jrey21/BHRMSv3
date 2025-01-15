<script setup>
import Sidebar from '../Pages/Components/Sidebar.vue';
import RightSidebar from '../Pages/Components/RightSidebar.vue';
import { ref } from 'vue';

// Props for dynamic background class
const props = defineProps({
    backgroundClass: {
        type: String,
        default: 'bg-default',
    }
});

// Function to handle logout without confirmation
const handleLogout = (event) => {
    window.location.href = route('login');
};

const isSidebarOpen = ref(false);
const isRightSidebarOpen = ref(false);
const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};
const toggleRightSidebar = () => {
    isRightSidebarOpen.value = !isRightSidebarOpen.value;
};
</script>

<template>
    <!-- Dynamic background -->
    <div :class="[$page.component === 'Auth/Register' ? 'bg-register' : 'layout']"></div>

    <!-- Page Head -->
    <Head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </Head>

    <div class="bg-slate-100">
        <!-- Navigation bar -->
        <header class="navbar">
            <!-- Logo and Title -->
            <div class="flex items-center space-x-2" style="font-size:medium;">
                <img src="../Pages/Components/image/patag_logo.png" alt="logo" class="w-10 h-10" />
                <Link :href="route('dashboard')">Barangay Patag</Link>
            </div>

            <!-- Navigation Links -->
            <nav class="flex items-center space-x-6">
                <!-- Guest Links -->
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
                        <Link :href="route('register')" class="nav-link underline text-white">
                            Register    
                        </Link>
                        <Link :href="route('login')" class="nav-link underline text-white">
                            Login    
                        </Link>
                    </div>
                </div>

                <!-- Authenticated User Links -->
                <div v-else class="flex items-center space-x-10">
                    <span class="user mr-40">{{ $page.props.auth.user.name }}</span>
                    <Link :href="route('logout')" 
                        method="post"
                        as="button"
                        type="button"
                        :class="{' text-white': $page.component === 'Logout'}" 
                        class="nav-link logout-button"
                        @click.prevent="handleLogout">
                        <i class="fas fa-sign-out-alt text-xl"></i>
                    </Link>
                </div>
            </nav>
        </header>
    </div>

    <!-- Sidebar and Main Content -->
    <Sidebar :class="{ open: isSidebarOpen }" />
    <main class="main-content">
        <slot />
        <!-- <footer>
            <div class="flex items-center" style="margin-top: 20%">
            </div>
        </footer> -->
    </main>
    <RightSidebar :class="{ open: isRightSidebarOpen }" />
    <div></div>
</template>

<style scoped>
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    background-color: #1d4ed8;
    color: white;
    padding: 0.5rem 1rem;
    font-size: 0.875rem; 
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logout-button {
    background-color: #1d4ed8;
    color: white;
    border-radius: 0.375rem;
    display: flex;
    align-items: center;
    transition: background-color 0.3s ease, color 0.3s ease;
    text-align: center;
    margin-right: 1.5rem;
}

.logout-button:hover {
    background-color: #2563eb;
    color: #ffffff; 
    margin-right: 0; 
}

.logout-button i {
    margin-right: 1.5rem;
}

.main-content {
    margin-top: 3%; 
    margin-left: 270px;
    margin-right: 270px;
    padding: 1rem;
}

@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
        margin-right: 0;
    }
    .sidebar {
        display: none;
    }
    .right-sidebar {
        display: none;
    }
}
</style>
