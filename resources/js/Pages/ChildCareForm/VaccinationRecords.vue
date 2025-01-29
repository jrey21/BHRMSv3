<script setup>
import { defineProps, ref, computed, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
    child: { type: Object, required: true },
});

const showVacModal = ref(false);
const flashMessage = ref('');
const showFlashMessage = ref(false);
const showVaccinationRecords = ref(true);

const newRecord = ref({
    vaccine_name: '',
    dose_number: '',
    date: '',
    status: '',
});

const vaccineDoses = {
    BCG: 1,
    DPT: 4,
    OPV: 4,
    'Hepatitis B': 3,
    Measles: 2,
};

const toggleVaccinationRecords = () => {
    // Toggle the visibility of the vaccination records section
    showVaccinationRecords.value = !showVaccinationRecords.value;
};

const canAddDose = computed(() => {
    // Check if a new dose can be added for the selected vaccine
    if (!newRecord.value.vaccine_name) return true; 
    const requiredDoses = vaccineDoses[newRecord.value.vaccine_name];
    const recordedDoses = props.child.vaccination_records.filter(record => record.vaccine_name === newRecord.value.vaccine_name).length;
    return recordedDoses < requiredDoses;
});

const addRecord = () => {
    // Add a new vaccination record
    const requiredDoses = vaccineDoses[newRecord.value.vaccine_name];
    const recordedDoses = props.child.vaccination_records.filter(record => {
        if (newRecord.value.vaccine_name === 'Other') {
            return record.other_vaccine_name === newRecord.value.other_vaccine_name;
        }
        return record.vaccine_name === newRecord.value.vaccine_name;
    }).length;

    if (newRecord.value.vaccine_name !== 'Other' && recordedDoses >= requiredDoses) {
        flashMessage.value = `Cannot add more doses for ${newRecord.value.vaccine_name}!`;
        showFlashMessage.value = true;
        setTimeout(() => (showFlashMessage.value = false), 5000);
        return;
    }

    const vaccineCount = props.child.vaccination_records.filter(record => {
        if (newRecord.value.vaccine_name === 'Other') {
            return record.other_vaccine_name === newRecord.value.other_vaccine_name;
        }
        return record.vaccine_name === newRecord.value.vaccine_name;
    }).length;
    if (vaccineCount >= 1000) {
        flashMessage.value = 'This vaccine has already been recorded 1000 times!';
        showFlashMessage.value = true;
        setTimeout(() => (showFlashMessage.value = false), 5000);
        return;
    }

    // Determine the status before saving
    if (newRecord.value.vaccine_name === 'Other') {
        newRecord.value.status = 'Vaccinated';
    } else {
        newRecord.value.status = recordedDoses + 1 >= requiredDoses ? 'Fully Vaccinated' : 'Vaccinated';
    }

    axios.post(`/child/${props.child.id}/addVac`, { ...newRecord.value })
        .then(response => {
            console.log('Record Added:', response.data);
            showVacModal.value = false;
            flashMessage.value = 'Record added successfully!';
            showFlashMessage.value = true;
            setTimeout(() => (showFlashMessage.value = false), 5000);
            props.child.vaccination_records.push(response.data.record); 
            updateVaccinationStatus(); 
        })
        .catch(error => {
            flashMessage.value = 'Failed to add record! ' + (error.response?.data?.message || error.message);
            showFlashMessage.value = true;
            setTimeout(() => (showFlashMessage.value = false), 5000);
        });
};

const today = computed(() => {
    // Get today's date in YYYY-MM-DD format
    const date = new Date();
    return date.toISOString().split('T')[0];
});

const sortedVaccinationRecords = computed(() => {
    // Group and sort vaccination records by vaccine name
    const groupedRecords = {};
    props.child.vaccination_records.forEach(record => {
        const key = record.vaccine_name === 'Other' ? record.other_vaccine_name : record.vaccine_name;
        if (!groupedRecords[key]) {
            groupedRecords[key] = {
                vaccine_name: record.vaccine_name,
                other_vaccine_name: record.other_vaccine_name || '',
                dose_1: '',
                dose_2: '',
                dose_3: '',
                dose_4: '',
                booster: '',
                status: record.status
            };
        }
        groupedRecords[key][record.dose_number] = record.date;
    });

    return Object.values(groupedRecords);
});

const availableDoses = computed(() => {
    // Get the available doses for the selected vaccine
    const doses = ['dose_1', 'dose_2', 'dose_3','dose_4', 'booster'];
    if (newRecord.value.vaccine_name === 'Other') {
        return doses; // Return all doses if the vaccine is "Other"
    }
    const recordedDoses = props.child.vaccination_records
        .filter(record => record.vaccine_name === newRecord.value.vaccine_name)
        .map(record => record.dose_number);
    return doses.filter(dose => !recordedDoses.includes(dose));
});

const updateVaccinationStatus = () => {
    // Update the vaccination status for each record
    const vaccineDoses = {
        BCG: 1,
        DPT: 4,
        OPV: 4,
        'Hepatitis B': 3,
        Measles: 2,
    };

    props.child.vaccination_records.forEach(record => {
        const requiredDoses = vaccineDoses[record.vaccine_name];
        const recordedDoses = props.child.vaccination_records.filter(r => r.vaccine_name === record.vaccine_name).length;
        record.status = recordedDoses >= requiredDoses ? 'Fully Vaccinated' : 'Vaccinated';
    });
};

