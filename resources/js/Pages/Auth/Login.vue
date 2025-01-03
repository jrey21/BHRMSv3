<script setup>
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import TextInput from "../components/TextInput.vue";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons';
import { useRouter } from 'vue-router';

const form = useForm({
    email: null,
    password: null,
    remember: null,
});

const showPassword = ref(false);
const router = useRouter();
const refreshed = ref(false);
const flashMessage = ref('');

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};

const submit = () => {
    form.post(route('login'), {
        onSuccess: () => {
            flashMessage.value = 'Successfully logged in!';
            setTimeout(() => {
                window.location.reload();
            }, 500); 
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
            <!-- BHRMS Title -->
            <h1 class="text-2xl font-bold text-center text-gray-800 mb-4">Barangay Health Record Management System (BHRMS)</h1>
            <!-- Logo centered below the text -->
            <div class="w-24 h-24 mb-6">
                <img src="../Components/image/patag_logo.png" alt="logo" class="w-full h-full object-contain"/>
            </div>
            <hr class="w-full border-t border-gray-300 mb-2">

            <!-- Login form -->
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
            <div v-if="refreshed" class="text-green-500 mt-2">Page has been refreshed</div>
            <div v-if="flashMessage" class="text-green-500 mt-2">{{ flashMessage }}</div>
        </div>
    </div>
</template>