<script setup>
import { ref, onMounted, computed, watchEffect } from 'vue';
import axios from 'axios';
import FormLayout from '../../Layouts/FormLayout.vue';
import jsPDF from 'jspdf';
import 'jspdf-autotable';

defineOptions({ layout: FormLayout });

const distributionData = ref([]);
const searchQuery = ref('');
const medicineTypeFilter = ref('');
const medicineTypes = ref([]);

const filteredData = computed(() => {
    let data = distributionData.value;
    if (searchQuery.value) {
        data = data.filter(item =>
            item.beneficiary_name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    }
    if (medicineTypeFilter.value) {
        data = data.filter(item =>
            item.medicine_name.toLowerCase().includes(medicineTypeFilter.value.toLowerCase())
        );
    }
    return data;
});

const currentPage = ref(1);
const itemsPerPage = 20;

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredData.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(filteredData.value.length / itemsPerPage);
});

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

onMounted(async () => {
    try {
        const response = await axios.get(route('medicine-list-distributed-data'));
        distributionData.value = response.data;
        // Extract unique medicine types
        medicineTypes.value = [...new Set(response.data.map(item => item.medicine_name))];
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('medicine-list-distributed-data'));
        distributionData.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

const showModal = ref(false);
const selectedDistributions = ref(null);

const editData = (distribution) => {
    selectedDistributions.value = { ...distribution };
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedDistributions.value = null;
};

const flashMessage = ref('');
const showFlashMessage = ref(false);

const saveChanges = async () => {
    try {
        const response = await axios.put(route('distribution-update', { id: selectedDistributions.value.id }), selectedDistributions.value);
        const index = distributionData.value.findIndex(distribution => distribution.id === selectedDistributions.value.id);
        if (index !== -1) {
            distributionData.value[index] = response.data;
        } else {
            console.error('Distribution not found in local state');
        }

        flashMessage.value = 'Changes saved successfully!';
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 500);
        closeModal();
    } catch (error) {
        console.error('Error updating distribution data:', error);
        flashMessage.value = `Error saving changes: ${JSON.stringify(error.response.data)}`;
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 900);
    }
};

const deleteData = async (benificiary) => {
    if (confirm('Are you sure you want to delete this distribution?')) {
        try {
            await axios.delete(route('distribution-delete', { id: benificiary.id }));
            distributionData.value = distributionData.value.filter(item => item.id !== benificiary.id);
            flashMessage.value = 'Distribution deleted successfully!';
            showFlashMessage.value = true;
            setTimeout(() => {
                showFlashMessage.value = false;
            }, 500);
        } catch (error) {
            console.error('Error deleting distribution data:', error);
            flashMessage.value = `Error deleting distribution: ${JSON.stringify(error.response.data)}`;
            showFlashMessage.value = true;
            setTimeout(() => {
                showFlashMessage.value = false;
            }, 900);
        }
    }
};

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const downloadPDF = () => {
    let data = [...filteredData.value]; // Use filteredData to ensure the data is filtered according to the search query

    const doc = new jsPDF();

    // Set font size and alignment
    doc.setFontSize(12);
    const pageWidth = doc.internal.pageSize.getWidth();
    
    // Header section (Regular font for other titles)
    doc.setFont('helvetica', 'normal');
    doc.text('Republic of the Philippines', pageWidth / 2, 10, { align: 'center' });
    doc.text('Province of Leyte', pageWidth / 2, 16, { align: 'center' });
    doc.text('City of Baybay', pageWidth / 2, 22, { align: 'center' });

    // Add more space before the "Distribution Data" title
    doc.setFontSize(14);
    doc.setFont('helvetica', 'bold');
    doc.text('Medicine Distribution', pageWidth / 2, 40, { align: 'center' });
    
    // Bold font for the "BHS PATAG" title
    doc.setFont('helvetica', 'bold');
    doc.text('BHS PATAG', pageWidth / 2, 50, { align: 'center' });
    
    // Adjusted top margin for the table
    const tableStartY = 60;
    
    doc.autoTable({
        head: [['', 'Beneficiary Name', 'Medicine Name', 'Quantity', 'Date']],
        body: data.map((data, index) => [
            `${index + 1}.`, 
            data.beneficiary_name,
            data.medicine_name,
            data.distributed_quantity,
            formatDate(data.distribution_date)
        ]),
        startY: tableStartY, // Adjusted top margin
        didDrawPage: function (data) {
            // Add page number
            let pageCount = doc.internal.getNumberOfPages();
            doc.setFontSize(10);
            doc.setTextColor(150); 
            doc.text(`Page ${pageCount}`, doc.internal.pageSize.width / 2, doc.internal.pageSize.height - 10, { align: 'center' });
        }
    });
    doc.save('Medicine-distribution.pdf');
};

const capitalizeFirstLetter = (string) => {
    return string.replace(/\b\w/g, char => char.toUpperCase());
};

const refreshTable = async () => {
    try {
        const response = await axios.get(route('medicine-list-distributed-data'));
        distributionData.value = response.data;
        // Extract unique medicine types
        medicineTypes.value = [...new Set(response.data.map(item => item.medicine_name))];
    } catch (error) {
        console.error('Error refreshing data:', error);
    }
};

