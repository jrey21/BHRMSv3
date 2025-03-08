<script setup>
import Sidebar from '../Pages/Components/Sidebar.vue';
import { ref, onMounted, onBeforeUnmount } from 'vue';

// Props for dynamic background class
const props = defineProps({
    backgroundClass: {
        type: String,
        default: 'bg-default',
    }
});
const isDropdownOpen = ref(false);

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

// Function to handle click outside of dropdown
const handleClickOutside = (event) => {
    if (!event.target.closest('.dropdown-container')) {
        isDropdownOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});

const capitalizeWords = (str) => {
    return str.replace(/\b\w/g, char => char.toUpperCase());
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
            <div class="flex items-center space-x-2" style="margin-left:5px; font-size:medium;">
                <img src="../Pages/Components/image/patag_logo.png" alt="logo" class="w-10 h-10" />
                <Link :href="route('dashboard')">Barangay Health Records Management System of Barangay Patag (BHRMS)</Link>
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
                <nav class="flex items-center space-x-6">
                    <!-- Authenticated User Links -->
                    <div v-if="$page.props.auth.user" class="relative dropdown-container">
                        <!-- Profile Button -->
                        <button
                            class="flex items-center space-x-2 px-3 py-2 bg-transparent text-white rounded-md hover:bg-blue-700 transition relative z-10"
                            @click="isDropdownOpen = !isDropdownOpen"
                            >
                            <img 
                                :src="$page.props.auth.user.avatar ? ('storage/' + $page.props.auth.user.avatar) : ('storage/avatars/default.jpg')"
                                alt="User Profile"
                                class="w-8 h-8 rounded-full object-cover"
                            />
                            <div class="text-left" style="margin-right: 15px; margin-left: 12px;">
                                <span class="font-semibold text-sm">{{ capitalizeWords($page.props.auth.user.name) }}</span>
                                <div class="text-xs text-white">{{ capitalizeWords($page.props.auth.user.position) }}</div>
                            </div>
                            <i :class="{'fa-chevron-down': true, 'fa-chevron-up': isDropdownOpen}" class="fas" style="margin-right: 10px;"></i>
                        </button>
  
                        <!-- Dropdown Menu -->
                        <div
                            v-if="isDropdownOpen"
                            class="absolute right-4 mt-0 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-20"
                            >
                            <Link :href="route('profile.edit')" class="dropdown-item"> Profile Settings</Link>
                            <hr>
                            <Link :href="route('logout')" 
                                method="post"
                                as="button"
                                type="button"
                                class="dropdown-item"
                                @click.prevent="handleLogout">
                                Logout
                            </Link>
                        </div>
                    </div>
                </nav>
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
    padding-top: 1px;
    padding-bottom: 1px;
    /* padding: 0.5rem 1rem; */
    font-size: 12px; 
    display: flex;
    justify-content: space-between;
    align-items: center;
    /* z-index: 1000; */
}
.dropdown-container {
    position: relative;
}

.dropdown-item {
  display: block;
  padding: 0.75rem 1rem;
  color: #1d4ed8;
  font-size: 0.875rem;
  text-decoration: none;
  width: 100%;
  text-align: left;
  transition: background-color 0.2s ease;
  z-index: 20;
}

.dropdown-item:hover {
  background-color: #f3f4f6;
}

.dropdown-item:active {
  background-color: #e5e7eb;
}

button:focus {
  outline: none;
}

.relative {
  position: relative;
}

.absolute {
  position: absolute;
}

/* .logout-button {
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
} */

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
