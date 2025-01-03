<script setup>
import { ref, onMounted, computed, watchEffect } from 'vue';
import { router } from '@inertiajs/vue3'; 
import axios from 'axios';
import FormLayout from '../../Layouts/FormLayout.vue';

defineOptions({ layout: FormLayout });

const pneaData = ref([]);
const searchQuery = ref(''); 

const filteredData = computed(() => {
    if (!searchQuery.value) {
        return pneaData.value;
    }
    return pneaData.value.filter(data =>
        data.fullName.toLowerCase().includes(searchQuery.value.toLowerCase()),
    );
});

const currentPage = ref(1);
const itemsPerPage = 20;

const sortOrder = ref('asc'); 

const sortedData = computed(() => {
    return [...filteredData.value].sort((a, b) => {
        const nameA = a.fullName.toLowerCase();
        const nameB = b.fullName.toLowerCase();
        if (sortOrder.value === 'asc') {
            return nameA.localeCompare(nameB);
        } else {
            return nameB.localeCompare(nameA);
        }
    });
});

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return sortedData.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(filteredData.value.length / itemsPerPage);
});

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const toggleSortOrder = () => {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
};

onMounted(async () => {
    try {
        const response = await axios.get(route('pnea-enrollment-data'));
        pneaData.value = response.data;
    } catch (error) {
        console.error('Error fetching pnea enrollment data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('pnea-enrollment-data'));
        pneaData.value = response.data;
    } catch (error) {
        console.error('Error fetching childcare data:', error);
    }
});

const showModal = ref(false);
const selectedPnea = ref(null);
const pneaCopy = ref({});

const editData = (child) => {
    selectedPnea.value = child;
    pneaCopy.value = { ...child }; // Create a copy of the selected child data
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedPnea.value = null;
    pneaCopy.value = {}; // Clear the copy
};

const flashMessage = ref('');
const showFlashMessage = ref(false);

const saveChanges = async () => {
    try {
        // Ensure pneaCopy only contains fields that exist in the database
        const { pinkCardNumber, fullName, birth_date, zone, term_of_pregnancy, date, age, education, occupation, number_of_pregnancy, date_last_delivery, number_of_children, interval_of_delivery, muac, height, weight, bmi, ns, name_of_husband, husband_age, husband_education, husband_occupation, monthly_family_income, household_size } = pneaCopy.value;
        const response = await axios.put(route('pnea-enrollment-update', { id: selectedPnea.value.id }), {
            pinkCardNumber,
            fullName,
            birth_date,
            zone,
            term_of_pregnancy,
            date,
            age,
            education,
            occupation,
            number_of_pregnancy,
            date_last_delivery,
            number_of_children,
            interval_of_delivery,
            muac,
            height,
            weight,
            bmi,
            ns,
            name_of_husband,
            husband_age,
            husband_education,
            husband_occupation,
            monthly_family_income,
            household_size
        });
        const index = pneaData.value.findIndex(child => child.id === selectedPnea.value.id);
        if (index !== -1) {
            pneaData.value[index] = response.data;
        }
        flashMessage.value = 'Changes saved successfully!';
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 900); 
        closeModal();
    } catch (error) {
        console.error('Error updating data:', error);
        flashMessage.value = `Error saving changes: ${JSON.stringify(error.response.data)}`;
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 5000); 
    }
};

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const capitalizeFirstLetter = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1);
};
</script>

