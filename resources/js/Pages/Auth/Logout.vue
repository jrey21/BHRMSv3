<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import TextInput from "../Components/TextInput.vue";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons';

const form = useForm({
    email: null,
    password: null,
    remember: null,
});

const showPassword = ref(false);

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};

const submit = () => {
    form.post(route('login'), {
        onError: () => {
            form.reset("password");
        }
    });
};
</script>

<template>
    <Head title=" | Login"/>

    <div class="flex items-start mt-16 h-full w-3/4">
        <!-- Left section with BHRMS title and logo -->
        <div class="flex flex-col items-center w-1/2 mt-8">
            <!-- BHRMS Title -->
            <h1 class="title text-center">Barangay Health Record Management System (BHRMS)</h1>
            <!-- Logo centered below the text -->
            <div class="w-60 h-60 mt-6">
                <img src="../Components/image/patag_logo.png" alt="logo" class="w-full h-full object-contain"/>
            </div>
        </div>

        <!-- Login form -->
        <div class="absolute w-1/4 bg-white rounded-lg p-6 right-20 mt-20">
            <form @submit.prevent="submit">
                <TextInput
                    class="container" 
                    name="email" 
                    type="email"
                    v-model="form.email" 
                    :message="form.errors.email"
                />

                <div class="relative">
                    <TextInput 
                        name="password" 
                        :type="showPassword ? 'text' : 'password'"
                        v-model="form.password" 
                        :message="form.errors.password"
                    />
                    <FontAwesomeIcon 
                        :icon="showPassword ? faEyeSlash : faEye" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer mt-3 text-slate-600"
                        @click="togglePasswordVisibility"
                    />
                </div>

                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" class="ml-2" v-model="form.remember" id="remember">
                        <label for="remember">Remember me</label>
                    </div>
                </div>

                <div>
                    <button class="primary-btn mb-5" :disabled="form.processing">Login</button>
                    <p class="text-slate-600">Need an account? <a :href="route('register')" class="text-link">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</template>