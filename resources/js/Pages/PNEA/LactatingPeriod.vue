<script setup>
import { defineProps, ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
    pnea: { type: Object, required: true },
});

const availableMonths = computed(() => {
    const months = ['1st Month', '2nd Month', '3rd Month', '4th Month', '5th Month', '6th Month'];
    const recordedMonths = props.pnea.lactating_periods.map(record => record.month.toString());
    return months.filter(month => !recordedMonths.includes(month));
});

const showAddModal = ref(false);
const showFlashMessage = ref(false);
const flashMessage = ref('');
const showLactatingRecords = ref(true);

const newRecord = ref({
    month: '',
    weight: '',
    height: '',
    bmi: '',
    status: '',
    muac: '',
    muac_color: '',
    muac_status: '',
});

const calculateBMI = (weight, height) => {
    if (!weight || !height) return '';
    const heightInMeters = height / 100;
    return (weight / (heightInMeters * heightInMeters)).toFixed(2);
};

const interpretStatus = (bmi) => {
    if (!bmi) return '';
    if (bmi < 18.5) return 'UW';
    if (bmi >= 18.5 && bmi < 24.9) return 'N ';
    if (bmi >= 25 && bmi < 29.9) return 'OW';
    return 'OB';
};

const interpretMuacColor = (muac) => {
    if (!muac) return '';
    if (muac >= 23) return 'Green';
    if (muac >= 21 && muac < 23) return 'Yellow';
    return 'Red';
};

const interpretMuacStatus = (muacColor) => {
    if (!muacColor) return '';
    if (muacColor === 'Green') return 'N';
    if (muacColor === 'Yellow') return 'MM';
    if (muacColor === 'Red') return 'SM';
    return '';
};

const resetForm = () => {
    newRecord.value = {
        month: '',
        weight: '',
        height: '',
        bmi: '',
        status: '',
        muac: '',
        muac_color: '',
        muac_status: '',
    };
};

const addRecord = () => {
    const bmi = calculateBMI(newRecord.value.weight, newRecord.value.height);
    const status = interpretStatus(bmi);
    const muacColor = interpretMuacColor(newRecord.value.muac);

    newRecord.value.bmi = bmi;
    newRecord.value.status = status;
    newRecord.value.muac_color = muacColor;
    newRecord.value.muac_status = interpretMuacStatus(muacColor);

    axios.post(`/pnea/${props.pnea.id}/addLactatingPeriod`, { ...newRecord.value })
        .then(response => {
            console.log('Record Added:', response.data);
            showAddModal.value = false;
            flashMessage.value = 'Record added successfully!';
            showFlashMessage.value = true;
            setTimeout(() => (showFlashMessage.value = false), 3000);
            props.pnea.lactating_periods.push(response.data.record);
            resetForm();
        })
        .catch(error => {
            flashMessage.value = 'Failed to add record! ' + (error.response?.data?.message || error.message);
            showFlashMessage.value = true;
            setTimeout(() => (showFlashMessage.value = false), 5000);
        });
};

const toggleLactating = () => {
    showLactatingRecords.value = !showLactatingRecords.value;
};

const months = ['1st Month', '2nd Month', '3rd Month', '4th Month', '5th Month', '6th Month'];

const getRecordForMonth = (month, field) => {
    const record = props.pnea.lactating_periods.find(record => record.month === month);
    return record ? record[field] : '';
};

const getStatusStyle = (status) => {
    if (status === 'UW') {
        return { fontWeight: 'bold', color: 'red' };
    }
    return {};
};
</script>

