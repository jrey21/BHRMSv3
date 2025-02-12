<script setup>
import { ref, onMounted, computed, watchEffect } from 'vue';
import { router } from '@inertiajs/vue3'; 
import axios from 'axios';
import FormLayout from '../../Layouts/FormLayout.vue';
import Distribution from './Distribution.vue';
import { format } from 'date-fns';
import jsPDF from 'jspdf';
import 'jspdf-autotable';

defineOptions({ layout: FormLayout });

const medicineListData = ref([]);
const searchQuery = ref(''); 

const filteredData = computed(() => {
    if (!searchQuery.value) {
        return medicineListData.value;
    }
    return medicineListData.value.filter(data =>
        data.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
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
        const response = await axios.get(route('medicine-list-data'));
        medicineListData.value = response.data;
    } catch (error) {
        console.error('Error fetching  data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('medicine-list-data'));
        medicineListData.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

const showModal = ref(false);
const selectedMedicineList = ref(null);
const isLoading = ref(false);
const originalMedicineList = ref(null);

const editData = async (medicineList) => {
    isLoading.value = true;
    try {
        const response = await axios.get(route('medicine-list-edit', { id: medicineList.id }));
        originalMedicineList.value = { ...response.data }; // Save original data
        selectedMedicineList.value = response.data;
        showModal.value = true;
    } catch (error) {
        console.error('Error fetching medicineList data:', error);
    } finally {
        isLoading.value = false;
    }
};

const closeModal = () => {
    showModal.value = false;
    selectedMedicineList.value = null;
    originalMedicineList.value = null; 
};

const flashMessage = ref('');
const showFlashMessage = ref(false);

const saveChanges = async () => {
    try {
        const response = await axios.put(route('medicine-list-update', { id: selectedMedicineList.value.id }), selectedMedicineList.value);
        const index = medicineListData.value.findIndex(medicineList => medicineList.id === selectedMedicineList.value.id);
        if (index !== -1) {
            medicineListData.value[index] = response.data;
        } else {
            console.error('medicineList not found in local state');
        }

        flashMessage.value = 'Changes saved successfully!';
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 500); 
        closeModal();
    } catch (error) {
        console.error('Error updating medicineList data:', error);
        flashMessage.value = `Error saving changes: ${JSON.stringify(error.response.data)}`;
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 900); 
    }
};


const showDeleteModal = ref(false);
const medicineToDelete = ref(null);

const confirmDelete = (medicine) => {
    medicineToDelete.value = medicine;
    showDeleteModal.value = true;
};

const deleteData = async () => {
    try {
        await axios.delete(route('medicine-list-delete', { id: medicineToDelete.value.id }));
        medicineListData.value = medicineListData.value.filter(item => item.id !== medicineToDelete.value.id);
        flashMessage.value = 'Medicine deleted successfully!';
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 900);
        closeDeleteModal();
    } catch (error) {
        console.error('Error deleting medicine:', error);
        flashMessage.value = `Error deleting medicine: ${JSON.stringify(error.response.data)}`;
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 5000);
    }
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    medicineToDelete.value = null;
};

const showAddModal = ref(false);
const newmedicineList = ref({ name: '', type: '', quantity: '' });

const openAddModal = () => {
    newmedicineList.value = { name: '' };
    showAddModal.value = true;
};

const closeAddModal = () => {
    showAddModal.value = false;
};

