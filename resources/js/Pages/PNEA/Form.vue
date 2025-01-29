<script setup>
import { useForm } from '@inertiajs/vue3';
import FormLayout from '../../Layouts/FormLayout.vue';
// import OptimumPractice from './OptimumPractice.vue';
import { ref, watch } from 'vue';

defineOptions({ layout: FormLayout });

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
const showCancelModal = ref(false);
const cancelMessage = ref('Do you really want to cancel?');
const formSubmittedSuccessfully = ref(false);

const flashMessage = (message, type) => {
    const flash = document.createElement('div');
    flash.className = `flash-message ${type}`;
    flash.innerText = message;
    document.body.appendChild(flash);
    setTimeout(() => flash.remove(), 3000);
};

const submit = () => {
    form.post(route('pnea-enrollment'), {
        onSuccess: () => {
            formSubmittedSuccessfully.value = true;
            modalTitle.value = 'Success';
            modalMessage.value = 'The form has been successfully saved.';
            showModal.value = true;
            flashMessage('The form has been successfully saved.', 'success');
            window.location.href = route('pnea-enrollment-view');
        },
        onError: (errors) => {
            formSubmittedSuccessfully.value = false;
            modalTitle.value = 'Error';
            modalMessage.value = 'An error occurred while saving the form. Please review the following errors: ' + JSON.stringify(errors, null, 2);
            showModal.value = true;
            flashMessage('An error occurred while saving the form. Please review the errors.', 'error');
        }
    });
};

const closeModal = () => showModal.value = false;

const redirectToDashboard = () => {
    showCancelModal.value = true;
};

const confirmCancel = () => {
    // window.location.href = route('pnea-enrollment-view');
    form.get(route('pnea-enrollment-view'));
};

const today = new Date().toISOString().split('T')[0];

const calculateBMI = () => {
    if (form.weight && form.height) {
        const heightInMeters = form.height / 100;
        form.bmi = (form.weight / (heightInMeters * heightInMeters)).toFixed(2);
    }
};

const calculateAge = (birthDate) => {
    const today = new Date();
    const birthDateObj = new Date(birthDate);
    let age = today.getFullYear() - birthDateObj.getFullYear();
    const monthDifference = today.getMonth() - birthDateObj.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDateObj.getDate())) {
        age--;
    }
    return age;
};

// Watchers to automatically calculate BMI when weight or height changes
watch(() => form.weight, calculateBMI);
watch(() => form.height, calculateBMI);

// Watcher to automatically calculate age when birth_date changes
watch(() => form.birth_date, (newBirthDate) => {
    form.age = calculateAge(newBirthDate);
});

</script>

