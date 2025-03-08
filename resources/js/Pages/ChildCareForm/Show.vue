<script setup>
import { defineProps, ref, onMounted, computed } from 'vue';
import FormLayout from '../../Layouts/FormLayout.vue';
import ChildInformation from './ChildInformation.vue';
import FlashMessage from '../../Components/FlashMessage.vue';
import VaccinationRecords from './VaccinationRecords.vue';
import VitaminASupplementation from './VitaminASupplementation.vue';
import Counseling from './Counseling.vue';
import GrowthMonitoring from './GrowthMonitoring.vue';
import DevelopmentalScreening from './DevelopmentalScreening.vue';
import Deworming from './Deworming.vue';
import Dental from './Dental.vue';
// import ECCDCard from './ECCDCard.vue';
import Space from '../../Components/Space.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faChevronDown, faChevronUp } from '@fortawesome/free-solid-svg-icons';

defineOptions({
    layout: FormLayout,
});

const props = defineProps({
    child: { type: Object, required: true },
});

const showTables = ref(false);
const flashMessage = ref('');
const showFlashMessage = ref(false);

const toggleTables = () => {
    showTables.value = !showTables.value;
};

const today = computed(() => {
    const date = new Date();
    return date.toISOString().split('T')[0];
});


</script>

<template>
    <Head title=" | Child Care Data" />

    <!-- Flash message -->
    <FlashMessage :show="showFlashMessage" :message="flashMessage" />

    <!-- Header -->
    <div class="name-header">
        <transition name="fade">
            <h3 v-if="child?.first_name" class="child-head text-slate-500">
               Records of <strong style="color: #007bff;"> {{ child.first_name }} {{ child.middle_name }} {{ child.last_name }} </strong> 
            </h3>
        </transition>
        <transition name="fade">
            <button class="t-btn" @click="toggleTables">
                <FontAwesomeIcon :icon="showTables ? faChevronUp : faChevronDown" />
            </button>
        </transition>
    </div>

    <div class="bg-slate-200 h-1 mb-2"></div>

    <!-- Child information -->
    <transition name="fade">
        <div v-if="showTables && child">
            <ChildInformation :child="child" />
        </div>
    </transition>

    <!-- Vaccination Records Information -->
    <VaccinationRecords :child="child" />

    <!-- Vitamin A Supplementation Information -->
    <VitaminASupplementation :child="child" />

    <!-- Counseling Information -->
    <Counseling :child="child" />

    <!-- Growth Monitoring Records Information -->
    <GrowthMonitoring :child="child" />

    <!-- Developmental Screening Information -->
    <DevelopmentalScreening :child="child" />

    <!-- Deworming Information -->
    <Deworming :child="child" />

    <!-- Dental Information -->
    <Dental :child="child" />

    <!-- ECCD Card Information -->
   

</template>

<style scoped>
.no-data {
    text-transform: none;
}
.scrollable-table {
    max-height: 350px;
    overflow-y: auto;
    margin-top: 10px;
    scroll-snap-type: y mandatory;
}
.scrollable-table > .data-table {
    width: 100%;
}
.add-vac {
    font-size: 18px;
    font-weight: bold;
}
.add-button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 5px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin-top: 0;
    margin-bottom: -25px;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s ease;
    margin-left: 10px;
}
.add-button:hover {
    background-color: #45a049;
}
.name-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 2px solid #ddd;
}
.t-btn {
    margin-top: 22px;
}
.child-head {
    font-size: 20px;
    margin-top: 15px;
}
.container {
    max-width: 100%;
    padding: 20px;
    margin-top: 0;
    margin-bottom: 5%;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
}
.info-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-size: 14px;
}
.info-table thead th {
    position: sticky;
    top: -1px;
}
.info {
    font-weight: bold;
    color: #333;
    max-width: 10px;
}
.data {
    color: #333;
    max-width: 30px;
    background-color: #f4f4f4;
    padding: 0;
    margin: 0;
}
.info-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}
.info-table td:first-child {
    text-align: left;
    font-weight: bold;
    width: 30%;
    text-transform: capitalize;
}
.info-table td.info, .info-table td.data {
    text-align: left;
}
.info-table th {
    background-color: #f4f4f4;
    padding: 10px;
    text-align: center;
    font-weight: bold;
}
.info-table tr:hover {
    background-color: #f1f1f1;
}
h1 {
    color: #488a99;
    font-size: 16px;
    padding-bottom: 10px;
    font-weight: bold;
    width: 100%;
}
button {
    padding: 5px 10px;
    font-size: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #488a99;
    color: white;
    cursor: pointer;
    margin-bottom: 10px;
}
button:hover {
    background-color: #3a6f7a;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
.button-container {
    text-align: right;
    margin-bottom: 10px;
}
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}
.modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    max-width: 90%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    animation: slide-down 0.3s ease-out;
}
.modal-content h2 {
    margin-top: 0;
    font-size: 18px;
    color: #333;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}
.modal-content label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
    color: #555;
}
.modal-content input,
.modal-content select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
.modal-content .button-container {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
}
.modal-content .button-container button {
    margin-left: 10px;
    padding: 8px 12px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.modal-content .button-container button[type="submit"] {
    background-color: #4CAF50;
    color: white;
}
.modal-content .button-container button[type="submit"]:hover {
    background-color: #45a049;
}
.modal-content .button-container button[type="button"] {
    background-color: #f44336;
    color: white;
}
.modal-content .button-container button[type="button"]:hover {
    background-color: #e53935;
}
@keyframes slide-down {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
.flash-modal {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #4CAF50;
    color: white;
    padding: 15px 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}
.flash-content {
    font-size: 16px;
    font-weight: bold;
}
</style>