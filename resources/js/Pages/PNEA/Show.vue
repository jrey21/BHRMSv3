<script setup>
import { defineProps, ref, onMounted, computed } from 'vue';
import FormLayout from '../../Layouts/FormLayout.vue';
import Enrollment from './Enrollment.vue';
import OPData from './OPData.vue';


defineOptions({
    layout: FormLayout,
});

const props = defineProps({
    pnea: { type: Object, required: true },
});

</script>

<template>
    <Head title=" | Maternal Care" />
    <Enrollment :pnea="pnea" />
    <OPData :pnea="pnea" />
</template>
