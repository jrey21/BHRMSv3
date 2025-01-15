<script setup>
import { useForm } from '@inertiajs/vue3';
import FormLayout from '../../Layouts/FormLayout.vue';
import { ref } from 'vue';

defineOptions({ layout: FormLayout });

const form = useForm({
    family_no: null,
    child_no: null,
    zone: null,
    complete_address: null,
    last_name: null,
    first_name: null,
    middle_name: null,
    suffix: null,
    mother_name: null,
    mother_education: null,
    mother_occupation: null,
    no_pregancies: null,
    father_name: null,
    father_education: null,
    father_occupation: null,
    birth_date: null,
    gestational_age: null,
    type_of_birth: null,
    birth_order: null,
    birth_weight: null,
    birth_length: null,
    birth_place: null,
    other_birth_place: null,
    birth_registered: null,
    birth_attendant: null,
    other_birth_attendant: null,
});

const showModal = ref(false);
const modalMessage = ref('');
const modalTitle = ref('');
const showCancelModal = ref(false);
const cancelMessage = ref('Do you really want to cancel?');
const formSubmittedSuccessfully = ref(false);

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

const capitalizeFirstLetter = (string) => {
    return string.replace(/\b\w/g, char => char.toUpperCase());
};

const capitalizeFormFields = () => {
    for (const key in form) {
        if (typeof form[key] === 'string') {
            form[key] = capitalizeFirstLetter(form[key]);
        }
    }
};

const submit = () => {
    capitalizeFormFields();
    form.post(route('childcare-form'), {
        onSuccess: () => {
            formSubmittedSuccessfully.value = true;
            modalTitle.value = 'SUCCESS!';
            modalMessage.value = 'The form has been successfully saved!';
            showModal.value = true;
            window.flash('The form has been successfully saved!', 'success');

            window.location.href = route('childcare-form-view'); 
        },
        onError: (errors) => {
            formSubmittedSuccessfully.value = false;
            const errorMessages = Object.values(errors).map(error => `${error}`).join(' ');
            modalTitle.value = 'Failed to submit data!';
            modalMessage.value = errorMessages;
            showModal.value = true;
            window.flash('An error occurred while saving the form. Please review the errors.', 'error');
        }
    });
};

const closeModal = () => {
    showModal.value = false;
};

const redirectToDashboard = () => {
    showCancelModal.value = true;
};

const confirmCancel = () => {
    window.location.href = route('childcare-form-view');
};

const today = new Date().toISOString().split('T')[0];

</script>

