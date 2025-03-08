<script setup>
import FormLayout from '../../Layouts/FormLayout.vue';
import { ref, onMounted, computed, watchEffect } from 'vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3'; 
import jsPDF from 'jspdf';
import 'jspdf-autotable';

defineOptions({
    layout: FormLayout
});

const vaccinationRecords = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get(route('vaccination-record-data'));
        console.log('API Response:', response.data); 
        vaccinationRecords.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('vaccination-record-data'));
        console.log('API Response:', response.data); 
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

const sortOption = ref(''); 

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

const downloadPDF = () => {
    let data = [...sortedData.value]; 

    const doc = new jsPDF();

    // Set font size and alignment
    doc.setFontSize(12);
    const pageWidth = doc.internal.pageSize.getWidth();
    
    // Header section (Regular font for other titles)
    doc.setFont('helvetica', 'normal');
    doc.text('Republic of the Philippines', pageWidth / 2, 10, { align: 'center' });
    doc.text('Province of Leyte', pageWidth / 2, 16, { align: 'center' });
    doc.text('City of Baybay', pageWidth / 2, 22, { align: 'center' });

    
    // Bold font for the "Vaccination Records" title
    doc.setFont('helvetica', 'normal');
    doc.text('VACCINATION RECORDS', pageWidth / 2, 40, { align: 'center' });

    // Bold font for the "BHS PATAG" title
    doc.setFont('helvetica', 'bold');
    doc.text('BHS PATAG', pageWidth / 2, 50, { align: 'center' });

    // Adjusted top margin for the table
    const tableStartY = 60;
    
    doc.autoTable({
        head: [['', 'Name', 'Zone', 'Vaccine Name', 'Dose Number', 'Date']],
        body: data.flatMap((data, index) => 
            data.vaccination_records.map((record, recordIndex) => [
                recordIndex === 0 ? `${index + 1}.` : '',
                recordIndex === 0 ? `${data.last_name.charAt(0).toUpperCase() + data.last_name.slice(1)}, ${data.first_name.charAt(0).toUpperCase() + data.first_name.slice(1)}` : '',
                recordIndex === 0 ? data.zone : '',
                getVaccineName(record),
                formatDoseNumber(record.dose_number),
                formatDate(record.date)
            ])
        ),
        startY: tableStartY, // Adjusted top margin
        didDrawPage: function (data) {
            // Add page number
            let pageCount = doc.internal.getNumberOfPages();
            doc.setFontSize(10);
            doc.setTextColor(150); 
            doc.text(`Page ${pageCount}`, doc.internal.pageSize.width / 2, doc.internal.pageSize.height - 10, { align: 'center' });
        }
    });
    doc.save('Vaccination-Records.pdf');
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
                    <!-- <option value="age">Age</option> -->
                    <option value="zone">Zone</option>
                </select>
                <button @click="downloadPDF" class="download-button"> <i class="fas fa-download"></i></button>
            </div>
        </div>
        <div class="scrollable-table">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Zone</th>
                    <th>Vaccine Name</th>
                    <th>Dose Number</th>
                    <th>Date</th>
                    <th>Administered by</th>
                    <th>Action</th>
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
                        <td>{{ record.administered_by }}</td>
                        <td v-if="index === 0" :rowspan="data.vaccination_records.length">
                            <button @click="router.get(route('child.show', { id: data.id }))" class="address-button">
                                <i class="fas fa-address-card"></i>
                            </button>
                        </td>
                    </tr>
                </template>
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
</template>

<style>
.address-button {
    background-color: #17a2b8; 
    border: none;
    color: white;
    padding: 3px 5px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    margin-top: 5px;
    margin-bottom: 5px;
}

.address-button:hover {
    background-color: #138496; 
    transform: scale(1.1);
}
.download-button {
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
    margin-left: 10px;
}

.download-button:hover {
    background-color: #0056b3;
}
.scrollable-table{
    height:480px;
    overflow-y: auto;
    margin-top:10px;
    scroll-snap-type: y mandatory;
    scrollbar-width: thin; 
    scrollbar-color: #ccc #f9f9f9; 
}

/* Webkit browsers */
.scrollable-table::-webkit-scrollbar {
    width: 8px;
}

.scrollable-table::-webkit-scrollbar-track {
    background: #f9f9f9;
}

.scrollable-table::-webkit-scrollbar-thumb {
    background-color: #007bff;
    border-radius: 10px;
    border: 1px solid #f9f9f9;
}

.scrollable-table > .data-table{
    width: 100%;
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
.header {
    margin-bottom: 20px;
    font-size: 20px;
    margin-top: 15px;
    margin-left: 5%;
    margin-top: 1%;
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
    position: sticky;
    top: -1px;
    border: 1px solid #ccc; 
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

.action-bar > div {
    display: flex;
    align-items: center;
}

.action-bar > div > .sort-select {
    margin-right: 10px;
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