const addmedicineList = async () => {
    // Check if the medicineList already exists
    const existingMedicine = medicineListData.value.find(medicineList => 
        medicineList.name.toLowerCase() === newmedicineList.value.name.toLowerCase() &&
        medicineList.type === newmedicineList.value.type &&
        medicineList.measurement === newmedicineList.value.measurement &&
        medicineList.expiry_date === newmedicineList.value.expiry_date
    );

    if (existingMedicine) {
        try {
            const response = await axios.put(route('medicine-list-update', { id: existingMedicine.id }), {
                ...existingMedicine,
                quantity: existingMedicine.quantity + parseInt(newmedicineList.value.quantity)
            });
            const index = medicineListData.value.findIndex(medicineList => medicineList.id === existingMedicine.id);
            if (index !== -1) {
                medicineListData.value[index] = response.data;
            }
            flashMessage.value = 'Medicine quantity updated successfully!';
            showFlashMessage.value = true;
            setTimeout(() => {
                showFlashMessage.value = false;
            }, 900);
            closeAddModal();
        } catch (error) {
            console.error('Error updating medicineList data:', error);
            flashMessage.value = `Error updating medicineList: ${JSON.stringify(error.response.data)}`;
            showFlashMessage.value = true;
            setTimeout(() => {
                showFlashMessage.value = false;
            }, 900);
        }
    } else {
        try {
            const response = await axios.post(route('medicine-list-form'), newmedicineList.value);
            medicineListData.value.push(response.data);
            flashMessage.value = 'Medicine added successfully!';
            showFlashMessage.value = true;
            setTimeout(() => {
                showFlashMessage.value = false;
            }, 900);
            closeAddModal();
        } catch (error) {
            console.error('Error adding medicineList data:', error);
            flashMessage.value = `Error adding medicineList: ${JSON.stringify(error.response.data)}`;
            showFlashMessage.value = true;
            setTimeout(() => {
                showFlashMessage.value = false;
            }, 900);
        }
    }
};

const showDistributeModal = ref(false);
const distributeForm = ref({ beneficiaryName: '', distributedQuantity: '' });
const selectedMedicineForDistribution = ref(null);

const openDistributeModal = (medicineList) => {
    selectedMedicineForDistribution.value = medicineList;
    distributeForm.value = { beneficiaryName: '', distributedQuantity: '' };
    showDistributeModal.value = true;
};

const closeDistributeModal = () => {
    showDistributeModal.value = false;
    selectedMedicineForDistribution.value = null;
};

const distributeMedicine = async () => {
    if (!distributeForm.value.beneficiaryName) {
        flashMessage.value = 'Beneficiary name is required!';
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 900);
        return;
    }

    if (!distributeForm.value.distributedQuantity || isNaN(distributeForm.value.distributedQuantity) || distributeForm.value.distributedQuantity <= 0) {
        flashMessage.value = 'Invalid quantity!';
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 900);
        return;
    }

    try {
        const response = await axios.put(route('medicine-list-distribute', { id: selectedMedicineForDistribution.value.id }), { 
            distributed_quantity: distributeForm.value.distributedQuantity, 
            beneficiary_name: distributeForm.value.beneficiaryName 
        });
        const index = medicineListData.value.findIndex(item => item.id === selectedMedicineForDistribution.value.id);
        if (index !== -1) {
            medicineListData.value[index].quantity -= response.data.distributedQuantity;
        } else {
            console.error('Medicine not found in local state');
        }
        flashMessage.value = 'Medicine distributed successfully!';
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 1000);
        closeDistributeModal();
    } catch (error) {
        console.error('Error distributing medicine:', error);
        flashMessage.value = `Not enough medicine!`;
        showFlashMessage.value = true;
        setTimeout(() => {
            showFlashMessage.value = false;
        }, 1000);
    }
};

const flashMessageClass = computed(() => {
    if (flashMessage.value.includes('Not enough medicine!')) {
        return 'flash-modal error';
    }
    return flashMessage.value.includes('Error') ? 'flash-modal error' : 'flash-modal success';
});

