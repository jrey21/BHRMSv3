<script setup>
import { ref, onMounted, computed, watchEffect } from 'vue';
import axios from 'axios';
import QRCode from 'qrcode';
import FormLayout from '../../Layouts/FormLayout.vue';
import jsPDF from 'jspdf';
import 'jspdf-autotable';
import { useRouter } from 'vue-router';

defineOptions({
    layout: FormLayout
});

const dataCitizens = ref([]);

onMounted(async () => {
    try {
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('senior-citizen-data'));
        dataCitizens.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});
const currentPage = ref(1);
const itemsPerPage = 20;

const searchQuery = ref('');

const filteredData = computed(() => {
    if (!searchQuery.value) {
        return dataCitizens.value;
    }
    return dataCitizens.value.filter(data =>
        data.first_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        data.last_name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const sortOption = ref('');

const sortedData = computed(() => {
    let data = [...filteredData.value];
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
    return sortedData.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(dataCitizens.value.length / itemsPerPage);
});

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const generateQRCode = async (text) => {
    try {
        return await QRCode.toDataURL(text);
    } catch (error) {
        console.error('Error generating QR code:', error);
        return '';
    }
};

const paginatedDataWithQR = ref([]);

watchEffect(async () => {
    const dataWithQR = [];
    for (const data of paginatedData.value) {
        const qrCode = await generateQRCode(`${data.first_name} ${data.last_name}` + '\n' + `Age: ${data.age}` + '\n' + `Sex: ${data.sex}` + '\n' + `${data.zone}`);
        dataWithQR.push({ ...data, qrCode });
    }
    paginatedDataWithQR.value = dataWithQR;
});

const totalCitizens = computed(() => dataCitizens.value.length);

defineExpose({
    totalCitizens
});

</script>

<template>
     <Head title=" | Senior Citizen"/>
     <div class="header">
        <h1 class="text-slate-500">Senior Citizen List</h1>
        <!-- <p>Total Senior Citizens: {{ totalCitizens }}</p> -->
    </div>
    <div class="data-citizen-list">
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
                    <th>Age</th>
                    <th>Sex</th>
                    <th>Zone</th>
                    <th>QR Code</th>
                </tr>
            </thead>
            <tbody>
                    <tr v-if="paginatedDataWithQR.length === 0">
                        <td colspan="5">No senior citizens data found</td>
                    </tr>
                    <tr v-for="data in paginatedDataWithQR" :key="data.id">
                        <td>{{ data.first_name.charAt(0).toUpperCase() + data.first_name.slice(1) + " " + data.last_name.charAt(0).toUpperCase() + data.last_name.slice(1) }}</td>
                        <td>{{ data.age }}</td>
                        <td>{{ data.sex.charAt(0).toUpperCase() }}</td>
                        <td>{{ data.zone }}</td>
                        <td><img :src="data.qrCode" alt="QR Code" /></td>
                    </tr>
                </tbody>
        </table>
    </div>
</template>

<style>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    margin-left: 5%;
}

.data-citizen-list {
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-left: 5%;
}

.data-citizen-list h2 {
    color: #488a99;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.data-citizen-list table {
    width: 100%;
    border-collapse: collapse;
}

.data-citizen-list th, .data-citizen-list td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
    font-size: 14px;
}

.data-citizen-list th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.data-citizen-list img {
    width: 50px;
    height: 50px;
    display: block;
    margin: 0 auto; /* Center the QR code */
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
    margin-left: 10px; /* Add margin to separate buttons */
    cursor: pointer; /* Ensure the button has a pointer cursor */
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