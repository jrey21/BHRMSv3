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

const isEditing = ref(false);
const editableSurvey = ref({ ...props.survey });
const flashMessage = ref('');
const showFlashMessage = ref(false);
const isError = ref(false);

const editData = () => {
    isEditing.value = true;
};

const saveData = async () => {
    try {
        const response = await axios.put(
            route('survey-update', { id: props.survey.id }),
            { ...editableSurvey.value }
        );
        Object.assign(props.survey, response.data);
        flashMessage.value = 'Changes saved successfully!';
        isError.value = false;
        showFlashMessage.value = true;
        isEditing.value = false;
        setTimeout(() => (showFlashMessage.value = false), 900);
    } catch (error) {
        console.error('Error updating data:', error);
        flashMessage.value = `Failed to update! Please check your input and try again.`; 
        isError.value = true;
        showFlashMessage.value = true;
        setTimeout(() => (showFlashMessage.value = false), 5000);
    }
};

const cancelEdit = () => {
    Object.assign(editableSurvey.value, props.survey);
    isEditing.value = false;
};

</script>

<template>
    <Head title=" | Comprehensive Survey Data" />
    <div v-if="showFlashMessage" :class="['flash-message', { error: isError }]">
        {{ flashMessage }}
    </div>
    <div class="tables-container">
        <div class="table-wrapper">
            <div class="header-with-button">
                <h1 class="personal-head text-slate-500">I. Personal Information</h1>
                <div>
                    <button @click="isEditing ? saveData() : editData()" :class="['icon-buttons', { 'save-button': isEditing }]">
                        <i :class="isEditing ? 'fas fa-save' : 'fas fa-edit'"></i>
                    </button>
                    <!-- <button v-if="isEditing" @click="cancelEdit" class="icon-buttons">
                        <i class="fas fa-times"></i>
                    </button> -->
                </div>
            </div>
            <table class="info-table">
                <tr><td class="label">Last Name: </td>
                    <td v-if="!isEditing">{{ survey.last_name }}</td>
                    <td v-else><input v-model="editableSurvey.last_name" class="data input-field" /></td>
                </tr>
                <tr><td class="label">First Name: </td>
                    <td v-if="!isEditing">{{ survey.first_name }}</td>
                    <td v-else><input v-model="editableSurvey.first_name" class="data input-field" /></td>
                </tr>
                <tr><td class="label">Middle Name: </td>
                    <td v-if="!isEditing">{{ survey.middle_name }}</td>
                    <td v-else><input v-model="editableSurvey.middle_name" class="data input-field" /></td>
                </tr>
                <tr><td class="label">Suffix: </td>
                    <td v-if="!isEditing">{{ suffix }}</td>
                    <td v-else>
                        <select v-model="editableSurvey.suffix" class="data input-field">
                            <option value="-">-</option>
                            <option value="Jr.">Jr.</option>
                            <option value="Sr.">Sr.</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                        </select>
                    </td>
                </tr>
                <tr><td class="label">Birthdate: </td>
                    <td v-if="!isEditing">{{ formattedBirthDate }}</td>
                    <td v-else><input type="date" v-model="editableSurvey.birth_date" class="data input-field" /></td>
                </tr>
                <tr><td class="label">Age: </td>
                    <td>{{ age.value }} {{ age.unit }}</td>
                </tr>
                <tr><td class="label">Sex: </td>
                    <td v-if="!isEditing">{{ survey.sex }}</td>
                    <td v-else>
                        <select v-model="editableSurvey.sex" class="data input-field">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </td>
                </tr>
                <tr><td class="label">Civil Status: </td>
                    <td v-if="!isEditing">{{ survey.civil_status }}</td>
                    <td v-else>
                        <select v-model="editableSurvey.civil_status" class="data input-field">
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Separated">Separated</option>
                        </select>
                    </td>
                </tr>
                <tr><td class="label">Religion: </td>
                    <td v-if="!isEditing">{{ survey.religion }}</td>
                    <td v-else><input v-model="editableSurvey.religion" class="data input-field" /></td>
                </tr>
                <tr><td class="label">Occupation: </td>
                    <td v-if="!isEditing">{{ survey.occupation }}</td>
                    <td v-else><input v-model="editableSurvey.occupation" class="data input-field" /></td>
                </tr>
                <tr><td class="label">Educational Attainment: </td>
                    <td v-if="!isEditing">{{ survey.education }}</td>
                    <td v-else>
                        <select v-model="editableSurvey.education" class="data input-field">
                            <option value="None">N/A</option>
                            <option value="Elementary">Elementary</option>
                            <option value="Highschool">High School</option>
                            <option value="College">College</option>
                            <option value="Postgraduate">Postgraduate</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>

        <div class="table-wrapper">
            <h1 class="personal-head text-slate-500">II. Other Information</h1>
            <table class="info-table">
                <tr><td class="label">Zone: </td>
                    <td v-if="!isEditing">{{ survey.zone }}</td>
                    <td v-else>
                        <select v-model="editableSurvey.zone" class="data input-field">
                            <option value="Zone 1">Zone 1</option>
                            <option value="Zone 2">Zone 2</option>
                            <option value="Zone 3">Zone 3</option>
                            <option value="Zone 4">Zone 4</option>
                            <option value="Zone 5">Zone 5</option>
                            <option value="Zone 6">Zone 6</option>
                            <option value="Zone 7">Zone 7</option>
                        </select>
                    </td>
                </tr>

                <tr><td class="label">H/H Access to Sanitary: </td>
                    <td v-if="!isEditing">{{ survey.sanitary_access }}</td>
                    <td v-else><select v-model="editableSurvey.sanitary_access" class="data input-field">
                        <option value="Owned">Owned</option>
                        <option value="Shared">Shared</option>
                        <option value="None">None</option>
                    </select></td>
                </tr>
                <tr><td class="label">Water Sources: </td>
                    <td v-if="!isEditing">{{ survey.water_source }}</td>
                    <td v-else><select v-model="editableSurvey.water_source" class="data input-field">
                        <option value="Level 1">Level 1</option>
                        <option value="Level 2">Level 2</option>
                        <option value="Level 3">Level 3</option>
                    </select></td>
                </tr>
                <tr><td class="label">Family Planning Used: </td>
                    <td v-if="!isEditing">{{ survey.family_planning }}</td>
                    <td v-else><input v-model="editableSurvey.family_planning" class="data input-field" /></td>
                </tr>
                <tr><td class="label">Are you a member of the LGBT community?: </td>
                    <td v-if="!isEditing">{{ survey.lgbt ? 'Yes' : 'No' }}</td>
                    <td v-else>
                        <select v-model="editableSurvey.lgbt" class="data input-field">
                            <option :value="1">Yes</option>
                            <option :value="0">No</option>
                        </select>
                    </td>
                </tr>
                <tr><td class="label">Do you identify as a (PWD)?: </td>
                    <td v-if="!isEditing">{{ survey.pwd ? 'Yes' : 'No' }}</td>
                    <td v-else>
                        <select v-model="editableSurvey.pwd" class="data input-field">
                            <option :value="1">Yes</option>
                            <option :value="0">No</option>
                        </select>
                    </td>
                </tr>
                <tr><td class="label">Are you a member of 4'Ps? : </td>
                    <td v-if="!isEditing">{{ survey.four_ps ? 'Yes' : 'No' }}</td>
                    <td v-else>
                        <select v-model="editableSurvey.four_ps" class="data input-field">
                            <option :value="1">Yes</option>
                            <option :value="0">No</option>
                        </select>
                    </td>
                </tr>
                <tr><td class="label">Are you Non-HTS?: </td>
                    <td v-if="!isEditing">{{ survey.non_hts ? 'Yes' : 'No' }}</td>
                    <td v-else>
                        <select v-model="editableSurvey.non_hts" class="data input-field">
                            <option :value="1">Yes</option>
                            <option :value="0">No</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<style scoped>
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

.icon-buttons {
    background: none;
    border: none;
    cursor: pointer;
    color: #ffc107; 
}
.icon-buttons:hover {
    color: #ec971f; 
}
.icon-buttons.save-button {
    color: #007bff;
}
.flash-message {
    position: fixed;
    top: 60px;
    left: 50%;
    transform: translateX(-50%);
    padding: 10px;
    color: #fff;
    background-color: #4caf50; 
    border-radius: 5px;
    text-align: center;
    z-index: 1000;
}
.flash-message.error {
    background-color: #ff5722;
    color:white;
}

.input-field {
    width: 100%;
    /* padding: 8px; */
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 14px;
    transition: border-color 0.3s ease;
    padding-top: 2px;
    padding-bottom: 2px;
}
.input-field:focus {
    border-color: #4CAF50;
    outline: none;
}
</style>