const formatDate = (dateString) => {
    return format(new Date(dateString), 'MMMM dd, yyyy');
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

    // Add more space before the "Medicine List" title
    doc.setFontSize(14);
    doc.setFont('helvetica', 'bold');
    doc.text('List of Medicines', pageWidth / 2, 40, { align: 'center' });
    
    // Bold font for the "BHS PATAG" title
    doc.setFont('helvetica', 'bold');
    doc.text('BHS PATAG', pageWidth / 2, 50, { align: 'center' });
    
    // Adjusted top margin for the table
    const tableStartY = 60;
    
    doc.autoTable({
        head: [['', 'Medicine Name', 'Type', 'Available', 'Expiry Date']],
        body: data.map((data, index) => [
            `${index + 1}.`, 
            data.name + " " + "( " + data.measurement +" )",
            data.type,
            data.quantity,
            formatDate(data.expiry_date)
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
    doc.save('Medicine-list.pdf');
};
</script>

<template>

    <Head title=" | Medicine List" />
    <transition name="fade">
        <div v-if="showFlashMessage" :class="flashMessageClass">
            <div class="flash-content">{{ flashMessage }}</div>
        </div>
    </transition>
    <div class="header">
        <h1 class="medicine-head text-slate-500">Medicine List</h1>
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
                <!-- <button @click="router.get(route('beneficiaries-form'))" class="add-button">
                    <i class="fas fa-plus"></i>
                </button> -->
                <button class="download-button" @click="downloadPDF">
                    <i class="fas fa-download"></i>
                </button>
                <button @click="openAddModal" class="add-button">
                    <i class="fas fa-plus"></i> Medicine
                </button>
            </div>
        </div>
        <div class="scrollable-table">
            <table class="data-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Medicine Name</th>
                        <th>Type</th>
                        <th>Available</th>
                        <th>Expiry Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="paginatedData.length === 0">
                        <td colspan="6">No medicine available</td>
                    </tr>
                    <tr v-for="data in paginatedData" :key="data.id">
                        <td>{{ medicineListData.indexOf(data) + 1 }}</td> 
                        <td>{{ data.name + " " + "( " + data.measurement +" )"}}</td>
                        <td>{{ data.type }}</td>
                        <td>{{ data.quantity }}</td>
                        <td>{{ formatDate(data.expiry_date) }}</td>
                        <td>
                            <button @click="editData(data)" class="edit-button">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button v-if="$page.props.auth.user.position === 'admin'" @click="confirmDelete(data)" class="delete-button">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button @click="openDistributeModal(data)" class="distribute-button">
                                <i class="fas fa-share"></i>
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
            <h2>Update Medicine Information</h2>
            <div style="padding-bottom: 8px;"></div>
            <hr> <!-- Added line to create distance -->
            <form @submit.prevent="saveChanges" v-if="!isLoading">
                <div class="form-row-1">
                    <div class="form-group medium-text">
                        <label for="name" style="color: #888;">Name:</label>
                        <input type="text" v-model="selectedMedicineList.name" id="name" :placeholder="originalMedicineList?.name" required>
                    </div>
                    <div class="form-group measurement">
                        <label for="stock-in" style="color: #888;">Measurement</label>
                        <input type="text" v-model="selectedMedicineList.measurement" id="measurement" :placeholder="originalMedicineList?.measurement" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="type" style="color: #888;">Type:</label>
                        <select v-model="selectedMedicineList.type" id="type" required>
                            <option value=""></option>
                            <option value="Liquid">Liquid</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Capsules">Capsules</option>
                            <option value="Drops">Drops</option>
                            <option value="Inhalers">Inhalers</option>
                            <option value="Injections">Injections</option>
                            <option value="Patches">Patches</option>
                        </select>
                        <p style="color:#888; font-size: 14px; font-style: italic;">{{ originalMedicineList?.type }}</p>
                    </div>
                    <div class="form-group quantity">
                        <label for="quantity" style="color: #888;">Quantity:</label>
                        <input type="int" v-model="selectedMedicineList.quantity" id="quantity" :placeholder="originalMedicineList?.quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="expiry-date" style="color: #888;">Expiry Date:</label>
                        <input type="date" v-model="selectedMedicineList.expiry_date" id="expiry-date" :placeholder="originalMedicineList?.expiry_date" required>
                    </div>  
                </div>
                <button type="submit">Save Changes</button>
            </form>
            <div v-else>Loading...</div>
        </div>
    </div>
    <div v-if="showAddModal" class="modal">
        <div class="modal-content">
            <span class="close" @click="closeAddModal">&times;</span>
            <h2 style="margin: 5px;">Add New Medicine</h2>
            <hr>
            <form @submit.prevent="addmedicineList">
                <div class="form-row-1">
                    <div class="form-group medium-text">
                        <label for="new-name" style="color: #888;"> Medicine Name:</label>
                        <input type="text" v-model="newmedicineList.name" id="new-name" required>
                    </div>
                    <div class="form-group measurement">
                        <label for="new-measurement" style="color: #888;">Measurement:</label>
                        <input type="text" v-model="newmedicineList.measurement" id="new-measurement" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="new-type" style="color: #888;">Type:</label>
                        <select v-model="newmedicineList.type" id="new-type" required>
                            <option value=""></option>
                            <option value="Liquid">Liquid</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Capsules">Capsules</option>
                            <option value="Drops">Drops</option>
                            <option value="Inhalers">Inhalers</option>
                            <option value="Injections">Injections</option>
                            <option value="Patches">Patches</option>
                        </select>
                    </div>
                    <div class="form-group quantity-1">
                        <label for="new-quantity" style="color: #888;">Quantity:</label>
                        <input type="text" v-model="newmedicineList.quantity" id="new-quantity" required>
                    </div>
                    <div class="form-group expiry-2">
                        <label for="new-expiry-date" style="color: #888;">Expiry Date:</label>
                        <input type="date" v-model="newmedicineList.expiry_date" id="new-expiry-date" required>
                    </div>
                </div>
                <button type="submit">Save</button>
            </form>
        </div>
    </div>
    <div v-if="showDistributeModal" class="modal">
        <div class="modal-content">
            <span class="close" @click="closeDistributeModal">&times;</span>
            <h2>Distribute Medicine</h2>
            <hr style="margin-bottom: 2px; margin-top: 10px">
            <form @submit.prevent="distributeMedicine">
                <div class="form-group-bn">
                    <label for="beneficiary-name" style="color: #888;">Beneficiary Name:</label>
                    <input type="text" v-model="distributeForm.beneficiaryName" id="beneficiary-name" required>
                </div>
                <div class="form-group-qty">
                    <label for="distributed-quantity" style="color: #888;">Quantity:</label>
                    <input type="number" v-model="distributeForm.distributedQuantity" id="distributed-quantity" required>
                </div>
                <button type="submit">Distribute</button>
            </form>
        </div>
    </div>
    <div v-if="showDeleteModal" class="modal">
        <div class="modal-content-btn">
            <h2>Confirm Delete</h2>
            <hr style="margin-top: 10px; margin-bottom:10px; padding: 0;">
            <p>Are you sure you want to delete <strong style="color: #007bff;">{{ medicineToDelete.name }} </strong> ?</p>
            <div class="modal-buttons">
                <button @click="deleteData" class="delete-btn">Delete</button>
                <button @click="closeDeleteModal" class="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>
    <Distribution />
</template>

<style scoped>
.download-button{
    border-radius: 8px; 
}
.delete-btn{
    background-color: #dc3545;
    border: none;
    color: white;
    padding: 3px 8px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}
.delete-btn :hover{
    background-color: #c82333;
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
.form-group{
    flex: 1;
    margin-right: 20px;
}
.form-group-bn{
    flex: 1;
}
.form-group-qty{
    width: 50%;
}
#distributed-quantity{
    width: 30%;
}
.form-row{
    display: flex;
    justify-content: space-between;
}
.form-row-1{
    display: flex;
    justify-content: space-between;
}
.medium-text{
    flex: 0 0 395px;
}
.measurement{
    flex: 0 0 140px;
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
    margin-left: 10%;
    padding: 20px;
    margin-top: 0;
    margin-bottom: 10%;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.data-container-2 {
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
    height:450px;
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
.data-table th:nth-child(1){
    width: 5%; 
}
.data-table th:nth-child(2){
    width: 35%; 
}

.data-table th:nth-child(3){
    width: 15%; 
}
.data-table th:nth-child(4){
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
    margin-left: 10%;
}
.quantity-1{
    flex:0 0 220px;
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

/* .medicine-head {
    font-size: 20px;
    margin-top: 15px;
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
.modal-content-btn {
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

.modal-content-btn button {
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

.modal-content-btn button:hover {
    background-color: #c82333;
}

.modal-content-btn button:last-child {
    /* background-color: #dc3545; */
    background-color: #007bff;
    margin-left: 10px;
}

.modal-content-btn button:last-child:hover {
    background-color: #0056b3;
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
    top: 5%;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 20px;
}

.flash-modal.success .flash-content {
    background-color: #d4edda; 
    color: #155724; 
    border: 1px solid #c3e6cb; 
    font-size: 16px;
}

.flash-modal.error .flash-content {
    background-color: #f8d7da; 
    color: #721c24; 
    border: 1px solid #f5c6cb; 
    font-size: 16px;
}

.flash-content {
    padding: 20px;
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

.distribute-button {
    background-color: #17a2b8;
    border: none;
    color: white;
    padding: 3px 5px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    margin-left: 10px;
}

.distribute-button:hover {
    background-color: #138496;
    transform: scale(1.1);
}
.modal-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 5px;
}
</style>