<template>
    <Head title=" | PNEA Enrollment Form"/>
    <div class="survey-container">
        <!-- <div class="header"> -->
            <h2>PNEA Enrollment Form</h2>
        <!-- </div> -->
        <form @submit.prevent="submit">
            <div class="form-section">
                <div class="form-group small-input">
                    <label for="date">Registration Date</label>
                    <input type="date" name="date" v-model="form.date" required/>
                </div>
                <div class="form-group small-input right-align">
                    <label for="pinkCardNumber">Pink Card Number</label>
                    <input type="text" name="pinkCardNumber" v-model="form.pinkCardNumber" required/>
                </div>
                <div class="form-group small-input-zone">
                    <label for="zone">Zone</label>
                    <select name="zone" id="zone" v-model="form.zone">
                        <option value=""></option>
                        <option value="Zone 1">Zone 1</option>
                        <option value="Zone 2">Zone 2</option>
                        <option value="Zone 3">Zone 3</option>
                        <option value="Zone 4">Zone 4</option>
                        <option value="Zone 5">Zone 5</option>
                        <option value="Zone 6">Zone 6</option>
                        <option value="Zone 7">Zone 7</option>
                    </select>
                </div>
            </div>
            <div class="form-section">
                <div class="form-group large-input-mother">
                    <label for="fullName">Name of Mother</label>
                    <input type="text" name="fullName" v-model="form.fullName" required/>
                </div>
                <div class="form-group small-input right-align">
                    <label for="birth_date">Birth Date</label>
                    <input type="date" name="birth_date" v-model="form.birth_date" :max="today" required/>
                </div>
                <div class="form-group small-input-age right-align">
                    <label for="age">Age</label>
                    <input type="number" name="age" v-model="form.age" readonly/>
                </div>
            </div>
            <div class="form-section">
                <div class="form-group medium-input-education">
                    <label for="education">Educational Level</label>
                    <select name="education" v-model="form.education" required>
                        <option value=""></option>
                        <option value="None">N/A</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Highschool">High School</option>
                        <option value="College">College</option>
                        <option value="Postgraduate">Post Graduate</option>
                    </select>
                </div>
                <div class="form-group medium-input-occupation">
                    <label for="occupation">Occupation</label>
                    <input type="text" name="occupation" v-model="form.occupation" required/>
                </div>
                <div class="form-group small-input">
                    <label for="term_of_pregnancy">Term of Pregnancy</label>
                    <input type="text" name="term_of_pregnancy" v-model="form.term_of_pregnancy" required/>
                </div>
                <div class="form-group">
                    <label for="number_of_pregnancy">Number of Pregnancy</label>
                    <input type="number" name="number_of_pregnancy" v-model="form.number_of_pregnancy" required/>
                </div>
            </div>
            <div class="form-section">
                <div class="form-group">
                    <label for="date_last_delivery">Date of Last Delivery</label>
                    <input type="date" name="date_last_delivery" v-model="form.date_last_delivery" required/>
                </div>
                <div class="form-group">
                    <label for="number_of_children">Number of Children</label>
                    <input type="number" name="number_of_children" v-model="form.number_of_children" required/>
                </div>
                <div class="form-group">
                    <label for="interval_of_delivery">Interval of Delivery</label>
                    <input type="text" name="interval_of_delivery" v-model="form.interval_of_delivery" required/>
                </div>
                <div class="form-group">
                    <label for="muac">MUAC</label>
                    <input type="text" name="muac" v-model="form.muac" required/>
                </div>
            </div>
            <div class="form-section">
                <div class="form-group">
                    <label for="height">Height (cm)</label>
                    <input type="number" name="height" v-model="form.height" required/>
                </div>
                <div class="form-group">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" name="weight" v-model="form.weight" required/>
                </div>
                <div class="form-group">
                    <label for="bmi">BMI</label>
                    <input type="number" name="bmi" v-model="form.bmi" readonly/>
                </div>
                <div class="form-group">
                    <label for="ns">NS</label>
                    <input type="text" name="ns" v-model="form.ns" required/>
                </div>
            </div>
            <div class="form-section">
                <div class="form-group">
                    <label for="name_of_husband">Name of Husband</label>
                    <input type="text" name="name_of_husband" v-model="form.name_of_husband" required/>
                </div>
                <div class="form-group small-input">
                    <label for="husband_age">Husband's Age</label>
                    <input type="number" name="husband_age" v-model="form.husband_age" required/>
                </div>
            </div>
            <div class="form-section">
                <div class="form-group medium-input-education">
                    <label for="husband_education">Educational Level</label>
                    <select name="husband_education" v-model="form.husband_education" required>
                        <option value=""></option>
                        <option value="None">N/A</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Highschool">High School</option>
                        <option value="College">College</option>
                        <option value="Postgraduate">Post Graduate</option>
                    </select>
                </div>
                <div class="form-group medium-input-occupation">
                    <label for="husband_occupation">Occupation</label>
                    <input type="text" name="husband_occupation" v-model="form.husband_occupation" required/>
                </div>
                <div class="form-group">
                    <label for="monthly_family_income">Monthly Family Income</label>
                    <input type="text" name="monthly_family_income" v-model="form.monthly_family_income" required/>
                </div>
                <div class="form-group">
                    <label for="household_size">Household Size</label>
                    <input type="number" name="household_size" v-model="form.household_size" required/>
                </div>
            </div>
            <div class="form-row-buttons">
                <button type="button" @click="redirectToDashboard" class="cancel-button">Cancel</button>
                <button type="submit" class="save-button">Save</button>
            </div>
        </form>   

        <!-- Modal -->
        <div v-if="showModal" :class="['modal', formSubmittedSuccessfully ? 'modal-success' : 'modal-error']">
            <div class="modal-content-success" v-if="formSubmittedSuccessfully">
                <h2 style="color: white;">{{ modalTitle }}</h2>
                <p>{{ modalMessage }}</p>
            </div>
            <div class="modal-content-error" v-else>
                <h2 style="color: white;">{{ modalTitle }}</h2>
                <p>{{ modalMessage }}</p>
            </div>
        </div>
        <!-- Cancel Confirmation Modal -->
        <div v-if="showCancelModal" class="modal">
            <div class="modal-content">
                <h2 style="margin-bottom: 7px;">Cancel Confirmation</h2>
                <hr style="margin-bottom: 10px;">
                <p>{{ cancelMessage }}</p>
                <div class="modal-btn">
                    <button @click="confirmCancel" class="save-button">Yes</button>
                    <button @click="showCancelModal = false" class="cancel-button">No</button>
                </div>
            </div>
        </div>
    </div>
    <!-- <OptimumPractice/> -->
