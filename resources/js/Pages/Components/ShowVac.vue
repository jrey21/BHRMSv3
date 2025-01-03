<script setup>
import { defineProps, ref } from 'vue';
import FormLayout from '../../Layouts/FormLayout.vue';

defineOptions({ layout: FormLayout });

const props = defineProps({
  child: Object,
});


</script>

<template>
    <transition name="fade">
        <div v-if="showFlashMessage" class="flash-modal">
            <div class="flash-content">{{ flashMessage }}</div>
        </div>
    </transition>
    <div class="container">
        <h1>Vaccination Information</h1>
        <table class="info-table">
            <thead>
                <tr>
                    <th>Vaccine</th>
                    <th>Dose 1</th>
                    <th>Dose 2</th>
                    <th>Dose 3</th>
                    <th>Booster</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="!child.vaccinationRecords || child.vaccinationRecords.length === 0">
        <td colspan="6">There is no available data</td>
            </tr>
            <tr v-else v-for="vaccine in child.vaccinationRecords" :key="vaccine.id">
                <td>{{ vaccine.name }}</td>
                <td>{{ vaccine.dose1 }}</td>
                <td>{{ vaccine.dose2 }}</td>
                <td>{{ vaccine.dose3 }}</td>
                <td>{{ vaccine.booster }}</td>
                <td>{{ vaccine.status }}</td>
            </tr>

            </tbody>
        </table>
    </div>
</template>

<style scoped>

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.t-btn{
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
    margin-bottom: 15%;
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
.info{
    font-weight: bold;
    color: #333;
    max-width: 10px;
}
.data{
    color: #333;
    max-width: 30px;
    background-color: #f4f4f4;
    padding: 0;
    margin: 0;
}   

.info-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.info-table th {
    background-color: #f4f4f4;
    padding: 10px;
    text-align: left;
    font-weight: bold;
}

.info-table tr:hover {
    background-color: #f1f1f1;
}

.info-table td:first-child {
    font-weight: bold;
    width: 30%;
    text-transform: capitalize;
}

h1 {
    color: #488a99;
    font-size: 16px;
    border-bottom: 2px solid #ddd;
    padding-bottom: 10px;
    font-weight: bold;
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
</style>