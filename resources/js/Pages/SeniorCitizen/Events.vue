<script setup> 
import FormLayout from '../../Layouts/FormLayout.vue';
import { ref, onMounted, computed, watchEffect, watch } from 'vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3'; 
import 'jspdf-autotable';


defineOptions({ layout: FormLayout });

const props = defineProps({
    seniorEvent: { type: Object, required: true },
});

const eventsData = ref([]);

const updateEventsData = async () => {
    try {
        const response = await axios.get(route('events-data'));
        console.log('API Response:', response.data);
        eventsData.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

onMounted(updateEventsData);

watch(() => eventsData.value, updateEventsData, { deep: true });

watchEffect(() => {
    // This will be triggered whenever eventsData changes
    console.log('Events data updated:', eventsData.value);
});

const currentPage = ref(1);
const itemsPerPage = 20;
const searchQuery = ref('');
const sortOption = ref(''); 

const filteredEvents = computed(() => {
    if (!searchQuery.value) {
        return eventsData.value;
    }
    return eventsData.value.filter(event =>
        event.title.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const sortedEvents = computed(() => {
    let data = [...filteredEvents.value];
    if (sortOption.value === 'asc') {
        data.sort((a, b) => a.title.localeCompare(b.title));
    } else if (sortOption.value === 'desc') {
        data.sort((a, b) => b.title.localeCompare(a.title));
    } else if (sortOption.value === 'date') {
        data.sort((a, b) => new Date(a.date) - new Date(b.date));
    }
    return data;
});

const paginatedEvents = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return sortedEvents.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(eventsData.value.length / itemsPerPage);
});

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
}; 

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const showModal = ref(false);
const flashMessage = ref('');
const showFlashMessage = ref(false);

const newEvent = ref({
    title: '',
    date: ''
});

const openModal = () => {
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    newEvent.value = { title: '', date: '' };
};

const saveEvent = async () => {
    try {
        const response = await axios.post(route('events-create'), newEvent.value);
        eventsData.value.push(response.data);
        flashMessage.value = 'Event added successfully!';
        showFlashMessage.value = true;
        setTimeout(() => (showFlashMessage.value = false), 3000);
        closeModal();
    } catch (error) {
        flashMessage.value = 'Failed to add event! ' + (error.response?.data?.message || error.message);
        showFlashMessage.value = true;
        setTimeout(() => (showFlashMessage.value = false), 5000);
    }
};

</script>

<template>
    <div class="header">
        <h1 class="text-slate-500">Financial Assistance</h1>
    </div>
    <div class="data-container">
        <div class="action-bar">
            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search" style="margin-left: 8px;"></i>
                    <input type="text" v-model="searchQuery" placeholder="Search by title ..." />
                </div>
            </div>
            <div class="flex">
                <div class="button-group">
                    <select v-model="sortOption" class="sort-select">
                        <option value="">Sort By</option>
                        <option value="asc">Title (A-Z)</option>
                        <option value="desc">Title (Z-A)</option>
                        <option value="date">Date</option>
                    </select>
                </div>
                <button @click="openModal" class="add-button">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="scrollable-table">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Distribution Date</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="paginatedEvents.length === 0">
                        <td colspan="2">No data found</td>
                    </tr>
                    <tr v-for="event in paginatedEvents" :key="event.id">
                        <td>{{ event.title }}</td>
                        <td>{{ formatDate(event.date) }}</td>
                        <td>{{ event.location }}</td>
                        <td>
                            <button @click="router.get(route('events-data.show', { id: event.id }))" class="address-button">
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
    <div v-if="showModal" class="modal-overlay">
        <div class="modal-content">
            <h2 class="add-event" style="color: #488a99;">Add Financial Assistance</h2>
            <form @submit.prevent="saveEvent">
                <label for="title">Title:</label>
                <input type="text" v-model="newEvent.title" id="title" required>
                <label for="date">Distribution Date:</label>
                <input type="date" v-model="newEvent.date" id="date" required>
                <label for="location">Location: </label>
                <input type="text" v-model="newEvent.location" id="location" required>

                <div class="button-container">
                    <button type="submit">Add</button>
                    <button type="button" @click="closeModal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Flash message -->
    <transition name="fade">
        <div v-if="showFlashMessage" class="flash-modal">
            <div class="flash-content">{{ flashMessage }}</div>
        </div>
    </transition>
</template>

<style scoped>
.button-container {
    text-align: right;
    margin-bottom: 10px;
}
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
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
.scrollable-table {
    height: 480px;
    overflow-y: auto;
    margin-top: 10px;
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
    /* padding: 10px; */
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
    width: 40%; 
}
.data-table th:nth-child(2) {
    width: 17%; 
}
.data-table th:nth-child(3) {
    width: 35%; 
}

.data-table td {
    max-width: 0;
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

.action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0;
    margin-bottom: 10px;
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
}

.search-box i {
    font-size: 14px;
    color: #007bff; 
    margin-right: 8px;
}

.search-box input {
    font-size: 14px;
    border: none;
    outline: none;
    color: #333;
    height: 25px; 
}

.sort-select {
    padding: 5px;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
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
    cursor: pointer;
    border-radius: 5px; 
    transition: background-color 0.3s ease; 
}

.add-button:hover {
    background-color: #45a049; 
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
    width: 400px;
    max-width: 90%;
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
</style>

