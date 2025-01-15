<script setup> 
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import FormLayout from '../../Layouts/FormLayout.vue';

defineOptions({ layout: FormLayout });

const form = useForm({
    householdNumber: null,
    zone: null,
    family_number: null,
    personalInfo: [
        {
            lastName: null,
            firstName: null,
            middleName: null,
            suffix: null,
            age: null,
            age_unit: 'years', 
            sex: null,
            civilStatus: null,
            birth_date: null,
            education: null,
            religion: null,
            occupation: null,
            sanitaryAccess: null,
            waterSource: null,
            familyPlanning: null,
            lgbt: null,
            pwd: null,
            fourPs: null,
            nonHTS: null,
            remarks: null,
        }
    ]
});

const addPersonalInfoRow = () => {
    form.personalInfo.push({
        lastName: null,
        firstName: null,
        middleName: null,
        suffix: null,
        age: null,
        age_unit: 'years', 
        sex: null,
        civilStatus: null,
        birth_date: null,
        education: null,
        religion: null,
        occupation: null,
        sanitaryAccess: null,
        waterSource: null,
        familyPlanning: null,
        lgbt: null,
        pwd: null,
        fourPs: null,
        nonHTS: null,
        remarks: null,
    });
};

const removePersonalInfoRow = (index) => {
    if (form.personalInfo.length > 1) {
        form.personalInfo.splice(index, 1);
    }
};

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

