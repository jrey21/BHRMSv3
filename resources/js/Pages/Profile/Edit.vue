<script setup>
import FormLayout from '../../Layouts/UpdateLayout.vue';
import UpdateInfo from './Sections/UpdateInfo.vue';
import UpdatePassword from './Sections/UpdatePassword.vue';

defineOptions({ layout: FormLayout});

defineProps({
    user: Object,
});

</script>

<template>
    <Head title=" | Profile"></Head>
    <UpdateInfo :user="user"/>
    <UpdatePassword :user="user"/>
</template>