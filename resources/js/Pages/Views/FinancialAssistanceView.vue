<script setup>
import FormLayout from '../../Layouts/FormLayout.vue';
import { defineOptions } from 'vue';
import FinancialAssistance from '../SeniorCitizen/Events.vue';

defineOptions({
    layout: FormLayout
});

</script>

<template>
    <Head title=" | Financial Assistance"/>

    <FinancialAssistance />
</template>
