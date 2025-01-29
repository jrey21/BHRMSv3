<script setup>
import { defineProps, ref, computed, watch, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    child: { type: Object, required: true },
});
const formatDate = (dateString) => {
    if (!dateString) return ' ';
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const sortedVitaminARecords = computed(() => {
    const records = props.child.vitamin_a_supplementation.map(record => {
        console.log('Record:', record); 
        return {
            age: record.age,
            age_unit: record.age_unit, 
            dose: record.dose,
            date: record.date
        };
    });
    console.log(records);
    return records;
});

console.log(props.child.vitamin_a_supplementation);

const showAddModal = ref(false);
const showFlashMessage = ref(false);
const flashMessage = ref('');
const showVitaminARecords = ref(true);

const newRecord = ref({
    age: '',
    age_unit: 'years', 
    dose: '',
    date: '',
});

const today = new Date().toISOString().split('T')[0];

const handleAddClick = () => {
    showAddModal.value = true;
};

const isDuplicateRecord = (newRecord) => {
    return props.child.vitamin_a_supplementation.some(record => 
        record.age === newRecord.age &&
        record.age_unit === newRecord.age_unit &&
        record.dose === newRecord.dose &&
        record.date === newRecord.date
    );
};

const addRecord = () => {
    if (isDuplicateRecord(newRecord.value)) {
        flashMessage.value = 'Duplicate record! This record already exists.';
        showFlashMessage.value = true;
        setTimeout(() => (showFlashMessage.value = false), 5000);
        return;
    }

    axios.post(`/child/${props.child.id}/addVitA`, { ...newRecord.value })
        .then(response => {
            console.log('Record Added:', response.data);
            showAddModal.value = false;
            flashMessage.value = 'Record added successfully!';
            showFlashMessage.value = true;
            setTimeout(() => (showFlashMessage.value = false), 5000);
            props.child.vitamin_a_supplementation.push(response.data.record);
        })
        .catch(error => {
            flashMessage.value = 'Failed to add record! ' + (error.response?.data?.message || error.message);
            showFlashMessage.value = true;
            setTimeout(() => (showFlashMessage.value = false), 5000);
        });
};

const toggleVitaminARecords = () => {
    showVitaminARecords.value = !showVitaminARecords.value;
};
</script>

<template>
    <!-- Vitamin A Supplementation Records Information -->
    <div v-if="child" class="container">
        <div class="header2" @click="toggleVitaminARecords" style="cursor: pointer;">
            <div style="display: flex; align-items: center;">
                <h1>Vitamin A Supplementation Information</h1>
                <span style="margin-left: 10px; margin-bottom:10px;color:#488a99;">
                    {{ showVitaminARecords ? '▼' : '▲' }}
                </span>
            </div>
            <button @click.stop="handleAddClick" class="add-button">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <transition name="fade">
            <div v-if="showVitaminARecords" class="scrollable-table">
                <table class="info-table">
                    <thead>
                        <tr>
                            <th>Age</th>
                            <th>Dosage</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="!child.vitamin_a_supplementation || child.vitamin_a_supplementation.length === 0">
                            <td colspan="3" class="no-data" style="text-align: center; font-weight: normal; text-transform: none;">No vitamin A supplementation records available.</td>
                        </tr>
                        <tr v-for="record in sortedVitaminARecords" :key="record.age + record.dose">
                            <td>{{ record.age + " " + record.age_unit.toLowerCase() }}</td> 
                            <td>{{ record.dose }}</td>
                            <td>{{ formatDate(record.date) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </transition>
    </div>

    <!-- Add vitamin A supplementation record modal -->
    <transition name="fade">
        <div v-if="showAddModal" class="modal-overlay">
            <div class="modal-content">
                <h2 class="add-vac" style="color: #488a99;">Add Vitamin A Supplementation</h2>
                <form @submit.prevent="addRecord">
                    <!-- Form fields for adding a new record -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="age">Age:</label>
                            <input type="number" v-model="newRecord.age" required />
                        </div>
                        <div class="form-group">
                            <label for="age_unit">Age Unit:</label>
                            <select v-model="newRecord.age_unit" required>
                                <option value=""></option>
                                <option value="months">months</option>
                                <option value="years">years</option>
                            </select>
                        </div>
                    </div>
                    <label for="dose">Dosage:</label>
                    <select v-model="newRecord.dose" required>
                        <option value=""></option>
                        <option value="100,000 IU">100,000 LU</option>
                        <option value="200,000 IU">200,000 LU</option>
                    </select>
                    <label for="date">Date:</label>
                    <input type="date" v-model="newRecord.date" :max="today" required />
                    <div class="button-container">
                        <button type="submit">Add</button>
                        <button type="button" @click="showAddModal = false">Cancel</button>
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
.scrollable-table {
    max-height: 350px;
    overflow-y: auto;
    margin-top: 10px;
    scroll-snap-type: y mandatory;
    position: relative;
}
.scrollable-table > .data-table {
    width: 100%;
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
.header2 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 2px solid #ddd;
    position: relative;
    margin-left: -.5px;
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
}
.info-table thead th {
    position: sticky;
    top: 0;
    background-color: #007bff;
    padding: 10px;
    text-align: center;
    font-weight: bold;
    z-index: 1;
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
.form-group:last-child {
    margin-right: 0;
}
</style>