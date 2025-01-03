<script setup>
import { useForm } from '@inertiajs/vue3';
import TextInput from "../Components/TextInput.vue"; //na modify

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});

const capitalizeWords = (str) => {
    return str.replace(/\b\w/g, char => char.toUpperCase());
};

const submit = () => {
    form.name = capitalizeWords(form.name);
    form.post(route('register'),
        {
            onError: () => {
                form.reset("password", "password_confirmation");
            }
        });
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-2xl font-bold mb-6 text-center">Create a new Account</h3>
            <form @submit.prevent="submit">
                <TextInput name="name" v-model="form.name" :message="form.errors.name" class="mb-4" />
                <TextInput name="email" type="email" v-model="form.email" :message="form.errors.email" class="mb-4" />
                <TextInput name="password" type="password" v-model="form.password" :message="form.errors.password" class="mb-4" />
                <TextInput name="confirm password" type="password" v-model="form.password_confirmation" class="mb-4" />
                <div class="flex items-center justify-between mb-6">
                    <p class="text-slate-600">Already a user?
                        <Link :href="route('login')" class="text-blue-500 hover:underline">Login</Link>
                    </p>
                </div>
                <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300" :disabled="form.processing">Register</button>
            </form>
        </div>
    </div>
</template>
