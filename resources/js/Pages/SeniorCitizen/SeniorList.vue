<script setup>
import { ref, onMounted, computed, defineExpose } from 'vue';
import axios from 'axios';

const seniorCitizens = ref([]);
const searchQuery = ref('');
const sortOption = ref('');
const claimedQrCodes = ref([]); // Add this line

const filteredData = computed(() => {
    if (!searchQuery.value) {
        return seniorCitizens.value;
    }
    return seniorCitizens.value.filter(data =>
        data.first_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        data.last_name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});
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
        data.sort((a, b) => a.age - b.age);
    } else if (sortOption.value === 'zone') {
        data.sort((a, b) => a.zone.localeCompare(b.zone));
    }
    return data.map(item => ({
        ...item,
        age_display: calculateAge(item.birth_date),
        status: claimedQrCodes.value.includes(item.first_name + ' ' + item.last_name) ? 'claimed' : '-' // Add this line
    }));
});

onMounted(async () => {
    try {
        const response = await axios.get(route('senior-citizen-data'));
        seniorCitizens.value = response.data;
    } catch (error) {
        console.error('Error fetching senior citizens:', error);
    }
});

// Expose the function to be used outside of the script setup
defineExpose({
    updateClaimedQrCodes(codes) {
        claimedQrCodes.value = codes;
    }
});
</script>

<template>
<div class="data-container">
    <div class="action-bar">
        <!-- Search and Sort -->
        <div class="search-container">
            <div class="search-box">
                <i class="fas fa-search" style="margin-left: 8px;"></i>
                <input type="text" v-model="searchQuery" placeholder="Search by name ..." />
            </div>
        </div>
        <div class="button-group">
            <select v-model="sortOption" class="sort-select">
                <option value="">Sort By</option>
                <option value="asc">Name (A-Z)</option>
                <option value="desc">Name (Z-A)</option>
                <option value="age">Age</option>
                <option value="zone">Zone</option>
            </select>
        </div>
    </div>

    <!-- Senior Citizen List Table -->
    <div class="scrollable-table">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>Zone</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="sortedData.length === 0">
                    <td colspan="5">No senior citizens data found</td>
                </tr>
                <tr v-for="senior in sortedData" :key="senior.id">
                    <td>{{ senior.first_name.charAt(0).toUpperCase() + senior.first_name.slice(1) + " " + senior.last_name.charAt(0).toUpperCase() + senior.last_name.slice(1) }}</td>
                    <td>{{ senior.age_display }}</td>
                    <td>{{ senior.sex.charAt(0).toUpperCase() }}</td>
                    <td>{{ senior.zone }}</td>
                    <td>{{ senior.status }}</td> 
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<style scoped>
.action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0;
    margin-bottom: 10px;
}
.data-container {
    width: 100%;
    padding: 20px;
    margin-top: 20px;
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

.data-table th, .data-table td {
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.data-table img {
    width: 50px; 
    height: 50px;
    display: block;
    margin: 0 auto; 
}

.data-table th:nth-child(1) {
    width: 30%;
}

.data-table th:nth-child(2) {
    width: 12%;
}

.data-table th:nth-child(3) {
    width: 12%;
}

.data-table th:nth-child(4) {
    width: 12%;
}

.data-table th:nth-child(5) {
    width: 15%;
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

.button-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0;
    margin-bottom: 10px;
}

.sort-select {
    padding: 5px;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}
</style>