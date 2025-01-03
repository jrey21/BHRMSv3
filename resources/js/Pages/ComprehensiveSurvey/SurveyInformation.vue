<template>
    <div v-if="comprehensiveSurvey">
        <h1>Personal Information</h1>
        <div>
            <table class="info-table">
                <tbody>
                    <tr>
                        <td class="info">Full Name:</td><td class="data">{{ comprehensiveSurvey.first_name }} {{ comprehensiveSurvey.middle_name }} {{ comprehensiveSurvey.last_name }} {{ comprehensiveSurvey.suffix }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    comprehensiveSurvey: { type: Object, required: true },
});
</script>

<style scoped>

.info-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-size: 14px;
}
.info-table thead th{
    position:sticky;
    top:-1px;
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
.info-table td:first-comprehensiveSurvey {
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
</style>