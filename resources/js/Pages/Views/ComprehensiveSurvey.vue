<script setup>
import { ref, onMounted, computed, watchEffect } from 'vue';
import { router } from '@inertiajs/vue3'; 
import axios from 'axios';
import FormLayout from '../../Layouts/FormLayout.vue';
import jsPDF from 'jspdf';
import 'jspdf-autotable';

defineOptions({ layout: FormLayout });

const surveyData = ref([]);
const searchQuery = ref(''); 
const filteredData = computed(() => {
    if (!searchQuery.value) {
        return surveyData.value;
    }
    return surveyData.value.filter(data =>
        data.first_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        data.last_name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const currentPage = ref(1);
const itemsPerPage = 20;

const sortOption = ref(''); 

const calculateAge = (birthDate) => {
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDifference = today.getMonth() - birth.getMonth();

    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birth.getDate())) {
        age--;
    }

    if (age === 0) {
        const months = monthDifference + 12 * (today.getFullYear() - birth.getFullYear());
        return `${months} ${months === 1 ? 'month' : 'months'}`;
    }

    return `${age} ${age === 1 ? 'year' : 'years'}`;
};

const sortedData = computed(() => {
    let data = [...filteredData.value];
    if (sortOption.value === 'asc') {
        data.sort((a, b) => a.last_name.localeCompare(b.last_name));
    } else if (sortOption.value === 'desc') {
        data.sort((a, b) => b.last_name.localeCompare(a.last_name));
    } else if (sortOption.value === 'age') {
        data.sort((a, b) => {
            if (a.age_unit === 'months' && b.age_unit !== 'months') return -1;
            if (a.age_unit !== 'months' && b.age_unit === 'months') return 1;
            return a.age - b.age;
        });
    } else if (sortOption.value === 'zone') {
        data.sort((a, b) => a.zone.localeCompare(b.zone));
    }
    return data.map(item => ({
        ...item,
        age_display: calculateAge(item.birth_date)
    }));
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

onMounted(async () => {
    try {
        const response = await axios.get(route('comprehensive-survey-data'));
        surveyData.value = response.data;
    } catch (error) {
        console.error('Error fetching survey data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('comprehensive-survey-data'));
        surveyData.value = response.data;
    } catch (error) {
        console.error('Error fetching survey data:', error);
    }
});

const showModal = ref(false);
const selectedSurvey = ref(null);

const editData = (survey) => {
    selectedSurvey.value = survey;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedSurvey.value = null;
};

const flashMessage = ref('');
const showFlashMessage = ref(false);

const saveChanges = async () => {
    try {
        const response = await axios.put(route('survey-form-update', { id: selectedSurvey.value.id }), selectedSurvey.value);
        const index = surveyData.value.findIndex(survey => survey.id === selectedSurvey.value.id);
        if (index !== -1) {
            surveyData.value[index] = response.data;
        }
        flashMessage.value = 'Changes saved successfully!';
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 900); 
        closeModal();
    } catch (error) {
        console.error('Error updating survey data:', error);
        flashMessage.value = 'Error saving changes.';
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 900); 
    }
};

const downloadPDF = () => {
    let data = [...sortedData.value]; // Use sortedData to ensure the data is sorted according to the selected option

    const doc = new jsPDF();

    // Set font size and alignment
    doc.setFontSize(12);
    const pageWidth = doc.internal.pageSize.getWidth();
    
    // Header section (Regular font for other titles)
    doc.setFont('helvetica', 'normal');
    doc.text('Republic of the Philippines', pageWidth / 2, 10, { align: 'center' });
    doc.text('Province of Leyte', pageWidth / 2, 16, { align: 'center' });
    doc.text('City of Baybay', pageWidth / 2, 22, { align: 'center' });

    // Add more space before the "Comprehensive Survey" title
    doc.setFontSize(14);
    doc.setFont('helvetica', 'bold');
    doc.text('Comprehensive Survey', pageWidth / 2, 40, { align: 'center' }); // Added more space here
    
    // Bold the "List of Residents" and "BHS PATAG" titles
    doc.setFont('helvetica', 'normal');
    doc.text('LIST OF RESIDENTS', pageWidth / 2, 50, { align: 'center' });

    // Bold font for the "BHS PATAG" title
    doc.setFont('helvetica', 'bold');
    doc.text('BHS PATAG', pageWidth / 2, 60, { align: 'center' });

    // Adjusted top margin for the table
    const tableStartY = 70;
    
    doc.autoTable({
        head: [['', 'HH No.', 'Name', 'Age', 'Sex', 'Zone', 'Occupation']],
        body: data.map((data, index) => [
            `${index + 1}.`, 
            data.household_number,
            `${data.last_name.charAt(0).toUpperCase() + data.last_name.slice(1)}, ${data.first_name.charAt(0).toUpperCase() + data.first_name.slice(1)}`,
            `${data.age} ${data.age_unit === 'months' ? (data.age === 1 ? 'month' : 'months') : ''}`,
            data.sex.charAt(0).toUpperCase(),
            data.zone,
            data.occupation.charAt(0).toUpperCase() + data.occupation.slice(1)
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
    doc.save('List of Residents.pdf');
};

const showDeleteModal = ref(false);
const surveyToDelete = ref(null);

const confirmDelete = (survey) => {
    surveyToDelete.value = survey;
    showDeleteModal.value = true;
};

const deleteSurvey = async () => {
    try {
        await axios.delete(route('survey-delete', { id: surveyToDelete.value.id }));
        surveyData.value = surveyData.value.filter(item => item.id !== surveyToDelete.value.id);
        flashMessage.value = 'Survey deleted successfully!';
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 900);
        closeDeleteModal();
    } catch (error) {
        console.error('Error deleting survey:', error);
        flashMessage.value = `Error deleting survey: ${JSON.stringify(error.response.data)}`;
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 5000);
    }
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    surveyToDelete.value = null;
};

</script>

<template>
    <Head title=" | Total Residents"/>
    <div class="header">
        <h1 class="text-slate-500 ml-0">List of Residents</h1>
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
                <select v-model="sortOption" class="sort-select">
                    <option value="">Sort By</option>
                    <option value="asc">Name (A-Z)</option>
                    <option value="desc">Name (Z-A)</option>
                    <option value="age">Age</option>
                    <option value="zone">Zone</option>
                </select>
                <button @click="downloadPDF" class="download-button">
                    <i class="fas fa-download"></i>
                </button>
                <button @click="router.get(route('comprehensive-survey'))" class="add-button">
                    <i class="fas fa-plus"></i>
                </button>
                
            </div>
        </div>
        <div class="scrollable-table">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>HH No.</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Zone</th>
                        <th>Occupation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="paginatedData.length === 0">
                        <td colspan="7">No data found</td>
                    </tr>
                    <tr v-for="data in paginatedData" :key="data.id">
                        <td>{{ data.household_number }}</td>
                        <td class="td-name">{{data.last_name.charAt(0).toUpperCase() + data.last_name.slice(1) + ", " + data.first_name.charAt(0).toUpperCase() + data.first_name.slice(1)}}</td>
                        <td>{{ data.age_display }}</td>
                        <td>{{ data.sex.charAt(0).toUpperCase() }}</td>
                        <td>{{ data.zone }}</td>
                        <td>{{ data.occupation.charAt(0).toUpperCase() + data.occupation.slice(1) }}</td>
                        <td>
                            <!-- <button @click="editData(data)" class="edit-button">
                                <i class="fas fa-edit"></i>
                            </button> -->
                            <button @click="router.get(route('comprehensive-survey-data.show', { id: data.id }))" class="view-button">
                                <i class="fas fa-address-card"></i>
                            </button>
                            <button v-if="$page.props.auth.user.position === 'admin'" @click="confirmDelete(data)" class="delete-button">
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
            <h2>Update Information Details</h2>
            <div style="padding-bottom: 8px;"></div>
            <hr> 
            <form @submit.prevent="saveChanges">
                <label for="title" style="color: #888;">Title:</label>
                <input type="text" v-model="selectedSurvey.title" id="title" required>
                <label for="description" style="color: #888;">Description:</label>
                <input type="text" v-model="selectedSurvey.description" id="description" required>
                <div>
                    <label for="created_at" style="color: #888;">Date Created:</label>
                    <input type="date" v-model="selectedSurvey.created_at" id="created_at" required>
                </div>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>
    <div v-if="showDeleteModal" class="modal">
        <div class="modal-content">
            <h2>Confirm Delete</h2>
            <hr style="margin-top: 10px; margin-bottom:10px; padding: 0;">
            <p>Are you sure you want to delete <strong style="color: #007bff;">{{ surveyToDelete.first_name }} {{ surveyToDelete.last_name }} </strong> ?</p>
            <div class="modal-buttons">
                <button @click="deleteSurvey">Delete</button>
                <button @click="closeDeleteModal">Cancel</button>
            </div>
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
.totals{
    margin-top: 30px;
    padding: 10px;
    font-size: 16px;
    color: #488a99;
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
    width: 100%;
    padding: 20px;
    margin-top: 0;
    margin-bottom: 5%;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-left: 5%;
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
    height: 50px;
    position: sticky;
    top: -1px;
}

.data-table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
    color:#464545;
}
.data-table tr{
    scroll-snap-align: start;
}

.data-table td.td-title {
    color:#464545;
    text-align: left;
}

.data-table th, .data-table td {
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.data-table th:nth-child(2){
    width: 30%; 
}
.data-table th:nth-child(3){
    width: 10%; 
}
.data-table th:nth-child(1),.data-table th:nth-child(4),.data-table th:nth-child(5){
    width: 9%; 
}
.data-table th:nth-child(7){
    width: 10%; 
}

.data-table td {
    max-width: 0;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
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

.survey-head {
    font-size: 20px;
    margin-top: 15px;
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

.sort-select {
    padding: 5px;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.age-group-table {
    margin-top: 20px;
    margin-bottom: 40px; 
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.age-group-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.age-group-table h2 {
    color: #488a99;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.age-group-table table {
    width: 100%;
    border-collapse: collapse;
}

.age-group-table th, .age-group-table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
    font-size: 14px;
}

.age-group-table th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

.delete-button {
    background-color: #dc3545;
    border: none;
    color: white;
    padding: 3px 6px;
    margin-left: 5px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.delete-button:hover {
    background-color: #c82333;
    transform: scale(1.1);
}

.modal-content button {
    margin-top: 20px;
    padding: 8px 12px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px; 
    transition: background-color 0.3s ease;
}

.modal-content button:hover {
    background-color: #0056b3;
}

.modal-content button:last-child {
    background-color: #dc3545;
    margin-left: 10px;
}

.modal-content button:last-child:hover {
    background-color: #c82333;
}

.modal-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 5px;
}
</style>
