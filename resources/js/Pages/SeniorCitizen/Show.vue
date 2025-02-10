<script setup>
import { defineProps, ref, onMounted, computed } from 'vue';
import FormLayout from '../../Layouts/FormLayout.vue';
import SeniorList from './SeniorList.vue';
import QrScanner from './QrScanner.vue';


defineOptions({
    layout: FormLayout,
});

const props = defineProps({
    seniorEvent: { type: Object, required: true },
});
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const showTables = ref(false);
const flashMessage = ref('');
const showFlashMessage = ref(false);

</script>


<template>
   <Head title=" | Financial Assistance" />

    <!-- Flash message -->
    <FlashMessage :show="showFlashMessage" :message="flashMessage" />

    <!-- Header -->
    <div class="name-header mt-4">
        <transition name="fade">
            <h3>
                <strong style="color: #007bff; font-size: 20px; margin-left:5%;"> {{ seniorEvent.title}} ({{ formatDate(seniorEvent.date) }})</strong> 
            </h3>
        </transition>
    </div>

    <!-- QR Scanner -->
    <div class="d-flex justify-content-center">
        <QrScanner :seniorEvent="props.seniorEvent"/>
    </div>

    <!-- Senior List -->
    <!-- <SeniorList :seniorEvent="seniorEvent" /> -->

</template>
