<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email')); // Route for sending reset link
};
</script>

<template>
    <div class="w-1/3 mx-auto mt-16">
        <h1 class="text-2xl font-bold mb-4">Forgot Password</h1>
        <form @submit.prevent="submit">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email Address</label>
                <input
                    id="email"
                    type="email"
                    v-model="form.email"
                    class="border border-gray-300 rounded w-full px-3 py-2 mt-1"
                    placeholder="Enter your email"
                    required
                />
                <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
            </div>
            <button type="submit" class="primary-btn w-full" :disabled="form.processing">
                Send Password Reset Link
            </button>
        </form>
    </div>
</template>
