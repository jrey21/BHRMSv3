<template>
    <div v-if="child">
        <h1>Child's Information</h1>
        <div>
            <table class="info-table">
                <tbody>
                    <tr>
                        <td class="info">Full Name:</td><td class="data">{{ child.first_name }} {{ child.middle_name }} {{ child.last_name }} {{ child.suffix }}</td>
                        <td class="info">Gestational Age At Birth:</td><td class="data">{{ child.gestational_age }}</td>
                    </tr>
                    <tr>
                        <td class="info">Complete Address:</td><td class="data">{{ child.complete_address }}</td>
                        <td class="info">Type Of Birth:</td><td class="data">{{ child.type_of_birth }}</td>
                    </tr>
                    <tr>
                        <td class="info">Birth Date:</td><td class="data">{{ formattedBirthDate }}</td> 
                        <td class="info">Birth Order:</td><td class="data">{{ child.birth_order }}</td>
                    </tr>
                    <tr>
                        <td class="info">Birth Place:</td><td class="data">{{ child.birth_place }} {{ child.other_birth_place }}</td>
                        <td class="info">Family No.:</td><td class="data">{{ child.family_no }}</td>
                    </tr>
                    <tr>
                        <td class="info">Birth Weight:</td><td class="data">{{ child.birth_weight }}</td>
                        <td class="info">Child No.:</td><td class="data">{{ child.child_no }}</td>
                    </tr>
                    <tr>
                        <td class="info">Birth Length:</td><td class="data">{{ child.birth_length }}</td>
                        <td class="info">Birth Attendant:</td><td class="data">{{ child.birth_attendant }} {{ child.other_birth_attendant }}</td>
                    </tr>
                    <tr>
                        <td class="info">Birth Registered:</td><td class="data">{{ child.birth_registered }}</td>
                    </tr>
                </tbody>
            </table>
            <h1>Mother's Information</h1>
            <table class="info-table">
                <tbody>
                    <tr>
                        <td class="info">Full Name:</td><td class="data">{{ child.mother_name }}</td>
                        <td class="info">Education:</td><td class="data">{{ child.mother_education }}</td>
                    </tr>
                    <tr>
                        <td class="info">No. Of Pregnancies:</td><td class="data">{{ child.no_pregancies }}</td>
                        <td class="info">Occupation:</td><td class="data">{{ child.mother_occupation }}</td>
                    </tr>
                </tbody>
            </table>
            <h1>Father's Information</h1>
            <table class="info-table">
                <tbody>
                    <tr>
                        <td class="info">Full Name:</td><td class="data">{{ child.father_name }}</td>
                    </tr>
                    <tr>
                        <td class="info">Education:</td><td class="data">{{ child.father_education }}</td>
                    </tr>
                    <tr>
                        <td class="info">Occupation:</td><td class="data">{{ child.father_occupation }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { defineProps, computed } from 'vue';

const props = defineProps({
    child: { type: Object, required: true },
});

const formattedBirthDate = computed(() => {
    const date = new Date(props.child.birth_date);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
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
</style>