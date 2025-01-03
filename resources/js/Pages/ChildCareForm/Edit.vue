<script setup>
import { ref, watchEffect } from 'vue';
import { useForm } from '@inertiajs/vue3';

// Define props to receive the form data
const props = defineProps({
  form: Object, // Form data passed from the backend
});

// Initialize the form data with Inertia's useForm hook
const form = useForm({
    ...props.form // Populate form fields with the passed data
});

// Define loading state
const isLoading = ref(false);
const errors = ref([]);

// Watch for form changes
watchEffect(() => {
  console.log(form); // Optionally, log form data for debugging
});

// Submit the form to update the data
const updateData = async () => {
    isLoading.value = true;
    try {
        await form.put(route('childcare-form-update', { id: form.id }), {
            onError: (errors) => {
                isLoading.value = false;
                errors.value = errors;
            },
            onSuccess: () => {
                isLoading.value = false;
                alert('Data updated successfully!');
            }
        });
    } catch (error) {
        isLoading.value = false;
        console.error('Error submitting the form', error);
    }
};
</script>

<template>
    <div class="edit-form-container p-8 max-w-4xl mx-auto bg-white shadow-md rounded-lg">
        <!-- Display loading spinner if form is being submitted -->
        <div v-if="isLoading" class="flex justify-center items-center">
            <div class="spinner"></div>
        </div>

        <!-- Display form with errors if any -->
        <div v-if="errors.length" class="bg-red-100 p-4 rounded-md mb-4">
            <ul>
                <li v-for="error in errors" :key="error" class="text-red-600">{{ error }}</li>
            </ul>
        </div>

        <!-- Form for editing childcare data -->
        <form @submit.prevent="updateData">
            <h1 class="text-2xl font-bold mb-4 text-center">Edit Child Care Form</h1>

            <!-- First Name Field -->
            <div class="form-group mb-4">
                <label for="first_name" class="block text-sm font-semibold text-gray-700">First Name</label>
                <input v-model="form.first_name" type="text" id="first_name" class="w-full p-2 border rounded-md" required />
            </div>

            <!-- Last Name Field -->
            <div class="form-group mb-4">
                <label for="last_name" class="block text-sm font-semibold text-gray-700">Last Name</label>
                <input v-model="form.last_name" type="text" id="last_name" class="w-full p-2 border rounded-md" required />
            </div>

            <!-- Birth Date Field -->
            <div class="form-group mb-4">
                <label for="birth_date" class="block text-sm font-semibold text-gray-700">Birth Date</label>
                <input v-model="form.birth_date" type="date" id="birth_date" class="w-full p-2 border rounded-md" required />
            </div>

            <!-- Add more form fields as necessary -->

            <!-- Submit Button -->
            <button type="submit" class="w-full p-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                Save Changes
            </button>
        </form>
    </div>
</template>

<style scoped>
.edit-form-container {
    max-width: 600px;
    margin: 0 auto;
}

.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
