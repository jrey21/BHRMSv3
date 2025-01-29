<script setup>
import { defineProps, ref, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import FormLayout from '../../Layouts/FormLayout.vue';
import axios from 'axios';

defineOptions({
    layout: FormLayout,
});

const props = defineProps({
    survey: { type: Object, required: true },
});

const suffix = computed(() => props.survey.suffix || '-');
const router = useRouter();

const formattedBirthDate = computed(() => {
    const date = new Date(props.survey.birth_date);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
});

const computeAge = (birthDate) => {
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDifference = today.getMonth() - birth.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birth.getDate())) {
        age--;
    }
    if (age < 1) {
        const months = (today.getFullYear() - birth.getFullYear()) * 12 + today.getMonth() - birth.getMonth();
        return { value: months, unit: months === 1 ? 'month' : 'months' };
    }
    return { value: age, unit: age === 1 ? 'year' : 'years' };
};

const age = computed(() => computeAge(props.survey.birth_date));

</script>

<template>
    <Head title=" | Comprehensive Survey Data" />

    <div class="tables-container">
        <div class="table-wrapper">
            <div class="header-with-button">
                <h1 class="personal-head text-slate-500">I. Personal Information</h1>
                <div>
                    <!-- <button class="edit-button"><i class="fa fa-edit"></i></button> -->
                    <!-- <button class="delete-button" @click="handleDelete"><i class="fa fa-trash"></i></button> -->
                </div>
            </div>
            <table class="info-table">
                <tr><td class="label">Last Name: </td><td>{{ survey.last_name }}</td></tr>
                <tr><td class="label">First Name: </td><td>{{ survey.first_name }}</td></tr>
                <tr><td class="label">Middle Name: </td><td>{{ survey.middle_name }}</td></tr>
                <tr><td class="label">Suffix: </td><td>{{ suffix }}</td></tr>
                <tr><td class="label">Birthdate: </td><td>{{ formattedBirthDate }}</td></tr>
                <tr><td class="label">Age: </td><td>{{ age.value }} {{ age.unit }}</td></tr>
                <tr><td class="label">Sex: </td><td>{{ survey.sex }}</td></tr>
                <tr><td class="label">Civil Status: </td><td>{{ survey.civil_status }}</td></tr>
                <tr><td class="label">Religion: </td><td>{{ survey.religion }}</td></tr>
                <tr><td class="label">Occupation: </td><td>{{ survey.occupation }}</td></tr>
                <tr><td class="label">Educational Attainment: </td><td>{{ survey.education }}</td></tr>
            </table>
        </div>

        <div class="table-wrapper">
            <h1 class="personal-head text-slate-500">II. Other Information</h1>
            <table class="info-table">
                <tr><td class="label">Zone: </td><td>{{ survey.zone }}</td></tr>
                <tr><td class="label">H/H Access to Sanitary: </td><td>{{ survey.sanitary_access }}</td></tr>
                <tr><td class="label">Water Sources: </td><td>{{ survey.water_source }}</td></tr>
                <tr><td class="label">Family Planning Used: </td><td>{{ survey.family_planning }}</td></tr>
                <tr><td class="label">Are you a member of the LGBT community?: </td><td>{{ survey.lgbt ? 'Yes' : 'No' }}</td></tr>
                <tr><td class="label">Do you identify as a (PWD)?: </td><td>{{ survey.pwd ? 'Yes' : 'No' }}</td></tr>
                <tr><td class="label">Are you a member of 4'Ps? : </td><td>{{ survey.four_ps ? 'Yes' : 'No' }}</td></tr>
                <tr><td class="label">Are you Non-HTS?: </td><td>{{ survey.non_hts ? 'Yes' : 'No' }}</td></tr>
            </table>
        </div>
    </div>
</template>

<style>
.personal-head{
    font-size: 20px;
    margin-bottom: 15px;
}

.header-with-button {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.edit-button {
    background-color: #ffc107;
    margin-bottom: 15px;
    color: white;
    border: none;
    padding: 3px 8px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.edit-button:hover {
    background-color:#e0a800;
}

.delete-button {
    background-color: #dc3545;
    margin-bottom: 15px;
    color: white;
    border: none;
    padding: 3px 8px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.delete-button:hover {
    background-color: #c82333;
}

.info-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-size: 14px;
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
}
.info-table thead th{
    position:sticky;
    top:0;
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    text-align: left;
    font-weight: bold;
    border-bottom: 2px solid #ddd;
}
.info-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left; 
    transition: background-color 0.3s ease;
}
.info-table td:first-child {
    text-align: left; 
    font-weight: bold;
    width:45%;
    text-transform: capitalize;
}
.info-table td.info, .info-table td.data {
    text-align: left;
}
.info-table th {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    text-align: left; 
    font-weight: bold;
}
.info-table tr:nth-child(even) {
    background-color: #f2f2f2;
}
.info-table tr:hover {
    background-color: #ddd;
}
.label{
    font-weight: bold;
    text-transform: capitalize;
    text-align: left;
    padding: 10px;
    width: 40%;
    background-color: #f9f9f9;
}

.tables-container {
    width: 120%;
    display: flex;
    flex-direction: row;
    gap: 20px;
    padding: 20px;
    background-color: #f4f4f4;
    border-radius: 8px;
    margin-top: 20px;
}

.table-wrapper {
    width: 100%;
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}
.table-wrapper:hover {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}
</style>