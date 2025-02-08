<script setup>
import { ref, onMounted, computed, watchEffect } from 'vue';
import { router } from '@inertiajs/vue3'; 
import axios from 'axios';
import FormLayout from '../../Layouts/FormLayout.vue';
import jsPDF from 'jspdf';
import 'jspdf-autotable';

defineOptions({ layout: FormLayout });

const childcareData = ref([]);
const searchQuery = ref(''); 

const filteredData = computed(() => {
    if (!searchQuery.value) {
        return childcareData.value;
    }
    return childcareData.value.filter(data =>
        data.first_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        data.last_name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const currentPage = ref(1);
const itemsPerPage = 20;

const sortOrder = ref('asc'); // Default sort order

const sortedData = computed(() => {
    return [...filteredData.value].sort((a, b) => {
        const nameA = a.last_name.toLowerCase() + ' ' + a.first_name.toLowerCase();
        const nameB = b.last_name.toLowerCase() + ' ' + b.first_name.toLowerCase();
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
        const response = await axios.get(route('childcare-data'));
        childcareData.value = response.data;
    } catch (error) {
        console.error('Error fetching childcare data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('childcare-data'));
        childcareData.value = response.data;
    } catch (error) {
        console.error('Error fetching childcare data:', error);
    }
});

const showModal = ref(false);
const selectedChild = ref(null);
const childCopy = ref({});

const editData = (child) => {
    selectedChild.value = child;
    childCopy.value = { ...child }; // Create a copy of the selected child data
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedChild.value = null;
    childCopy.value = {}; // Clear the copy
};

const flashMessage = ref('');
const showFlashMessage = ref(false);

const saveChanges = async () => {
    try {
        const response = await axios.put(route('childcare-form-update', { id: selectedChild.value.id }), childCopy.value);
        const index = childcareData.value.findIndex(child => child.id === selectedChild.value.id);
        if (index !== -1) {
            childcareData.value[index] = response.data;
        }
        flashMessage.value = 'Changes saved successfully!';
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 900); 
        closeModal();
    } catch (error) {
        console.error('Error updating childcare data:', error);
        flashMessage.value = 'Error saving changes.';
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 900); 
    }
};

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const showDeleteModal = ref(false);
const childToDelete = ref(null);

const confirmDelete = (child) => {
    childToDelete.value = child;
    showDeleteModal.value = true;
};

const deleteData = async () => {
    try {
        await axios.delete(route('childcare-form-delete', { id: childToDelete.value.id }));
        childcareData.value = childcareData.value.filter(item => item.id !== childToDelete.value.id);
        flashMessage.value = 'Data deleted successfully!';
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 900);
        closeDeleteModal();
    } catch (error) {
        console.error('Error deleting data:', error);
        flashMessage.value = `Error deleting data: ${JSON.stringify(error.response.data)}`;
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 5000);
    }
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    childToDelete.value = null;
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

    // Add more space before the "Child Care Data" title
    doc.setFontSize(14);
    doc.setFont('helvetica', 'bold');
    doc.text('Early Childhood Care and Development (ECCD) ', pageWidth / 2, 40, { align: 'center' }); 
    
    // Bold the "List of Children" title
    doc.setFont('helvetica', 'normal');
    doc.text('Records', pageWidth / 2, 50, { align: 'center' });

    doc.setFont('helvetica', 'bold');
    doc.text('BHS PATAG', pageWidth / 2, 60, { align: 'center' });

    const tableStartY = 70;
    doc.autoTable({
        head: [['', 'Name', 'Birth Date', 'Address']],
        body: data.map((data, index) => [
            `${index + 1}.`, 
            `${data.last_name.charAt(0).toUpperCase() + data.last_name.slice(1)}, ${data.first_name.charAt(0).toUpperCase() + data.first_name.slice(1)}`,
            formatDate(data.birth_date),
            data.complete_address
        ]),
        startY: tableStartY, // Adjusted top margin
        didDrawPage: function (data) {
            // Add page number
            let pageCount = doc.internal.getNumberOfPages();
            doc.setFontSize(10);
            doc.setTextColor(150); // Make the font color lighter
            doc.text(`Page ${pageCount}`, doc.internal.pageSize.width / 2, doc.internal.pageSize.height - 10, { align: 'center' });
        }
    });
    doc.save('Child Care Data.pdf');
};
</script>

<template>
    <Head title=" | Child Care Data"/>
    <div class="header">
        <h1 class="child-head text-slate-500">Child Care Data</h1>
    </div>
    <transition name="fade">
        <div v-if="showFlashMessage" class="flash-modal">
            <div class="flash-content">{{ flashMessage }}</div>
        </div>
    </transition>
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
                <button @click="downloadPDF" class="download-button">
                    <i class="fas fa-download"></i>
                </button>
                <button @click="router.get(route('childcare-form'))" class="add-button">
                    <i class="fas fa-plus"></i>
                </button>    
            </div>
        </div>
        <div class="scrollable-table">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Birth Date</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="paginatedData.length === 0">
                        <td colspan="6">No data found</td>
                    </tr>
                    <tr v-for="data in paginatedData" :key="data.id">
                        <td class="td-name">{{ data.last_name.charAt(0).toUpperCase() + data.last_name.slice(1) +", " + data.first_name.charAt(0).toUpperCase() + data.first_name.slice(1) + " " + (data.suffix ? " " + data.suffix : "") }}</td>
                        <td>{{ formatDate(data.birth_date) }}</td>
                        <td>{{ data.complete_address}}</td>
                        <td>
                            <button @click="router.get(route('child.show', { id: data.id }))" class="address-button">
                                <i class="fas fa-address-card"></i>
                            </button>
                            <button @click="confirmDelete(data)" class="delete-button">
                                <i class="fas fa-trash"></i>
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
                
                <label for="last_name" style="color: #888;">Last Name:</label>
                <input type="text" v-model="childCopy.last_name" :placeholder="childCopy.last_name" id="last_name" required>
                <label for="first_name"  style="color: #888;">First Name:</label>
                <input type="text" v-model="childCopy.first_name" :placeholder="childCopy.first_name" id="first_name" required>
                <div class="form-row">
                    <div class="form-group-middleName">
                        <label for="middle_name" style="color: #888;">Middle Name:</label>
                        <input type="text" v-model="childCopy.middle_name" :placeholder="childCopy.middle_name" id="middle_name">
                    </div>
                    <div class="form-group-suffix">
                        <label for="suffix" style="color: #888;">Suffix:</label>
                        <select name="suffix" v-model="childCopy.suffix">
                            <option value=""></option>
                            <option value="Jr.">Jr.</option>
                            <option value="Sr.">Sr.</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="birth_date" style="color: #888;">Birth Date:</label>
                    <input type="date" v-model="childCopy.birth_date" :placeholder="childCopy.birth_date" id="birth_date" required>
                </div>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>
    <div v-if="showDeleteModal" class="modal">
        <div class="modal-content">
            <h2>Confirm Delete</h2>
            <hr style="margin-top: 10px; margin-bottom:10px; padding: 0;">
            <p>Are you sure you want to delete <strong style="color: #007bff;">{{ childToDelete.first_name }} {{ childToDelete.last_name }} </strong> ?</p>
            <div class="modal-buttons">
                <button @click="deleteData">Delete</button>
                <button @click="closeDeleteModal">Cancel</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.download-button{
    border-radius: 8px;
}
.delete-button:hover {
    background-color: #c82333; 
    transform: scale(1.1);
}
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
    width: 20%; 
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.data-table th:nth-child(1){
    width: 30%; 
}

.data-table th:nth-child(2) {
    width: 10%; 
}

.data-table th:nth-child(3) {
    width: 40%; 
}
.data-table th:nth-child(4){
    width: 5%; 
}

.data-table td {
    max-width: 0;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    margin-left: 5%;
    margin-top: 1%;
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
    margin-top:3px;
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
    margin-right: 7px;
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
    max-width: 400px; 
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    animation: fadeIn 0.3s ease-in-out;
    z-index: 1001;
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

.form-group-middleName, .form-group-suffix {
    flex: 0 0 82%;
    margin-right: 10px;
}

.form-group-suffix select {
    width: 20%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.form-group:last-child {
    margin-right: 0;
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
    background-color:  #ffc107;
    border: none;
    color: white;
    padding: 5px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin-top: 0;
    margin-right: 2px;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

.sort-button i {
    font-size: 16px;
}

.sort-button:hover {
    background-color: #e0a800; 
}

.delete-button {
    background-color: #dc3545; 
    border: none;
    color: white;
    padding: 3px 5px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    margin-top: 3px;
}

.delete-button:hover {
    background-color: #c82333; 
    transform: scale(1.1);
}
.modal-content button {
    margin-top: 20px;
    padding: 8px 12px;
    /* background-color: #007bff; */
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px; 
    transition: background-color 0.3s ease;
}

.modal-content button:hover {
    /* background-color: #0056b3; */
    background-color: #c82333;
}

.modal-content button:last-child {
    /* background-color: #dc3545; */
    background-color: #007bff;
    margin-left: 10px;
}

.modal-content button:last-child:hover {
    /* background-color: #c82333; */
    background-color: #0056b3;
}

.modal-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 5px;
}
</style>