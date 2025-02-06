<script setup>
import { useForm } from '@inertiajs/vue3';
import TextInput from "../Components/TextInput.vue"; 

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    position: null,
    avatar: null,
    preview: null,
});

const capitalizeWords = (str) => {
    return str.replace(/\b\w/g, char => char.toUpperCase());
};

const change = (e) => {
   form.avatar = e.target.files[0];
    form.preview = URL.createObjectURL(e.target.files[0]);
};

const submit = () => {
    form.post(route('register'),
        {
            onError: () => {
                form.reset("password", "password_confirmation");
            }
        });
};
</script>

<template>
    <Head title=" | Register"/>

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-2xl font-bold mb-6 text-center">Create a new Account</h3>
            <form @submit.prevent="submit">

                <!-- Upload Avatar -->
                <div class="grid place-items-center" >
                    <div
                        class="relative w-24 h-24 rounded-full overflow-hidden border border-slate-300"
                        >
                        <label for="avatar" class="absolute inset-0 grid content-end cursor-pointer avatar">
                            <span class="bg-white/70 pb-2 text-center">Avatar</span>
                        </label>
                        <input type="file" @change="change" id="avatar" hidden />

                        <img
                            class="object-cover w-24 h-24"
                            :src="form.preview ?? 'storage/avatars/default.jpg'"
                        />
                    </div>

                    <p class="text-xs text-red-500 mb-2">{{ form.errors.avatar }}</p>
                </div>
                <!-- End Upload Avatar -->


                <TextInput name="name" v-model="form.name" :message="form.errors.name" class="mb-[9px]" />
                
                <!-- Position Dropdown -->
                <div class="mb-[9px]">
                    <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                    <select id="position" v-model="form.position" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="Health Worker">Health Worker</option>
                        <option value="Admin">Admin</option>
                    </select>
                    <p class="text-xs text-red-500">{{ form.errors.position }}</p>
                </div>
                <!-- End Position Dropdown -->

                <TextInput name="email" type="email" v-model="form.email" :message="form.errors.email" class="mb-[9px]" />
                <TextInput name="password" type="password" v-model="form.password" :message="form.errors.password" class="mb-[9px]" />
                <TextInput name="confirm password" type="password" v-model="form.password_confirmation" class="mb-6" />
                
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

<style>
.avatar:hover {
    background-color: rgba(1, 0, 0, 0.5);
}
</style>
