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
    avatar: null,
    preview: props.user.avatar ? `/storage/${props.user.avatar}` : 'storage/avatars/default.jpg',
});

const changeAvatar = (e) => {
    form.avatar = e.target.files[0];
    form.preview = URL.createObjectURL(e.target.files[0]);
};

const handleSubmit = () => {
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('email', form.email);
    if (form.avatar) {
        formData.append('avatar', form.avatar);
    }

    form.post(route('profile.info'), {
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
       
        <!-- Upload Avatar -->
        <div class="grid place-items-center mb-6">
            <div class="relative w-24 h-24 rounded-full overflow-hidden border border-slate-300">
                <label for="avatar" class="absolute inset-0 grid content-end cursor-pointer avatar">
                    <span class="bg-white/70 pb-2 text-center">Update</span>
                </label>
                <input type="file" @change="changeAvatar" id="avatar" hidden />
                <img class="object-cover w-24 h-24" :src="form.preview" />
            </div>
            <p class="text-xs text-red-500 mb-2">{{ form.errors.avatar }}</p>
        </div>
        <!-- End Upload Avatar -->

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
            <PrimaryBtn :disabled="form.processing" class="save-btn">Save</PrimaryBtn>
        </form>
    </Container>
    </div>
</template>

<style>
.box-size {
    width: 440px;
}
.save-btn:hover {
    background-color: #2553b7; 
    transform: scale(1.02); 
    color: white;
}
</style>