</script>

<template>
    <transition name="fade">
        <div v-if="showFlashMessage" class="flash-modal">
            <div class="flash-content">{{ flashMessage }}</div>
        </div>
    </transition>
    <div class="header">
        <h1 class="beneficiary-head text-slate-500" style="margin-bottom:20px;">Beneficiaries</h1>
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
                <div class="search-box">
                    <i class="fas fa-filter" style="margin-left: 8px;"></i>
                    <select v-model="medicineTypeFilter">
                        <option value="">All Medicines</option>
                        <option v-for="type in medicineTypes" :key="type" :value="type">{{ type }}</option>
                    </select>
                </div>
                <button class="refresh-button" @click="refreshTable"><i class="fas fa-sync-alt"></i></button>
                <button class="download-button" @click="downloadPDF"><i class="fas fa-download"></i></button>
            </div>
        </div>
        <div class="scrollable-table">
            <table class="data-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Beneficiary Name</th>
                        <th>Medicine Name</th>
                        <th>Quantity</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="paginatedData.length === 0">
                        <td colspan="6">No data found</td>
                    </tr>
                    <tr v-for="data in paginatedData" :key="data.id">
                        <td>{{ distributionData.indexOf(data) + 1 +"." }}</td>
                        <td>{{ capitalizeFirstLetter(data.beneficiary_name) }}</td>
                        <td>{{ data.medicine_name }}</td>
                        <td>{{ data.distributed_quantity }}</td>
                        <td>{{ formatDate(data.distribution_date) }}</td>
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
</template>

<style scoped>
h2 {
    color: #488a99;
    font-size: 18px;
    font-weight: bold;
    margin-top: -25px;
    margin-left: 10%;
}
.search-container {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
}
.form-group {
    flex: 1;
}
.form-row {
    display: flex;
    justify-content: space-between;
}
.medium-text {
    flex: 0 0 350px;
    margin-right: 3%;
}
.date {
    margin-right: 50%;
}
.search-box {
    display: flex;
    align-items: center;
    width: 240px;
    padding: 2px;
    border: 2px solid #9dc0e6;
    border-radius: 50px;
    background-color: #fff;
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
    /* margin-right: 10px;  */
}
.search-box i {
    font-size: 14px;
    color: #007bff;
    margin-right: 8px;
}
.search-box input,
.search-box select { 
    font-size: 14px;
    border: none;
    outline: none;
    color: #333;
    height: 25px;
    flex: 1; 
    padding-left: 8px; 
}
.data-container {
    width: 100%;
    margin-left: 10%;
    padding: 20px;
    margin-top: -30px;
    margin-bottom: 15%;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.scrollable-table {
    height: 450px;
    overflow-y: auto;
    margin-top: 10px;
    scroll-snap-type: y mandatory;
}
.scrollable-table > .data-table {
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
    height: 50px;
    position: sticky;
    top: -1px;
}
.data-table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
    color: #464545;
}
.data-table tr {
    scroll-snap-align: start;
}
.data-table td.td-title {
    color: #464545;
    text-align: left;
}
.data-table th, .data-table td {
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.data-table th:nth-child(1) {
    width: 5%;
}
.data-table th:nth-child(2) {
    width: 30%;
}
.data-table th:nth-child(3) {
    width: 25%;
}
.data-table th:nth-child(4) {
    width: 10%;
}
.data-table th:nth-child(5) {
    width: 20%;
}
.data-table td {
    max-width: 0;
}
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    margin-top: -40px;
    margin-left:10% ;
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
}
.edit-button:hover {
    background-color: #e0a800;
    transform: scale(1.1);
}
.view-button {
    background-color: #17a2b8;
    border: none;
    color: white;
    padding: 3px 5px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}
.view-button:hover {
    background-color: #138496;
    transform: scale(1.1);
}
.edit-button {
    margin-right: 10px;
}
/* .benificiary-head {
    font-size: 20px;
    margin-left: 10%;
} */
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
.modal form select {
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
    width: 100%;
    max-width: 820px;
    align-self: center;
}
.modal form button:hover {
    background-color: #0056b3;
}
.flash-modal {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    position: fixed;
    z-index: 2;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 20px;
}
.flash-content {
    background-color: #155724;
    color: #d4edda;
    padding: 20px;
    border: 1px solid #155724;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    width: 80%;
    max-width: 600px;
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
    margin-left: 10px;
}
.sort-button:hover {
    background-color: #0056b3;
}
.delete-button {
    background-color: #dc3545;
    border: none;
    color: white;
    padding: 3px 5px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}
.delete-button:hover {
    background-color: #c82333;
    transform: scale(1.1);
}
.toggle-button {
    background-color: #007bff;
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
.toggle-button:hover {
    background-color: #0056b3;
}
.toggle-indicator {
    font-size: 18px;
    margin-left: 10px;
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
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s ease;
    /* margin-left: 10px; */
}
.download-button:hover {
    background-color: #0056b3;
}
.refresh-button {
    background-color: #28a745; 
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
    margin-left: 10px;
}
.refresh-button:hover {
    background-color: #218838; 
}
</style>