<template>
    <Head title=" | Pregnant Women"/>
    <transition name="fade">
        <div v-if="showFlashMessage" class="flash-modal">
            <div class="flash-content">{{ flashMessage }}</div>
        </div>
    </transition>
    <div class="header">
        <h1 class="child-head text-slate-500">List of Pregnant Women</h1>
    </div>
    <div class="data-container">
        <div class="action-bar">
            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search" style="margin-left: 8px;"></i>
                    <input type="text" v-model="searchQuery" placeholder="Search by name ..." />
                </div>
            </div>
            <div>
                <button @click="toggleSortOrder" class="sort-button">
                    <i :class="sortOrder === 'asc' ? 'fas fa-sort-alpha-down' : 'fas fa-sort-alpha-up'"></i>
                </button>
                <button @click="router.get(route('pnea-enrollment'))" class="add-button">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="scrollable-table">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Pink Card Number</th>
                        <th>Name</th>
                        <th>Birth Date</th>
                        <th>Zone</th>
                        <th>Term of Pregnancy</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="paginatedData.length === 0">
                        <td colspan="6">No data found</td>
                    </tr>
                    <tr v-for="data in paginatedData" :key="data.id">
                        <td>{{ data.pinkCardNumber }}</td>
                        <td>{{ data.fullName }}</td>
                        <td>{{ formatDate(data.birth_date) }}</td>
                        <td>{{ data.zone}}</td>
                        <td>{{ capitalizeFirstLetter(data.term_of_pregnancy) }}</td>
                        <td>
                            <button @click="editData(data)" class="edit-button">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button @click="router.get(route('pnea.show', { id: data.id }))" class="address-button">
                                <i class="fas fa-address-card"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1">
                <i class="fas fa-chevron-left"></i>
            </button>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
    <div v-if="showModal" class="modal">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>Update Personal Details</h2>
            <div style="padding-bottom: 8px;"></div>
            <hr>
            <form @submit.prevent="saveChanges">
                <div class="form-row">
                    <div class="form-group-middleName">
                        <label for="fullName" style="color: #888;">Full Name:</label>
                        <input type="text" v-model="pneaCopy.fullName" id="fullName" :placeholder="pneaCopy.fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="pinkCardNumber" style="color: #888;">Pink Card Number:</label>
                        <input type="text" v-model="pneaCopy.pinkCardNumber" id="pinkCardNumber" :placeholder="pneaCopy.pinkCardNumber" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="birth_date" style="color: #888;">Birth Date:</label>
                        <input type="date" v-model="pneaCopy.birth_date" id="birth_date" :placeholder="selectedPnea.birth_date" required>
                    </div>
                    <div class="form-group-zone">
                        <label for="zone" style="color: #888;">Zone: ({{ selectedPnea.zone }})</label>
                        <select name="zone" id="zone" v-model="pneaCopy.zone" required>
                            <option value="">Select</option>
                            <option value="Zone 1">Zone 1</option>
                            <option value="Zone 2">Zone 2</option>
                            <option value="Zone 3">Zone 3</option>
                            <option value="Zone 4">Zone 4</option>
                            <option value="Zone 5">Zone 5</option>
                            <option value="Zone 6">Zone 6</option>
                            <option value="Zone 7">Zone 7</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="term_of_pregnancy" style="color: #888;">Term of Pregnancy:</label>
                        <input type="text" v-model="pneaCopy.term_of_pregnancy" id="term_of_pregnancy" :placeholder="pneaCopy.term_of_pregnancy" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="date" style="color: #888;">Date:</label>
                        <input type="date" v-model="pneaCopy.date" id="date" :placeholder="pneaCopy.date" required>
                    </div>
                </div>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>
</template>

<style scoped>
h2{
    color: #488a99;
    font-size: 18px;
    font-weight: bold;
}
.search-container {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
}

/* Styling for the search box */
.search-box {
    display: flex;
    align-items: center;
    width: 240px; 
    padding: 2px; 
    border: 2px solid #9dc0e6; 
    border-radius: 50px; 
    background-color: #fff; 
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1); 
}

/* Styling for the search icon */
.search-box i {
    font-size: 14px;
    color: #007bff; 
    margin-right: 8px;
}

/* Styling for the input field */
.search-box input {
    font-size: 14px;
    border: none;
    outline: none;
    color: #333;
    height: 25px; 
}