// Call updateVaccinationStatus whenever vaccination records are updated
watch(() => props.child.vaccination_records, updateVaccinationStatus, { deep: true });

const formatDate = (dateString) => {
    // Format the date string to a more readable format
    if (!dateString) return ' ';
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};
</script>

<template>
    <!-- Vaccination Records Information -->
    <div v-if="child" class="container">
        <div class="header1" @click="toggleVaccinationRecords" style="cursor: pointer; display: flex;">
            <div style="display: flex;">
                <h1>Vaccination Information</h1>
                <span style="margin-left: 10px; margin-bottom:10px; margin-top:-5px; color:#488a99;">
                    {{ showVaccinationRecords ? '▼' : '▲' }}
                </span>
            </div>
            <button @click.stop="showVacModal = true" class="add-button">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <transition name="fade">
            <div v-if="showVaccinationRecords" class="scrollable-table">
                <table class="info-table">
                    <thead>
                        <tr>
                            <th>Vaccine</th>
                            <th>Dose 1</th>
                            <th>Dose 2</th>
                            <th>Dose 3</th>
                            <th>Dose 4</th>
                            <th>booster</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="!child.vaccination_records || child.vaccination_records.length === 0">
                            <td colspan="7" class="no-data" style="text-align: center; font-weight: normal; text-transform: none;">No vaccination records available.</td>
                        </tr>
                        <tr v-for="record in sortedVaccinationRecords" :key="record.vaccine_name + record.other_vaccine_name">
                            <td>{{ record.vaccine_name === 'Other' ? record.other_vaccine_name : record.vaccine_name }}</td>
                            <td>{{ formatDate(record.dose_1) }}</td>
                            <td>{{ formatDate(record.dose_2) }}</td>
                            <td>{{ formatDate(record.dose_3) }}</td>
                            <td>{{ formatDate(record.dose_4) }}</td>
                            <td>{{ formatDate(record.booster) }}</td>
                            <td>{{ record.status }}</td>
                        </tr>
                    </tbody>
                </table>
             </div>
        </transition>
    </div>

    <!-- Add vaccination record modal -->
    <transition name="fade">
        <div v-if="showVacModal" class="modal-overlay">
            <div class="modal-content">
                <h2 class="add-vac" style="color: #488a99;">Add Vaccination Record</h2>
                <form @submit.prevent="addRecord">
                    <label for="date"> Record Date:</label>
                    <input type="date" v-model="newRecord.date" :max="today"  required />
                    <label for="vaccine_name">Vaccine Name:</label>
                    <select name="vaccine_name" v-model="newRecord.vaccine_name" required>
                        <option value=""></option>
                        <option value="BCG" :disabled="props.child.vaccination_records.filter(record => record.vaccine_name === 'BCG').length >= vaccineDoses.BCG">BCG</option>
                        <option value="DPT" :disabled="props.child.vaccination_records.filter(record => record.vaccine_name === 'DPT').length >= vaccineDoses.DPT">DPT</option>
                        <option value="OPV" :disabled="props.child.vaccination_records.filter(record => record.vaccine_name === 'OPV').length >= vaccineDoses.OPV">OPV</option>
                        <option value="HEPA B" :disabled="props.child.vaccination_records.filter(record => record.vaccine_name === 'Hepatitis B').length >= vaccineDoses['Hepatitis B']">Hepatitis B</option>
                        <option value="Measles" :disabled="props.child.vaccination_records.filter(record => record.vaccine_name === 'Measles').length >= vaccineDoses.Measles">Measles</option>
                        <option value="HIB">HIB</option>
                        <option value="PCV">PCV</option>
                        <option value="Polio">Polio</option>
                        <option value="Other">Other</option>
                    </select>
                    <input
                        v-if="newRecord.vaccine_name === 'Other'"
                        type="text"
                        name="other_vaccine_name"
                        v-model="newRecord.other_vaccine_name"
                        placeholder="Please specify"
                        required
                    />

                    <label for="dose_number">Number of Doses:</label>
                    <select v-model="newRecord.dose_number" required>
                        <option value=""></option>
                        <option v-for="dose in availableDoses" :key="dose" :value="dose">
                            {{ dose.replace('_date', '').replace('_', ' ').toUpperCase() }}
                        </option>
                    </select>

                    <div class="button-container">
                        <button type="submit">Add</button>
                        <button type="button" @click="showVacModal = false">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </transition>

    <!-- Flash message -->
    <transition name="fade">
        <div v-if="showFlashMessage" class="flash-modal">
            <div class="flash-content">{{ flashMessage }}</div>
        </div>
    </transition>
</template>

<style scoped>
.no-data {
    text-transform: none;
}
.scrollable-table{
    max-height:350px;
    overflow-y: auto;
    margin-top:10px;
    scroll-snap-type: y mandatory;
    position: sticky;
    top: -1px;
}
.scrollable-table > .data-table{
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
    margin-top: 5px; 
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
.header1 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 2px solid #ddd;
    margin-left: -.5px;
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
    position: sticky;
    top: -1px;
}
.info-table th{
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
    color: #333;
}
.info-table td:first-child {
    text-align: left; 
    font-weight: bold;
    width: 30%;
    text-transform: capitalize;
}


.info-table th {
    background-color: #007bff; 
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
    z-index: 1001;
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