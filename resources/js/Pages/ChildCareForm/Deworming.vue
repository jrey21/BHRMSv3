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

const calculateAge = (birthDate, recordDate) => {
    const birth = new Date(birthDate);
    const record = new Date(recordDate);
    let age = record.getFullYear() - birth.getFullYear();
    let age_unit = 'years';

    const monthDiff = record.getMonth() - birth.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && record.getDate() < birth.getDate())) {
        age--;
    }

    if (age === 0) {
        age = monthDiff + (record.getDate() < birth.getDate() ? -1 : 0);
        age_unit = 'months';
    }

    if (age < 1 && age_unit === 'years') {
        age = monthDiff + (record.getDate() < birth.getDate() ? -1 : 0);
        age_unit = 'months';
    }

    if (age_unit === 'months' && age < 0) {
        age = 0;
    }

    if (age === 1 && age_unit === 'years') {
        age_unit = 'year';
    }

    return { age, age_unit };
};

const resetForm = () => {
    newRecord.value = {
        date:'',
        deworming_medicine: '',
        other_deworming_medicine: '',
        administered_by: '',
    };
};
const sortedDewormingRecords = computed(() => {
    const records = props.child.deworming.map(record => {
        const { age, age_unit } = calculateAge(props.child.birth_date, record.date);
        return {
            date: record.date,
            age,
            age_unit,
            deworming_medicine: record.deworming_medicine,
            other_deworming_medicine: record.other_deworming_medicine,
            administered_by: record.administered_by,
        };
    });
    return records;
});

console.log(props.child.deworming);

const showAddModal = ref(false);
const showFlashMessage = ref(false);
const flashMessage = ref('');
const showdewormingRecords = ref(true);

const newRecord = ref({
    date: '',
    age: '',
    age_unit: '',
    deworming_medicine: '',
    other_deworming_medicine: '',
    administered_by: '',
});

const today = new Date().toISOString().split('T')[0];

const handleAddClick = () => {
    showAddModal.value = true;
};

const addRecord = () => {
    const { age, age_unit } = calculateAge(props.child.birth_date, newRecord.value.date);
    newRecord.value.age = age;
    newRecord.value.age_unit = age_unit;

    axios.post(`/child/${props.child.id}/addDeworming`, { ...newRecord.value })
        .then(response => {
            console.log('Record Added:', response.data);
            showAddModal.value = false;
            flashMessage.value = 'Record added successfully!';
            showFlashMessage.value = true;
            setTimeout(() => (showFlashMessage.value = false), 5000);
            props.child.deworming.push(response.data.record);
            resetForm();
        })
        .catch(error => {
            flashMessage.value = 'Failed to add record! ' + (error.response?.data?.message || error.message);
            showFlashMessage.value = true;
            setTimeout(() => (showFlashMessage.value = false), 5000);
        });
};

const toggledeworming = () => {
    showdewormingRecords.value = !showdewormingRecords.value;
};
</script>

<template>
    <!-- deworming Records Information -->
    <div v-if="child" class="container">
        <div class="header6" @click="toggledeworming" style="cursor: pointer;">
            <div style="display: flex; align-items: center;">
                <h1>Deworming (every 6 months starting at 1 year old)</h1>
                <span style="margin-left: 10px; margin-bottom:10px;color:#488a99;">
                    {{ showdewormingRecords ? '▼' : '▲' }}
                </span>
            </div>
            <button @click.stop="handleAddClick" class="add-button">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <transition name="fade">
            <div v-if="showdewormingRecords" class="scrollable-table">
                <table class="info-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Age</th>
                            <th>Deworming Medicine</th>
                            <th>Administered by</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="!child.deworming || child.deworming.length === 0">
                            <td colspan="4" class="no-data" style="text-align: center; font-weight: normal; text-transform: none;">No deworming records available.</td>
                        </tr>
                        <tr v-for="record in sortedDewormingRecords" :key="record.date">
                            <td>{{ formatDate(record.date) }}</td>
                            <td>{{ record.age + " " + record.age_unit }}</td>
                            <td>{{ record.deworming_medicine === 'Others' ? record.other_deworming_medicine : record.deworming_medicine }}</td>
                            <td>{{ record.administered_by }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </transition>
    </div>

    <!-- Add deworming record modal -->
    <transition name="fade">
        <div v-if="showAddModal" class="modal-overlay">
            <div class="modal-content">
                <h2 class="add-vac" style="color: #488a99;">Add Deworming Record</h2>
                <form @submit.prevent="addRecord">
                    <!-- Form fields for adding a new record -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="date">Record Date:</label>
                            <input type="date" v-model="newRecord.date" :max="today" required />
                        </div>
                    </div>
                    <!-- <div class="form-row">
                        <div class="form-group">
                            <label for="age">Age:</label>
                            <input type="number" v-model="newRecord.age" required style="width: 60%;" />
                            <select name="age_unit" id="age_unit" v-model="newRecord.age_unit" required style="width: 35%; margin-left: 5%;">
                                <option value="">Select</option>
                                <option value="months">months</option>
                                <option value="years">years</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="deworming_medicine">Deworming Medicine</label>
                           <select name="deworming_medicine" id="deworming_medicine" v-model="newRecord.deworming_medicine" required>
                                <option value="">Select</option>
                                <option value="Albendazole">Albendazole</option>
                                <option value="Mebendazole">Mebendazole</option>
                                <option value="Pyrantel Pamoate">Pyrantel Pamoate</option>
                                <option value="Others">Others</option>
                           </select>
                        </div>
                    </div>
                    <input v-if="newRecord.deworming_medicine === 'Others'" type="others_deworming_medicine" v-model="newRecord.other_deworming_medicine" placeholder="Please specify other deworming medicine" required>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="administered_by">Administered by</label>
                            <input type="text" v-model="newRecord.administered_by" required />
                        </div>
                    </div>
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
.header6 {
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
    color: white;
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
.info-table td:nth-child(2){
    width: 10%; 
}
.info-table td:nth-child(3),.info-table td:nth-child(4){
    width: 15%; 
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