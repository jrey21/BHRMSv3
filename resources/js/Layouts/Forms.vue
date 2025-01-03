<script setup>
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
        <header class="flex items-center justify-between bg-blue-700 text-white p-1">
            <!-- Logo and Title -->
            <div class="flex items-center space-x-2">
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
                <div v-else class="space-x-6 flex items-center">
                    <span class="user">{{ $page.props.auth.user.name }}</span>
                    <Link :href="route('logout')" 
                        method="post"
                        as="button"
                        type="button"
                        :class="{'underline decoration-3.75 decoration-white underline-offset-8 text-white': $page.component === 'Logout'}" 
                        class="nav-link bg-blue-700 text-white hover:bg-blue-500 hover:text-white pl-2 pr-2 rounded"
                        @click.prevent="handleLogout">
                        <i class="fas fa-sign-out-alt text-xl"></i>
                    </Link>
                </div>
            </nav>
        </header>
    </div>

    <!-- Sidebar and Main Content -->
    <main>
        <slot />
    </main>
</template>
