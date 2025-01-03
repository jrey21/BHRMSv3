<script setup>
import { useForm } from '@inertiajs/vue3';
import Forms from '../../Layouts/Forms.vue';
import { ref } from 'vue';
import OptimumPractice from './OptimumPractice.vue';

defineOptions({ layout: Forms });

const form = useForm({
    pinkCardNumber: null,
    date: null,
    zone: null,
    fullName: null,
    birth_date: null,
    age: null,
    education: null,
    occupation: null,
    term_of_pregnancy: null,
    number_of_pregnancy: null,
    date_last_delivery: null,
    number_of_children: null,
    interval_of_delivery: null,
    muac: null,
    height: null,
    weight: null,
    bmi: null,
    ns: null,
    name_of_husband: null,
    husband_age: null,
    husband_education: null,
    husband_occupation: null,
    monthly_family_income: null,
    household_size: null,
});

const showModal = ref(false);
const modalMessage = ref('');
const modalTitle = ref('');

// Define a simple flash message function
window.flash = (message, type) => {
    const flashMessage = document.createElement('div');
    flashMessage.className = `flash-message ${type}`;
    flashMessage.innerText = message;
    document.body.appendChild(flashMessage);
    setTimeout(() => {
        flashMessage.remove();
    }, 3000);
};

const submit = () => {
    form.post(route('pnea-enrollment'), {
        onSuccess: () => {
            modalTitle.value = 'Success';
            modalMessage.value = 'The form has been successfully saved.';
            showModal.value = true;
            window.flash('The form has been successfully saved.', 'success');

            alert('Data has been added successfully!');
        },
        onError: (errors) => {
            const errorMessage = JSON.stringify(errors, null, 2).replace(/localhost|127\.0\.0\.1:8000/g, '');
            modalTitle.value = 'Error';
            modalMessage.value = 'An error occurred while saving the form. Please review the following errors: ' + errorMessage;
            showModal.value = true;
            window.flash('An error occurred while saving the form. Please review the errors.', 'error');
        }
    });
};

const closeModal = () => {
    showModal.value = false;
};

const redirectToDashboard = () => {
    if (confirm('Do you really want to cancel?')) {
        window.location.href = route('pnea-enrollment-view');
    }
};

const redirectToEnrollmentView = () => {
    window.location.href = route('pnea-enrollment-view');
};

const today = new Date().toISOString().split('T')[0];

</script>

<template>
    <h1>Personal Information</h1>
    <div class="card">
        <table>
            <tr>
                <td><strong>Name of Mother:</strong></td>
                <td><input v-model="form.fullName" type="text" /></td>
                <td><strong>Birthdate:</strong></td>
                <td><input v-model="form.birth_date" type="date" /></td>
                <td><strong>Age:</strong></td>
                <td><input v-model="form.age" type="number" /></td>
            </tr>
            <tr>
                <td><strong>Educational Level:</strong></td>
                <td><input v-model="form.education" type="text" /></td>
                <td><strong>MUAC:</strong></td>
                <td><input v-model="form.muac" type="number" /></td>
            </tr>
            <tr>
                <td><strong>Occupation:</strong></td>
                <td><input v-model="form.occupation" type="text" /></td>
                <td><strong>Height:</strong></td>
                <td><input v-model="form.height" type="number" /></td>
            </tr>
            <tr>
                <td><strong>Term of Pregnancy:</strong></td>
                <td><input v-model="form.term_of_pregnancy" type="text" /></td>
                <td><strong>Weight:</strong></td>
                <td><input v-model="form.weight" type="number" /></td>
            </tr>
            <tr>
                <td><strong>Number of Pregnancy:</strong></td>
                <td><input v-model="form.number_of_pregnancy" type="number" /></td>
                <td><strong>BMI:</strong></td>
                <td><input v-model="form.bmi" type="number" /></td>
            </tr>
            <tr>
                <td><strong>Number of Children:</strong></td>
                <td><input v-model="form.number_of_children" type="number" /></td>
                <td><strong>NS:</strong></td>
                <td><input v-model="form.ns" type="text" /></td>
            </tr>
            <tr>
                <td><strong>Name of Husband:</strong></td>
                <td><input v-model="form.name_of_husband" type="text" /></td>
                <td><strong>Date of last Delivery:</strong></td>
                <td><input v-model="form.date_last_delivery" type="date" /></td>
            </tr>
            <tr>
                <td><strong>Occupation of Husband:</strong></td>
                <td><input v-model="form.husband_occupation" type="text" /></td>
                <td><strong>Interval of Delivery:</strong></td>
                <td><input v-model="form.interval_of_delivery" type="text" /></td>
            </tr>
            <tr>
                <td><strong>Monthly Family Income:</strong></td>
                <td><input v-model="form.monthly_family_income" type="number" /></td>
                <td><strong>Household Size:</strong></td>
                <td><input v-model="form.household_size" type="number" /></td>
            </tr>
        </table>
    </div>
</template>

<style scoped>
h1 {
    color: #488a99;
    font-size: 24px;
    padding-top: 20px;
    padding-bottom: 10px;
    font-weight: bold;
    text-align: left;
    border-bottom: 2px solid #488a99;
    margin-bottom: 20px;
}
.card {
    background-color: #fff;
    padding: 20px;
    margin: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
table {
    width: 100%;
    border-collapse: collapse;
}
td {
    padding: 10px;
    vertical-align: top;
}
input[type="text"], input[type="date"], input[type="number"] {
    width: 100%;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>