</template>

<style scoped>
.survey-container {
    width: 100%;
    padding: 20px;
    margin: 1% 0 15% 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-left: 10%;
}

.header {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    margin-top: 0;
    width: 90%;
}

h2 {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    color: #1c4e80;
    margin-bottom: 20px;
}

label {
    color: #555;
    display: block;
    margin-bottom: 3px;
}

.form-section {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 10px;
}

.form-group {
    flex: 1;
    width: 100%;
    margin-right: 10px;
}

.form-group:last-child {
    margin-right: 0;
}

input, select, textarea {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    transition: border-color 0.3s;
}

input:focus, select:focus, textarea:focus {
    border-color: #007bff;
    outline: none;
}

textarea {
    resize: vertical;
    max-width: 25%;
    max-height: 100px;
}

.small-input {
    flex: 0 0 200px;
}

.small-input-age {
    flex: 0 0 100px;
}

.small-input-zone {
    flex: 0 0 100px;
}

.medium-input-education {
    flex: 0 0 200px;
}

.medium-input-occupation {
    flex: 0 0 300px;
}

.large-input-mother {
    flex: 0 0 600px;
}

.right-align {
    margin-left: auto;
}

.form-row-buttons {
    display: flex;
    justify-content: space-between;
}

.save-button, .cancel-button {
    display: block;
    padding: 8px 5px;
    margin-top: 5%;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 20%;
    font-size: 16px;
    transition: background-color 0.3s;
}

.save-button {
    background-color: #007bff;
}

.cancel-button {
    background-color: #dc3545;
}

.save-button:hover {
    background-color: #0056b3;
}

.cancel-button:hover {
    background-color: #c82333;
}

.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-success {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}
.modal-error {
    background-color: rgba(0, 0, 0, 0.4); /* Change to semi-transparent black */
    color: white;
}
.modal-btn{
    display: flex;
    justify-content: center;
    gap: 10px;
}

.modal-content-success {
    background-color: #28a745;
    color: white;
    margin: auto;
    padding: 20px;
    border: 1px solid #28a745;
    width: 70%;
    max-width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(74, 220, 79, 0.1);
    text-align: center;
}
.modal-content-error {
    background-color: #dc3545;
    color: white;
    margin: auto;
    padding: 20px;
    border: 1px solid #dc3545;
    width: 70%;
    max-width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.1);
    text-align: center;
    top: 0;
}
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 70%;
    max-width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.flash-message {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 10px 20px;
    border-radius: 5px;
    color: #fff;
    z-index: 1000;
    opacity: 0.9;
    transition: opacity 0.3s ease;
}

.flash-message.success {
    background-color: #28a745;
}

.flash-message.error {
    background-color: #dc3545;
}
</style>