<template>
    <Head title=" | Child Care Form"/>
    <div :class="['survey-container', { 'form-success': formSubmittedSuccessfully }]">
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
        <div style="display: flex; align-items: center; justify-content: center;">
                <img src="C:\xampp\htdocs\BHRMSv3\resources\js\Pages\Components\image\doh_logo.png" alt="" class="logo" />
                <h2 style="text-align: center; color: #1c4e80">Early Childhood Care and Development</h2>
            </div>

            
        <div class="form-row-head">
                <div class="form-group medium-input">
                    <label for="family_no">Family No.</label>
                    <input type="text" name="family_no" v-model="form.family_no" required/>
                </div>
            <div class="form-group medium-input-child-no">
                    <label for="child_no">Child's No.</label>
                    <input type="text" name="child_no" v-model="form.child_no" required/>
                </div>
            <div class="form-group medium-input zone-input">
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
        <form @submit.prevent="submit">
            <div class="form-group">
                <label for="complete_address">Complete Address (House No., Street, City/Province)</label>
                <input type="text" name="complete_address" v-model="form.complete_address" required/>
            </div>
            <h1>Child's Name</h1>
            <div class="form-row">
                <div class="form-group medium-input-hhn">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" v-model="form.last_name" required/>
                </div>
                <div class="form-group medium-input-hhn">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" v-model="form.first_name" required/>
                </div>
                <div class="form-group medium-input-hhn">
                    <label for="middle_name">Middle Name</label>
                    <input type="text" name="middle_name" v-model="form.middle_name" required/>
                </div>
                <div class="form-group-suffix small-input-suffix">
                    <label for="suffix">Suffix</label>
                    <select name="suffix" v-model="form.suffix">
                        <option value=""></option>
                        <option value="Jr.">Jr.</option>
                        <option value="Sr.">Sr.</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                    </select>
                </div>
            </div>
            <div class="line"></div>
            <!-- Mothers Info -->
            <h1>Mother's Information</h1>
            <div class="form-group medium-input-hhn">
                <label for="mother_name">Mother's Name</label>
                <input type="text" name="mother_name" v-model="form.mother_name" required/>
            </div>
            <div class="form-row">
                <div class="form-group medium-input-education">
                    <label for="mother_education">Educational Level</label>
                    <select name="mother_education" v-model="form.mother_education" required>
                        <option value=""></option>
                        <option value="none">N/A</option>
                        <option value="elementary">Elementary</option>
                        <option value="highschool">High School</option>
                        <option value="college">College</option>
                        <option value="postgraduate">Postgraduate</option>
                    </select>
                </div>
                <div class="form-group medium-input-occupation">
                    <label for="mother_occupation">Occupation</label>
                    <input type="text" name="mother_occupation" v-model="form.mother_occupation" required/>
                </div>
                <div class="form-group medium-input-noPreg">
                    <label for="no_pregancies"> No.of Pregnancies</label>
                    <input type="number" name="no_pregancies" v-model="form.no_pregancies" required/>
                </div>
            </div>
            <!-- Father's Info -->
            <h1>Father's Information</h1>
            <div class="form-group medium-input-hhn">
                <label for="father_name">Father's Name</label>
                <input type="text" name="father_name" v-model="form.father_name" required/>
            </div>
            <div class="form-row">
                <div class="form-group medium-input-father-educ">
                    <label for="father_education">Educational Level</label>
                    <select name="father_education" v-model="form.father_education" required>
                        <option value=""></option>
                        <option value="none">N/A</option>
                        <option value="elementary">Elementary</option>
                        <option value="highschool">High School</option>
                        <option value="college">College</option>
                        <option value="postgraduate">Postgraduate</option>
                    </select>
                </div>
                <div class="form-group occupation">
                    <label for="father_occupation">Occupation</label>
                    <input type="text" name="father_occupation" v-model="form.father_occupation" required/>
                </div>
            </div>
            <div class="line"></div>

            <!-- Other Info -->
            <div class="form-row">
                <div class="form-group">
                    <label for="birth_date">Birth Date</label>
                    <input type="date" name="birth_date" v-model="form.birth_date" :max="today" required/>
                </div>
                <div class="form-group">
                    <label for="birth_registered">Date of Birth Registration</label>
                    <input type="date" name="birth_registered" v-model="form.birth_registered" :max="today" required/>
                </div>
                <div class="form-group">
                    <label for="gestational_age">Gestational Age at Birth</label>
                    <select name="gestational_age" v-model="form.gestational_age" required>
                        <option value=""></option>
                        <option value="less than 28 weeks">Less than 28 weeks</option>
                        <option value="28-31 weeks">28-31 weeks</option>
                        <option value="32-36 weeks">32-36 weeks</option>
                        <option value="37-38 weeks">37-48 weeks</option>
                        <option value="39-40 weeks">39-40 weeks</option>
                        <option value="41 weeks">41 weeks</option>
                        <option value="42 weeks or more">42 weeks or more</option>
                    </select>
                </div>
                <div class="form-group  birth-type">
                    <label for="type_of_birth">Type of Birth</label>
                    <select name="type_of_birth" v-model="form.type_of_birth" required>
                        <option value=""></option>
                        <option value="normal">Normal</option>
                        <option value="cesarean">CS</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="birth_weight">Birth Order</label>
                    <input type="number" name="birth_order" v-model="form.birth_order" required/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="birth_weight">Birth Weight (kg)</label>
                    <input type="number" name="birth_weight" v-model="form.birth_weight" step="0.01" required/>
                </div>
                <div class="form-group">
                    <label for="birth_length">Birth Length (cm)</label>
                    <input type="number" name="birth_length" v-model="form.birth_length" step="0.01" required/>
                </div>
                <div class="form-group">
                    <label for="birth_place">Place of Delivery</label>
                    <select name="birth_place" v-model="form.birth_place" required>
                        <option value=""></option>
                        <option value="home">Home</option>
                        <option value="hospital">Hospital</option>
                        <option value="lying-in">Lying-in</option>
                        <option value="others">Others</option>
                    </select>
                    <input v-if="form.birth_place === 'others'" type="text" name="other_birth_place" v-model="form.other_birth_place" placeholder="Please specify" style="margin-top:2px" required/>
                </div>
                <div class="form-group">
                    <label for="birth_attendant">Birth Attendant</label>
                    <select name="birth_attendant" v-model="form.birth_attendant" required>
                        <option value=""></option>
                        <option value="doctor">Doctor</option>
                        <option value="midwife">Midwife</option>
                        <option value="nurse">Nurse</option>
                        <option value="hilot">Hilot</option>
                        <option value="others">Others</option>
                    </select>
                    <input v-if="form.birth_attendant === 'others'" type="text" name="other_birth_attendant" v-model="form.other_birth_attendant" placeholder="Please specify" style="margin-top:2px" required/>
                </div>
            </div>
            <div class="form-row-buttons">
                <button type="button" @click="redirectToDashboard" class="cancel-button">Cancel</button>
                <button type="submit" class="save-button">Save</button>
            </div>
        </form>
    </div>
