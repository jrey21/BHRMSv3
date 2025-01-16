<script setup>
import UpdateLayout from '../../Layouts/UpdateLayout.vue';
import UpdateInfo from './Sections/UpdateInfo.vue';
import UpdatePassword from './Sections/UpdatePassword.vue';
import Cancel from '../../Components/Cancel.vue';

defineOptions({ layout: UpdateLayout});

defineProps({
    user: Object,
});

</script>

<template>
    <Head title=" | Profile"></Head>
    <UpdateInfo :user="user"/>
    <UpdatePassword :user="user"/>
    <Cancel/>
</template>