.data-container {
    margin-left: 5%;
    margin-right: auto;
    width: 100%;
    padding: 20px;
    margin-top: 0;
    margin-bottom: 15%;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.scrollable-table{
    height:480px;
    overflow-y: auto;
    margin-top:10px;
    scroll-snap-type: y mandatory;
}
.scrollable-table > .data-table{
    width: 100%;
}
.data-table {
    width: 100%; 
    font-size: 14px;
    border-collapse: collapse;
}
.data-table th {
    background-color: #007bff;
    border: 1px solid #ccc;
    color: white;
    font-weight: bold;
    font-family: 'Arial';
    letter-spacing: 1px;
    height: 40px;
    position:sticky;
    top:-1px;
}

.data-table td {
    border: 1px solid #ccc;
    padding: 0 10px;
    text-align: center;
    color:#464545;
}
.data-table tr{
    scroll-snap-align: start;
}

.data-table td.td-name {
    color:#464545;
    text-align: left;
}

.data-table th, .data-table td {
    width: auto; 
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.data-table td {
    max-width: 0;
}
.data-table td:nth-child(1) {
    width: 15%; 
}

.data-table td:nth-child(2) {
    width: 30%; 
}

.data-table td:nth-child(3) {
    width: 15%; 
}

.data-table td:nth-child(4) {
    width: 10%; 
}

.data-table td:nth-child(5) {
    width: 20%; 
}

.data-table td:nth-child(6) {
    width: 20%;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    margin-left: 5%;
}

.action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0;
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
    margin-top: 0; 
    cursor: pointer;
    border-radius: 8px; 
    transition: background-color 0.3s ease; 
}

.add-button:hover {
    background-color: #45a049; 
}

.search-bar {
    width: 200px; 
    padding: 5px;
    margin-right: 10px; 
    border: 1px solid #ccc;
    border-radius: 4px;
}

.search-bar::placeholder {
    font-size: 13px;
    padding-left: 8px;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.pagination button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 2px 8px;
    margin: 0 10px; 
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.pagination button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.pagination span {
    margin: 0 10px;
    font-size: 12px; 
}

.pagination button i {
    font-size: 14px;
}

.edit-button {
    background-color: #ffc107; 
    border: none;
    color: white;
    padding: 3px 5px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    margin-top: 3px;
    display: inline-block; /* Ensure the button is displayed as an inline-block element */
    text-align: center; /* Center the text inside the button */
    z-index: 1; /* Ensure the button is above other elements */
}

.edit-button:hover {
    background-color: #e0a800; 
    transform: scale(1.1);
}

.address-button {
    background-color: #17a2b8; 
    border: none;
    color: white;
    padding: 3px 5px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.address-button:hover {
    background-color: #138496; 
    transform: scale(1.1);
}

.edit-button {
    margin-right: 10px;
}

.child-head {
    font-size: 20px;
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

.modal-content {
    background-color: #fff;
    margin: auto;
    padding: 20px;
    border: 1px solid #ddd;
    width: 80%;
    max-width: 600px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.close {
    color: #333;
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.3s ease;
}

.close:hover,
.close:focus {
    color: #000;
}

.modal form {
    display: flex;
    flex-direction: column;
}

.modal form label {
    margin-top: 10px;
    font-weight: bold;
    color: #333;
}

.modal form input {
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.modal form button {
    margin-top: 20px;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.modal form button:hover {
    background-color: #0056b3;
}

.form-row {
    display: flex;
    justify-content: space-between;
}

.form-group-middleName{
    flex: 0 0 60%;
    margin-right: 10px;
}

.form-group-zone select {
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.form-group:last-child {
    margin-right: 0;
}
.form-group-zone{
    flex: 0 0 20%;
    margin-right: 10px;
}

.flash-modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 2;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
}

.flash-content {
    background-color: #155724;
    color: #d4edda;
    padding: 20px;
    border: 1px solid #155724;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter, .fade-leave-to {
    opacity: 0;
}

.sort-button {
    background-color: #007bff;
    border: none;
    color: white;
    padding: 5px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin-top: 0;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

.sort-button i {
    font-size: 16px;
}

.sort-button:hover {
    background-color: #0056b3;
}
</style>