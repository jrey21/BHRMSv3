<script setup>
import { ref, onMounted, computed, watchEffect } from 'vue';
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

const sortedData = computed(() => {
    let data = [...filteredData.value];
    if (sortOption.value === 'asc') {
        data.sort((a, b) => a.first_name.localeCompare(b.first_name));
    } else if (sortOption.value === 'desc') {
        data.sort((a, b) => b.first_name.localeCompare(a.first_name));
    } else if (sortOption.value === 'age') {
        data.sort((a, b) => {
            if (a.age_unit === 'months' && b.age_unit !== 'months') return -1;
            if (a.age_unit !== 'months' && b.age_unit === 'months') return 1;
            return a.age - b.age;
        });
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
    const doc = new jsPDF();
    doc.text('Comprehensive Survey Data', 14, 16);
    doc.autoTable({
        head: [['Name', 'Age', 'Sex']],
        body: surveyData.value.map(data => [
            `${data.first_name.charAt(0).toUpperCase() + data.first_name.slice(1)} ${data.last_name.charAt(0).toUpperCase() + data.last_name.slice(1)}`,
            data.age,
            data.sex.charAt(0).toUpperCase()
        ]),
    });
    doc.save('survey_data.pdf');
};
const downloadAgeGroupPDF = () => { 
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
    
    // Bold the "Age Grouping Report" and "BHS PATAG" titles
    doc.setFont('helvetica', 'normal');
    doc.text('AGE GROUPING', pageWidth / 2, 50, { align: 'center' });

    // Bold font for the "BHS PATAG" title
    doc.setFont('helvetica', 'bold');
    doc.text('BHS PATAG', pageWidth / 2, 60, { align: 'center' });

    // Add space before the table
    const tableStartY = 70;

    // Create table
    doc.autoTable({
        head: [['Age Group', 'Male', 'Female', 'Total']],
        body: [
            ...Object.entries(ageGroups.value).map(([ageRange, group]) => [
                ageRange,
                group.male,
                group.female,
                group.male + group.female
            ]),
            ['Total', totalMale.value, totalFemale.value, totalMale.value + totalFemale.value]
        ],
        styles: { fontSize: 12, halign: 'center' }, // Center align text
        headStyles: { fillColor: [0, 102, 204], textColor: [255, 255, 255] }, // Header styling
        startY: tableStartY
    });

    // Summary section below the table
    const finalY = doc.autoTable.previous.finalY + 20; 
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(12);
    doc.text(`TOTAL NUMBER OF HOUSEHOLDS: ${totalHouseholds.value}`, 14, finalY);
    doc.text(`TOTAL NUMBER OF FAMILIES: ${totalFamilies.value}`, 14, finalY + 10);
    doc.text(`TOTAL NUMBER OF POPULATION: ${totalPopulation.value}`, 14, finalY + 20);

    // Add space before the "Submitted By" and "Noted By" section
    const spaceBeforeSignatures = finalY + 60;
    
    // "Submitted By" Section
    doc.text('SUBMITTED BY:', 14, spaceBeforeSignatures);
    doc.text('_____________________________', 70, spaceBeforeSignatures); 

    // "Noted By" Section
    const spaceForNotedBy = spaceBeforeSignatures + 20;
    doc.text('NOTE BY:', 14, spaceForNotedBy);
    doc.text('_____________________________', 70, spaceForNotedBy); 


    // Save the PDF
    doc.save('Age_Grouping_Data.pdf');
};

const ageGroups = computed(() => {
    const groups = {
        '0-11 months': { male: 0, female: 0 },
        '1-4 years': { male: 0, female: 0 },
        '5-9 years': { male: 0, female: 0 },
        '10-19 years': { male: 0, female: 0 },
        '20-49 years': { male: 0, female: 0 },
        '50-64 years': { male: 0, female: 0 },
        '65 above': { male: 0, female: 0 },
    };

    surveyData.value.forEach(data => {
        let ageGroup = '';
        if (data.age_unit === 'months' && data.age <= 11) {
            ageGroup = '0-11 months';
        } else if (data.age >= 1 && data.age <= 4) {
            ageGroup = '1-4 years';
        } else if (data.age >= 5 && data.age <= 9) {
            ageGroup = '5-9 years';
        } else if (data.age >= 10 && data.age <= 19) {
            ageGroup = '10-19 years';
        } else if (data.age >= 20 && data.age <= 49) {
            ageGroup = '20-49 years';
        } else if (data.age >= 50 && data.age <= 64) {
            ageGroup = '50-64 years';
        } else if (data.age >= 65) {
            ageGroup = '65 above';
        }

        if (ageGroup) {
            if (data.sex.toLowerCase() === 'male') {
                groups[ageGroup].male += 1;
            } else if (data.sex.toLowerCase() === 'female') {
                groups[ageGroup].female += 1;
            }
        }
    });

    return groups;
});

const totalMale = computed(() => {
    return Object.values(ageGroups.value).reduce((sum, group) => sum + group.male, 0);
});

const totalFemale = computed(() => {
    return Object.values(ageGroups.value).reduce((sum, group) => sum + group.female, 0);
});

const totalHouseholds = computed(() => {
    const uniqueHouseholds = new Set(surveyData.value.map(data => data.household_number));
    return uniqueHouseholds.size;
});

const totalPopulation = computed(() => {
    return surveyData.value.length;
});

const totalFamilies = computed(() => {
    const householdFamilies = {};
    surveyData.value.forEach(data => {
        if (!householdFamilies[data.household_number]) {
            householdFamilies[data.household_number] = new Set();
        }
        householdFamilies[data.household_number].add(data.family_number);
    });
    return Object.values(householdFamilies).reduce((sum, families) => sum + families.size, 0);
});

</script>

<template>
    <Head title=" | Age Grouping"/>
    <div class="header">
        <h1 class="text-slate-500 ml-0">Age Grouping</h1>
    </div>
    <transition name="fade">
        <div v-if="showFlashMessage" class="flash-modal">
            <div class="flash-content">{{ flashMessage }}</div>
        </div>
    </transition>
    <div class="age-group-table">
        <div class="age-group-header">
            <button @click="downloadAgeGroupPDF" class="download-button">
                <i class="fas fa-download"></i>
            </button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Age Group</th>
                    <th>Male</th>
                    <th>Female</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(group, ageRange) in ageGroups" :key="ageRange">
                    <td>{{ ageRange }}</td>
                    <td>{{ group.male }}</td>
                    <td>{{ group.female }}</td>
                    <td><strong>{{ group.male + group.female }}</strong></td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ totalMale }}</strong></td>
                    <td><strong>{{ totalFemale }}</strong></td>
                    <td><strong>{{ totalMale + totalFemale }}</strong></td>
                </tr>
            </tbody>
           <div class="totals">
                <h1>TOTAL NUMBER OF HOUSEHOLD: <strong>{{ totalHouseholds }}</strong></h1>
                <h1>TOTAL NUMBER OF FAMILIES: <strong>{{ totalFamilies }}</strong></h1>
                <h1>TOTAL NUMBER OF POPULATION: <strong>{{ totalPopulation }}</strong></h1>
           </div>
        </table>
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
    position:sticky;
    top:-1px;
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
.data-table th:nth-child(2),.data-table th:nth-child(6){
    width: 30%; 
}
.data-table th:nth-child(3){
    width: 10%; 
}
.data-table th:nth-child(1),.data-table th:nth-child(4),.data-table th:nth-child(5){
    width: 7%; 
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
    right: 0;
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
    margin-left: 5%;
}

.age-group-header {
    display: flex;
    justify-content: flex-end; /* Change from space-between to flex-end */
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
</style>
