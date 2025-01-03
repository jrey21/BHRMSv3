<script setup>
import FormLayout from '../../Layouts/FormLayout.vue';
import { ref, onMounted, computed, watchEffect } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

defineOptions({
    layout: FormLayout
});

const vaccinationRecords = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get(route('vaccination-record-data'));
        console.log('API Response:', response.data); // Log the API response
        vaccinationRecords.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('vaccination-record-data'));
        console.log('API Response:', response.data); // Log the API response
        vaccinationRecords.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});
const currentPage = ref(1);
const itemsPerPage = 20;

const searchQuery = ref('');

const filteredData = computed(() => {
    if (!searchQuery.value) {
        return vaccinationRecords.value;
    }
    return vaccinationRecords.value.filter(data =>
        data.first_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        data.last_name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const sortOption = ref(''); // New state for sorting option

const sortedData = computed(() => {
    let data = [...filteredData.value];
    data.forEach(person => {
        if (person.vaccination_records.length > 1) {
            person.vaccination_records.sort((a, b) => new Date(b.date) - new Date(a.date));
        }
    });
    if (sortOption.value === 'asc') {
        data.sort((a, b) => a.first_name.localeCompare(b.first_name));
    } else if (sortOption.value === 'desc') {
        data.sort((a, b) => b.first_name.localeCompare(a.first_name));
    } else if (sortOption.value === 'age') {
        data.sort((a, b) => a.age - b.age);
    } else if (sortOption.value === 'zone') {
        data.sort((a, b) => a.zone.localeCompare(b.zone));
    }
    return data;
});

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    console.log('Current Page:', currentPage.value);
    console.log('Items Per Page:', itemsPerPage);
    console.log('Start Index:', start);
    console.log('End Index:', end);
    console.log('Total Data:', sortedData.value.length);
    return sortedData.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(vaccinationRecords.value.length / itemsPerPage);
});

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const formatDoseNumber = (doseNumber) => {
    if (doseNumber === 'dose_1') return 'Dose 1';
    if (doseNumber === 'dose_2') return 'Dose 2';
    if (doseNumber === 'dose_3') return 'Dose 3';
    if (doseNumber === 'dose_4') return 'Dose 4';
    if (doseNumber === 'dose_5') return 'Dose 5';
    if (doseNumber === 'booster') return 'Booster';
    return doseNumber;
};

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const getVaccineName = (record) => {
    return record.vaccine_name === 'Other' ? record.other_vaccine_name : record.vaccine_name;
};
</script>

<template>
     <Head title=" | Vaccination Records"/>
     <div class="header">
        <h1 class="text-slate-500">List of Vaccinated</h1>
    </div>
    <div class="data-pwd-list">
        <div class="action-bar">
            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search" style="margin-left: 8px;"></i>
                    <input type="text" v-model="searchQuery" placeholder="Search by name ..." />
                </div>
            </div>
            <div>
                <select v-model="sortOption" class="sort-select">
                    <option value="">Sort By</option>
                    <option value="asc">Name (A-Z)</option>
                    <option value="desc">Name (Z-A)</option>
                    <option value="age">Age</option>
                    <option value="zone">Zone</option>
                </select>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Zone</th>
                    <th>Vaccine Name</th>
                    <th>Dose Number</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="paginatedData.length === 0">
                    <td colspan="9">No vaccination records found</td>
                </tr>
                <template v-for="data in paginatedData" :key="data.id">
                    <tr v-for="(record, index) in data.vaccination_records" :key="record.id">
                        <td v-if="index === 0" :rowspan="data.vaccination_records.length">{{ data.first_name }} {{ data.last_name }}</td>
                        <td v-if="index === 0" :rowspan="data.vaccination_records.length">{{ data.zone }}</td>
                        <td>{{ getVaccineName(record) }}</td>
                        <td>{{ formatDoseNumber(record.dose_number) }}</td>
                        <td>{{ formatDate(record.date) }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>

<style>
.header {
    margin-bottom: 20px;
    font-size: 20px;
    margin-top: 15px;
    margin-left: 5%;
}
.data-pwd-list {
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-left: 5%;
}

.data-pwd-list h2 {
    color: #488a99;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.data-pwd-list table {
    width: 100%;
    border-collapse: collapse;
}

.data-pwd-list th, .data-pwd-list td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
    font-size: 14px;
}

.data-pwd-list th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    cursor: pointer;
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
.action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0;
    margin-bottom: 10px;
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

.action-bar button {
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
    font-size: 14px;
}

.action-bar button:hover {
    background-color: #0056b3;
}

.sort-select {
    padding: 5px;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}
</style>