</template>

<style scoped>
.survey-container {
    width: 100%;
    padding: 20px;
    margin-top: 5%;
    margin-bottom: 15%;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-left: 10%;
}
.bottom-space {
    height: 25%;
    color: white;
}

h2 {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    color: #1c4e80;
    margin-bottom: 20px;
}

h1{
    color: #488a99;
    font-weight: bold;
    font-style: italic;
    margin-top:7px;
}
label {
    color: #555;
    display: block;
    margin-bottom: 3px;
    margin-top: 7px; 
}

.form-row, .form-row-name {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.form-row-head {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0;
}

.form-column {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
}

.form-group-remove {
    display: flex;
    margin-top: 12px;
    padding: 0;
}

.form-group {
    flex: 1;
    width: 100%;
    margin-right: 10px;
}
.medium-input-noPreg{
    flex: 0 0 150px;
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

.radio-group {
    display: flex;
    gap: 30px;
    align-items: center;
    justify-content: flex-start;
}

.radio-group div {
    display: flex;
    align-items: center;
    gap: 5px;
}

.radio-group input[type="radio"] {
    margin: 0;
    transform: scale(1.2);
}

.radio-group label {
    margin: 0;
    color: #555;
}

.small-input {
    flex: 0 0 80px;
    margin-right: 3%;
}

.medium-input {
    flex: 0 0 130px;
}

.medium-input-child-no {
    flex: 0 0 130px;
    margin-left: 20px;
}

.medium-input-family-no {
    flex: 0 0 100px;
    margin-left: 78%;
}
.medium-input-education{
    flex: 0 0 420px;
}
.medium-input-occupation{
    flex: 0 0 320px;
}
.medium-input-father-educ{
    flex: 0 0 420px;
}

.medium-input-dob {
    flex: 0 0 150px;
    margin-right: 50px;
    display: inline-block;
}

.medium-input-cs {
    flex: 0 0 150px;
    margin-left: 3%;
    margin-right: 3%;
}
.birth-type{
    flex: 0 0 120px;
}
.line{
    border-top: 1px solid #ccc;
    margin-top: 20px;
    margin-bottom: 20px;
}

.form-row-buttons {
    display: flex;
    justify-content: space-between;
}

.save-button {
    display: block;
    padding: 8px 5px;
    margin-top: 5%;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 20%;
    font-size: 16px;
    transition: background-color 0.3s;
}

.cancel-button {
    background-color: #dc3545;
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

.save-button:hover {
    background-color: #0056b3;
}

.cancel-button:hover {
    background-color: #c82333;
}

.ar-buttons {
    display: flex;
    justify-content: flex-end;
    margin-top: 25px;
    margin-left: 5px;
    height: 40px;
}

.add-button,
.remove-button {
    background-color: green;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    padding: 5px;
    font-size: 14px;
    margin-top: 10px;
    width: 30px;
    margin-left: 30px;
}

.add-button:hover {
    background-color: #006400;
}

.remove-button {
    background-color: #dc3545;
    margin-left: 0;
}

.remove-button:hover {
    background-color: #c82333;
}

.remove-button-group {
    display: flex;
    align-items: center;
    margin-left: 10px;
}

.logo {
    width: 65px;
    height: 60px;
    margin-right: 25px;
    margin-top: -12px;
    background: none;
}

.health-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.health-table th, .health-table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}

.health-table th {
    background-color: #f2f2f2;
    text-align: center;
}

.left-section {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom:-1%;
}

.form-row {
    display: flex;
    gap: 10px;
}

.zone-input {
    margin-left: auto;
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
</style>