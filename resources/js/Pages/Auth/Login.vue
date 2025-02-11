<script setup>
import { ref, onMounted } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import TextInput from "../Components/TextInput.vue";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons';

const form = useForm({
    email: null,
    password: null,
    remember: false, // Ensure default value is false
});

const showPassword = ref(false);
const flashMessage = ref('');

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};

// Load remembered email from localStorage when component mounts
onMounted(() => {
    const rememberedEmail = localStorage.getItem('rememberedEmail');
    if (rememberedEmail) {
        form.email = rememberedEmail;
        form.remember = true;
    }
});

const submit = () => {
    form.post(route('login'), {
        onSuccess: () => {
            flashMessage.value = 'Successfully logged in!';
            
            // Store email if "Remember Me" is checked
            if (form.remember) {
                localStorage.setItem('rememberedEmail', form.email);
            } else {
                localStorage.removeItem('rememberedEmail');
            }
        },
        onError: () => {
            form.reset("password");
        }
    });
};
</script>

<template>
    <Head title=" | Login"/>

    <div class="flex items-center justify-center min-h-screen bg-cover bg-center">
        <div class="flex flex-col items-center w-full max-w-md p-8 bg-white bg-opacity-90 rounded-lg shadow-lg backdrop-blur-md shadow-2xl shadow-gray-500/50">
            <h1 class="text-2xl font-bold text-center text-gray-800 mb-4">Barangay Health Record Management System (BHRMS)</h1>
            <div class="w-24 h-24 mb-6">
                <img src="../Components/image/patag_logo.png" alt="logo" class="w-full h-full object-contain"/>
            </div>
            <hr class="w-full border-t border-gray-300 mb-2">

            <!-- Display success message -->
            <div v-if="$page.props.flash.success" class="mb-4 text-green-500">
                {{ $page.props.flash.success }}
            </div>

            <form @submit.prevent="submit" class="w-full">
                <TextInput 
                    class="mb-4" 
                    name="email" 
                    type="email"
                    v-model="form.email" 
                    :message="form.errors.email"
                />

                <div class="relative mb-4">
                    <TextInput 
                        name="password" 
                        :type="showPassword ? 'text' : 'password'"
                        v-model="form.password" 
                        :message="form.errors.password"
                    />
                    <FontAwesomeIcon 
                        :icon="showPassword ? faEyeSlash : faEye" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-slate-600"
                        @click="togglePasswordVisibility"
                        style="top: 70%; transform: translateY(-50%);"
                    />
                </div>

                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" class="ml-2" v-model="form.remember" id="remember">
                        <label for="remember" class="text-gray-700">Remember me</label>
                    </div>
                </div>

                <div class="flex flex-col items-center">
                    <button class="primary-btn w-full mb-4" :disabled="form.processing">Login</button>
                    <p class="text-gray-600">Need an account? <a :href="route('register')" class="text-link">Register</a></p>
                </div>
            </form>

            <div v-if="flashMessage" class="text-green-500 mt-2">{{ flashMessage }}</div>
        </div>
    </div>
</template>