const submit = () => {
    // Normalize boolean fields
    form.personalInfo.forEach(row => {
        row.lgbt = row.lgbt === 'yes';
        row.pwd = row.pwd === 'yes';
        row.fourPs = row.fourPs === 'yes';
        row.nonHTS = row.nonHTS === 'yes';

        // Capitalize the first letter of all inputs except boolean fields
        row.lastName = row.lastName ? row.lastName.charAt(0).toUpperCase() + row.lastName.slice(1) : null;
        row.firstName = row.firstName ? row.firstName.charAt(0).toUpperCase() + row.firstName.slice(1) : null;
        row.middleName = row.middleName ? row.middleName.charAt(0).toUpperCase() + row.middleName.slice(1) : null;
        row.suffix = row.suffix ? row.suffix.charAt(0).toUpperCase() + row.suffix.slice(1) : null;
        row.religion = row.religion ? row.religion.charAt(0).toUpperCase() + row.religion.slice(1) : null;
        row.occupation = row.occupation ? row.occupation.charAt(0).toUpperCase() + row.occupation.slice(1) : null;
        row.familyPlanning = row.familyPlanning ? row.familyPlanning.charAt(0).toUpperCase() + row.familyPlanning.slice(1) : null;
        row.remarks = row.remarks ? row.remarks.charAt(0).toUpperCase() + row.remarks.slice(1) : null;
    });

    // Submit the form
    form.post(route('comprehensive-survey'), {
        onSuccess: () => {
            formSubmittedSuccessfully.value = true;
            modalTitle.value = 'SUCCESS!';
            modalMessage.value = 'Survey submitted successfully!';
            showModal.value = true;
            window.flash('Survey submitted successfully!', 'success');
            window.location.href = route('comprehensive-survey-view');
        },
        onError: (errors) => {
            formSubmittedSuccessfully.value = false;
            modalTitle.value = 'Failed to submit data!';
            modalMessage.value = 'There was an error submitting the form: ' + JSON.stringify(errors);
            showModal.value = true;
            window.flash('There was an error submitting the form. Please review the errors.', 'error');
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
    window.location.href = route('comprehensive-survey-view');
};

const today = new Date().toISOString().split('T')[0];
</script>

<template>
    <Head title=" | Comprehensive Survey"/>
    <div class="survey-container">
        <h2>Barangay Comprehensive Survey</h2>
        <!-- Flash Message Container -->
        <div id="flash-message-container"></div>
        <form @submit.prevent="submit">
            <div class="form-row-head">
                <div class="form-group small-input">
                    <label for="householdNumber">HH Number</label>
                    <input type="text" name="householdNumber" v-model="form.householdNumber" required/>
                </div>
                <div class="form-group small-input-fn">
                    <label for="family_number">Family Number</label>
                    <input type="number" name="family_number" v-model="form.family_number" required/>
                </div>
                <div class="form-group"></div>
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
            <h3 class="subtitle">I. Personal Information</h3>
            <div v-for="(row, index) in form.personalInfo" :key="index" class="form-row">
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input
                        type="text"
                        :name="`lastName_${index}`"
                        v-model="row.lastName"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input
                        type="text"
                        :name="`firstName_${index}`"
                        v-model="row.firstName"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="middleName">Middle Name</label>
                    <input
                        type="text"
                        :name="`middleName_${index}`"
                        v-model="row.middleName"
                    />
                </div>
                <div class="form-group-suffix small-input-suffix">
                    <label for="suffix">Suffix</label>
                    <select :name="`suffix_${index}`" v-model="row.suffix" class="small-select">
                        <option value="">None</option>
                        <option value="Jr.">Jr.</option>
                        <option value="Sr.">Sr.</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                    </select>
                </div>
                <div v-if="index == 0" class="ar-buttons">
                <button type="button" @click="addPersonalInfoRow" class="add-button">
                    <i class="fas fa-plus"></i>
                </button>
                </div>
                <div v-if="index > 0" class="form-group-remove remove-button-group">
                    <button type="button" @click="removePersonalInfoRow(index)" class="remove-button">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
          
            <div v-for="(row, index) in form.personalInfo" :key="index" class="form-row">
                <div class="form-group small-input">
                    <label for="age">Age</label>
                    <div class="age-unit-container">
                        <input 
                            type="number" 
                            :name="`age_${index}`" 
                            v-model="row.age"  
                            min="0" 
                            required
                        />
                        <select v-model="row.age_unit" :name="`age_unit_${index}`">
                            <option value="years">Years</option>
                            <option value="months">Months</option>
                        </select>
                    </div>
                </div>
                <div class="form-group medium-input">
                    <label for="sex">Sex</label>
                    <select :name="`sex_${index}`" v-model="row.sex" required>
                        <option value=""></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group medium-input-cs">
                    <label for="civilStatus">Civil Status</label>
                    <select :name="`civilStatus_${index}`" v-model="row.civilStatus" required>
                        <option value=""></option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widowed</option>
                        <option value="Separated">Separated</option>
                    </select>
                </div>
                <div class="form-group medium-input-birth_date">
                    <label for="birth_date">Date of Birth</label>
                    <input type="date" :name="`birth_date_${index}`" v-model="row.birth_date"  :max="today" required/>
                </div>
                <div class="form-group education">
                    <label for="education">Educational Attainment</label>
                    <select :name="`education_${index}`" v-model="row.education" required>
                        <option value=""></option>
                        <option value="None">N/A</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Highschool">High School</option>
                        <option value="College">College</option>
                        <option value="Postgraduate">Postgraduate</option>
                    </select>
                </div>
            </div>
        
            <div v-for="(row, index) in form.personalInfo" :key="index" class="form-row">
                <div class="form-group">
                    <label for="religion">Religion</label>
                    <input type="text" :name="`religion_${index}`" v-model="row.religion" required/>
                </div>
                <div class="form-group">
                    <label for="occupation">Occupation</label>
                    <input type="text" :name="`occupation_${index}`" v-model="row.occupation" required/>
                </div>
            </div>
            <h3 class="subtitle">II. Other Information</h3>
            <div v-for="(row, index) in form.personalInfo" :key="index" class="form-row">
                <div class="form-group medium-input-sanitary">
                    <label for="sanitaryAccess">H/H Access to Sanitary</label>
                    <select :name="`sanitaryAccess_${index}`" v-model="row.sanitaryAccess" required>
                        <option value=""></option>
                        <option value="Owned">Own</option>
                        <option value="Shared">Shared</option>
                        <option value="None">None</option>
                    </select>
                </div>
                <div class="form-group medium-input-water">
                    <label for="waterSource">Water Sources</label>
                    <select :name="`waterSource_${index}`" v-model="row.waterSource" required>
                        <option value=""></option>
                        <option value="Level 1">Level 1</option>
                        <option value="Level 2">Level 2</option>
                        <option value="Level 3">Level 3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="familyPlanning">Family Planning Used</label>
                    <input type="text" :name="`familyPlanning_${index}`" v-model="row.familyPlanning" required/>
                </div>
            </div>
            <div v-for="(row, index) in form.personalInfo" :key="index" class="form-row">
    <div class="form-group medium-input-lgbt">
        <label for="lgbt">Are you a member of the LGBT community?</label>
        <div class="radio-group">
            <div>
                <input 
                    type="radio" 
                    :id="`lgbtYes_${index}`" 
                    :name="`lgbt_${index}`" 
                    value="yes" 
                    v-model="row.lgbt" 
                    required
                />
                <label :for="`lgbtYes_${index}`">Yes</label>
            </div>
            <div>
                <input 
                    type="radio" 
                    :id="`lgbtNo_${index}`" 
                    :name="`lgbt_${index}`" 
                    value="no" 
                    v-model="row.lgbt" 
                    required
                />
                <label :for="`lgbtNo_${index}`">No</label>
            </div>
        </div>
    </div>
    <div class="form-group medium-input-pwd">
        <label for="pwd">Do you identify as a (PWD)?</label>
        <div class="radio-group">
            <div>
                <input 
                    type="radio" 
                    :id="`pwdYes_${index}`" 
                    :name="`pwd_${index}`" 
                    value="yes" 
                    v-model="row.pwd" 
                    required
                />
                <label :for="`pwdYes_${index}`">Yes</label>
            </div>
            <div>
                <input 
                    type="radio" 
                    :id="`pwdNo_${index}`" 
                    :name="`pwd_${index}`" 
                    value="no" 
                    v-model="row.pwd" 
                    required
                />
                <label :for="`pwdNo_${index}`">No</label>
            </div>
        </div>
    </div>
    <div class="form-group medium-input-fourPs">
        <label for="fourPs">Are you a member of 4Ps?</label>
        <div class="radio-group">
            <div>
                <input 
                    type="radio" 
                    :id="`fourPsYes_${index}`" 
                    :name="`fourPs_${index}`" 
                    value="yes" 
                    v-model="row.fourPs" 
                    required
                />
                <label :for="`fourPsYes_${index}`">Yes</label>
            </div>
            <div>
                <input 
                    type="radio" 
                    :id="`fourPsNo_${index}`" 
                    :name="`fourPs_${index}`" 
                    value="no" 
                    v-model="row.fourPs" 
                    required
                />
                <label :for="`fourPsNo_${index}`">No</label>
            </div>
        </div>
    </div>
    <div class="form-group medium-input-nonHTS">
        <label for="nonHTS">Are you Non-HTS?</label>
        <div class="radio-group">
            <div>
                <input 
                    type="radio" 
                    :id="`nonHTSYes_${index}`" 
                    :name="`nonHTS_${index}`" 
                    value="yes" 
                    v-model="row.nonHTS" 
                    required
                />
                <label :for="`nonHTSYes_${index}`">Yes</label>
            </div>
            <div>
                <input 
                    type="radio" 
                    :id="`nonHTSNo_${index}`" 
                    :name="`nonHTS_${index}`" 
                    value="no" 
                    v-model="row.nonHTS" 
                    required
                />
                <label :for="`nonHTSNo_${index}`">No</label>
            </div>
        </div>
    </div>
</div>

        <div class="form-row">
            <div class="form-group">
                <label for="remarks" type="text">Remarks</label>
                <textarea name="remarks" v-model="form.remarks"></textarea>
            </div>
        </div>
        <div class="form-row-buttons">
            <button type="button" @click="redirectToDashboard" class="cancel-button">Cancel</button>
            <button type="submit" class="save-button">Save</button>
        </div>
    </form>
    </div>
    <!-- <div class="bottom-space">I need space</div> -->

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
</template>


<style scoped>
.survey-container {
    width: 100%;
    margin-left: 10%;
    padding: 20px;
    margin-top: 5%;
    margin-bottom: 15%;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

h3.subtitle {
    margin-top: 10px;
    margin-bottom: 10px;
    color: #488a99;
    font-style: italic;
    font-weight: bold;
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
    gap: 10px; /* Adjusted gap */
}

.form-column {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
}
.form-group-remove{
    display: flex;
    margin-top:12px;
    padding:0;
}

.form-group {
    flex: 1;
    margin-right: 10px;
}
.education{
    flex: 1 0 200px; /* Adjusted flex property */
}

.form-group:last-child {
    margin-right: 0;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #555;
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
    flex: 0 0 130px;
    /* margin-right: 3%; */
}
.small-input-fn {
    flex: 0 0 130px; /* Adjusted flex property to match HH Number */
    margin-right: 20%;
}
.small-input-zone {
    flex: 0 0 130px;   
    margin-left: 10%;
}

.medium-input {
    flex: 0 0 110px;
}

.medium-input-hhn {
    flex: 0 0 100px;
    margin-right: 3%;
}

.medium-input-birth_date {
    flex: 1 0 150px;
}

.medium-input-cs {
    flex: 0 0 180px;
    /* margin-left: 3%; */
    /* margin-right: 3%; */
}

.medium-input-sanitary {
    flex: 0 0 180px;
    margin-right: 3%;
}

.medium-input-water {
    flex: 0 0 180px;
    margin-right: 3%;
}

.medium-input-lgbt {
    flex: 0 0 350px;
}

.medium-input-pwd, .medium-input-fourPs {
    flex: 0 0 207px;
}

.medium-input-nonhts {
    flex: 1 0 200px; /* Adjusted flex property */
}

.small-select {
    font-size: 14px;
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
    height:40px;
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

.age-unit-container {
    display: flex;
    align-items: center;
    width: 220px;
    gap: 0;
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