<template>
    <!-- Lactating Records Information -->
    <div v-if="pnea" class="container">
        <div class="header7" @click="toggleLactating" style="cursor: pointer;">
            <div style="display: flex; align-items: center;">
                <h1>Nutritional Status of Lactating Mother</h1>
                <span style="margin-left: 10px; margin-bottom:10px;color:#488a99;">
                    {{ showLactatingRecords ? '▼' : '▲' }}
                </span>
            </div>
            <button @click.stop="showAddModal = true" class="add-button">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <transition name="fade">
            <div v-if="showLactatingRecords" class="scrollable-table">
                <table class="info-table">
                    <thead>
                        <tr style="background-color: #007bff; color:white;">
                            <th colspan="7" class="border border-gray-400">Lactating Period (Exclusivity)</th>
                        </tr>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-400 p-2">Measurements</th>
                            <th class="border border-gray-800 p-2">1st Month</th>
                            <th class="border border-gray-400 p-2">2nd Month</th>
                            <th class="border border-gray-400 p-2">3rd Month</th>
                            <th class="border border-gray-400 p-2">4th Month</th>
                            <th class="border border-gray-400 p-2">5th Month</th>
                            <th class="border border-gray-400 p-2">6th Month</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Weight</td>
                            <td v-for="month in months" :key="'weight-' + month">
                                {{ getRecordForMonth(month, 'weight') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Height</td>
                            <td v-for="month in months" :key="'height-' + month">
                                {{ getRecordForMonth(month, 'height') }}
                            </td>
                        </tr>
                        <tr>
                            <td>BMI</td>
                            <td v-for="month in months" :key="'bmi-' + month">
                                {{ getRecordForMonth(month, 'bmi') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nutritional Status</td>
                            <td v-for="month in months" :key="'status-' + month" :style="getStatusStyle(getRecordForMonth(month, 'status'))">
                               {{ getRecordForMonth(month, 'status') }}
                            </td>
                        </tr>
                        <tr>
                            <td>MUAC (color)</td>
                            <td v-for="month in months" :key="'muac_color-' + month">
                                {{ getRecordForMonth(month, 'muac_color') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nutritional Status</td>
                            <td v-for="month in months" :key="'muac_status-' + month">
                                {{ getRecordForMonth(month, 'muac_status') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </transition>
    </div>

    <!-- Add lactating record modal -->
    <div v-if="showAddModal" class="modal-overlay">
        <div class="modal-content">
            <h2 class="add-vac" style="color: #488a99;">Add Record</h2>
            <form @submit.prevent="addRecord">
                <!-- Form fields for adding a new record -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="month">Month</label>
                        <select v-model="newRecord.month" required>
                            <option value="" disabled>Select Month</option>
                            <option v-for="month in availableMonths" :key="month" :value="month">{{ month }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="weight">Weight (kg)</label>
                        <input type="number" step="0.001" v-model="newRecord.weight" required />
                    </div>
                    <div class="form-group">
                        <label for="height">Height (cm)</label>
                        <input type="number" step="0.001" v-model="newRecord.height" required />
                    </div>
                    <div class="form-group">
                        <label for="muac">MUAC</label>
                        <input type="number" step="0.001" v-model="newRecord.muac" required />
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit">Add</button>
                    <button type="button" @click="showAddModal = false">Cancel</button>
                </div>
            </form>
        </div>
    </div>

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
.scrollable-table {
    max-height: none; 
    overflow-y: visible;
    margin-top: 10px;
    scroll-snap-type: y mandatory;
    position: relative;
}
.scrollable-table > .data-table {
    width: 960px;
}
.add-vac {
    font-size: 18px;
    font-weight: bold;
}
.add-button {
    position: absolute;
    right: 0;
    top: 90%;
    transform: translateY(-50%);
    background-color: #4CAF50; 
    border: none; 
    color: white;
    padding: 5px 15px; 
    text-align: center; 
    text-decoration: none; 
    display: inline-block; 
    font-size: 14px; 
    cursor: pointer;
    border-radius: 8px; 
    transition: background-color 0.3s ease; 
}
.add-button:hover {
    background-color: #45a049; 
}
.header7 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 2px solid #ddd;
    position: relative;
    margin-left: -.5px;
}
.container {
    height: 490px;
    max-width: 115%;
    padding: 20px;
    margin-top: 0;
    margin-left: 20px;
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
  margin-left: 0; 
  margin-top: 20px;
}

.info-table th, .info-table td {
  border: 1px solid #ddd;
  padding: 6px;
  text-align: center;
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
    text-align: center;
    width:8%;
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
    width: 500px; 
    width: 35%; 
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
.modal-content input[type="text"][placeholder="5 mins"] {
    width: 50%;
}
.modal-content select[name="breastfeeding_status"] {
    width: 100%;
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
.flash-message {
    background-color: #f44336;
    color: white;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 10px;
    text-align: center;
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
.form-row {

    display: flex;
    justify-content: space-between;
}
.form-group {
    flex: 1;
    margin-right: 10px;
}
.form-group-duration {
    flex: 1;
    right: 0;
}
.form-group:last-child {
    margin-right: 0;
}
</style>
