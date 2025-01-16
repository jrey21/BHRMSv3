<script setup>
import Container from "../../../Components/Container.vue";
import Title from "../../../Components/Title.vue";
import InputField from "../../../Components/InputField.vue";
import PrimaryBtn from "../../../Components/PrimaryBtn.vue";
import ErrorMessages from "../../../Components/ErrorMessages.vue";
import { useForm } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';

// defineOptions({ layout: UpdateLayout});

const props = defineProps({
    user: {
        type: Object,
    }
});

const showModal = ref(false);
const showErrorModal = ref(false);

const form = useForm({
    name: props.user.name,
    email: props.user.email,
});


const handleSubmit = () => {
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('email', form.email);

    form.patch(route('profile.info'), {
        data: formData,
        onSuccess: () => {
            showModal.value = true;
            setTimeout(() => {
                showModal.value = false;
            }, 2000);
        },
        onError: () => {
            showErrorModal.value = true;
            setTimeout(() => {
                showErrorModal.value = false;
            }, 10000);
        }
    });
};

onMounted(() => {
    watch(() => form.errors, (newErrors) => {
        if (Object.keys(newErrors).length > 0) {
            showErrorModal.value = true;
            setTimeout(() => {
                showErrorModal.value = false;
            }, 10000);
        }
    });
});

</script>
<template>
    <div class="box-size">
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Information</Title>
            <p class="text-[14px] mb-4">Update your account's profile information below.</p>            
            <p v-if="showModal" class="text-sm text-green-500 mb-2">Profile updated successfully!</p>
            <hr>
 
        </div>

        <ErrorMessages :errors="form.errors" />
       

        <form
            @submit.prevent="handleSubmit" 
                class="space-y-6"
        >
        
            <InputField
                label="Name"
                icon="user"
                class="w-1/2"
                v-model="form.name"
            />

            <InputField
                label="Email"
                icon="envelope"
                class="w-1/2"
                v-model="form.email"
            />
            <PrimaryBtn :disabled="form.processing">Save</PrimaryBtn>
        </form>
    </Container>
    </div>
</template>

<style>
.box-size {
    width: 400px;
}
button:hover {
    background-color: #2553b7; 
    transform: scale(1.02); 
    color: white;
}

</style>
