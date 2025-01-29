<script setup>
import Container from "../../../Components/Container.vue";
import Title from "../../../Components/Title.vue";
import InputField from "../../../Components/InputField.vue";
import PrimaryBtn from "../../../Components/PrimaryBtn.vue";
import ErrorMessages from "../../../Components/ErrorMessages.vue";
import Cancel from "../../../Components/Cancel.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.put(route("profile.password"), {
        onSuccess: () => form.reset(),
        onError: () => form.reset(),
        preserveScroll: true,
    });
};
</script>

<template>
    <div class="box-size">
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Password</Title>
            <p class="text-[14px] mb-4">Ensure your are using a long, random password to stay secure.</p>
            <p v-if="form.recentlySuccessful" class="text-sm text-green-500 mb-2">Password has been updated successfully!</p>
            <hr>
        </div>

        <ErrorMessages :errors="form.errors" />

        <form @submit.prevent="submit" class="space-y-6">
            <InputField
                label="Current Password"
                icon="key"
                class="w-1/2"
                type="password"
                v-model="form.current_password"
            />

            <InputField
                label="New Password"
                icon="key"
                class="w-1/2"
                type="password"
                v-model="form.password"
            />

            <InputField
                label="Confirm New Password"
                icon="key"
                class="w-1/2"
                type="password"
                v-model="form.password_confirmation"
            />

            <PrimaryBtn :disabled="form.processing" class="save-btn">Save</PrimaryBtn>
        </form>
    </Container>

    <Container>
        <div>
            <Title>You're All Set!</Title>
            <p class="text-[14px] mb-4">The update has been applied successfully.</p>
            <hr>
            <Cancel class="mt-4"/>
        </div>
    </Container>
    </div>
</template>


<style scoped>
.box-size {
    width: 450px;
}
</style>