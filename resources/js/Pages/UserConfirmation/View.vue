<script setup>
import FormLayout from '../../Layouts/FormLayout.vue';
import ContainerBox from '../../Components/ContainerBox.vue';
import Users from './Data/Users.vue';

defineOptions({ layout: FormLayout});

const props = defineProps({
    users: { type: Object, required: true },

    
});

</script>

<template>
    <Head title=" | Confirm Users"/>
    <div>
        <h1 class="dashboard-head text-slate-500">New Users for Approval</h1>
    </div>
        <div class="grid grid-cols-3 gap-4">
            <ContainerBox :users="users"/>
        </div>
</template>


<style scoped>

</style>