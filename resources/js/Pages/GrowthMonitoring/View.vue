<script setup>
import FormLayout from '../../Layouts/FormLayout.vue';
import { ref, onMounted, computed, watchEffect } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';

defineOptions({
    layout: FormLayout
});

const growthMonitoring = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get(route('growth-monitoring-data'));
        console.log('API Response:', response.data); // Log the API response
        growthMonitoring.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('growth-monitoring-data'));
        console.log('API Response:', response.data); // Log the API response
        growthMonitoring.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});
const currentPage = ref(1);
const itemsPerPage = 20;

const searchQuery = ref('');

const filteredData = computed(() => {
    if (!searchQuery.value) {
        return growthMonitoring.value;
    }
    return growthMonitoring.value.filter(data =>
        data.first_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        data.last_name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const sortOption = ref(''); // New state for sorting option

const sortedData = computed(() => {
    let data = [...filteredData.value];
    data.forEach(person => {
        if (person.growth_monitorings.length > 1) {
            person.growth_monitorings.sort((a, b) => new Date(b.date) - new Date(a.date));
        }
    });
    if (sortOption.value === 'asc') {
        data.sort((a, b) => a.first_name.localeCompare(b.first_name));
    } else if (sortOption.value === 'desc') {
        data.sort((a, b) => b.first_name.localeCompare(a.first_name));
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
    return Math.ceil(growthMonitoring.value.length / itemsPerPage);
});

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const getLatestMonitoring = (person) => {
    if (person.growth_monitorings.length > 1) {
        person.growth_monitorings.sort((a, b) => new Date(b.date) - new Date(a.date));
    }
    return person.growth_monitorings[0];
};

//Computed properties for weight for age
const totalSU = computed(() => {
    return growthMonitoring.value.filter(person => {
        const latestMonitoring = getLatestMonitoring(person);
        return latestMonitoring && latestMonitoring.weight_age_status.toLowerCase() === 'severely underweight';
    }).length;
});

const totalUnderweight = computed(() => {
    return growthMonitoring.value.filter(person => {
        const latestMonitoring = getLatestMonitoring(person);
        return latestMonitoring && latestMonitoring.weight_age_status.toLowerCase() === 'underweight';
    }).length;
});

const totalNormalWeight = computed(() => {
    return growthMonitoring.value.filter(person => {
        const latestMonitoring = getLatestMonitoring(person);
        return latestMonitoring && latestMonitoring.weight_age_status.toLowerCase() === 'normal';
    }).length;
});

const totalOverweightWeight = computed(() => {
    return growthMonitoring.value.filter(person => {
        const latestMonitoring = getLatestMonitoring(person);
        return latestMonitoring && latestMonitoring.weight_age_status.toLowerCase() === 'overweight';
    }).length;
});


//Computed properties for height for age
const totalSS = computed(() => {
    return growthMonitoring.value.filter(person => {
        const latestMonitoring = getLatestMonitoring(person);
        return latestMonitoring && latestMonitoring.height_age_status.toLowerCase() === 'severely stunted';
    }).length;
});

const totalStunted = computed(() => {
    return growthMonitoring.value.filter(person => {
        const latestMonitoring = getLatestMonitoring(person);
        return latestMonitoring && latestMonitoring.height_age_status.toLowerCase() === 'stunted';
    }).length;
});

const totalNormalHeight = computed(() => {
    return growthMonitoring.value.filter(person => {
        const latestMonitoring = getLatestMonitoring(person);
        return latestMonitoring && latestMonitoring.height_age_status.toLowerCase() === 'normal';
    }).length;
});

const totalTall = computed(() => {
    return growthMonitoring.value.filter(person => {
        const latestMonitoring = getLatestMonitoring(person);
        return latestMonitoring && latestMonitoring.height_age_status.toLowerCase() === 'tall';
    }).length;
});

//Computed properties for weight for height
const totalSW = computed(() => {
    return growthMonitoring.value.filter(person => {
        const latestMonitoring = getLatestMonitoring(person);
        return latestMonitoring && latestMonitoring.weight_height_status.toLowerCase() === 'severely wasted';
    }).length;
});

const totalMW = computed(() => {
    return growthMonitoring.value.filter(person => {
        const latestMonitoring = getLatestMonitoring(person);
        return latestMonitoring && latestMonitoring.weight_height_status.toLowerCase() === 'moderately wasted';
    }).length;
});

const totalNormal = computed(() => {
    return growthMonitoring.value.filter(person => {
        const latestMonitoring = getLatestMonitoring(person);
        return latestMonitoring && latestMonitoring.weight_height_status.toLowerCase() === 'normal';
    }).length;
});

const totalOverweight = computed(() => {
    return growthMonitoring.value.filter(person => {
        const latestMonitoring = getLatestMonitoring(person);
        return latestMonitoring && latestMonitoring.weight_age_status.toLowerCase() === 'overweight';
    }).length;
});

const totalObese = computed(() => {
    return growthMonitoring.value.filter(person => {
        const latestMonitoring = getLatestMonitoring(person);
        return latestMonitoring && latestMonitoring.weight_height_status.toLowerCase() === 'obese';
    }).length;
});

const downloadPDF = () => {
    const doc = new jsPDF();
    const currentDate = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

    doc.setFontSize(12);
    const pageWidth = doc.internal.pageSize.getWidth();

    doc.setFont('helvetica', 'normal');
    doc.text('Republic of the Philippines', pageWidth / 2, 10, { align: 'center' });
    doc.text('Province of Leyte', pageWidth / 2, 16, { align: 'center' });
    doc.text('City of Baybay', pageWidth / 2, 22, { align: 'center' });

    doc.setFontSize(14);
    doc.setFont('helvetica', 'bold');
    doc.text('Growth Monitoring Data', pageWidth / 2, 40, { align: 'center' });

    doc.setFontSize(11); 
    doc.setFont('helvetica', 'normal');
    doc.text('as of', pageWidth / 2, 48, { align: 'center' });

    doc.setFontSize(11);
    doc.setFont('helvetica', 'normal');
    doc.text(`${currentDate}`, pageWidth / 2, 55, { align: 'center' });

    doc.setFontSize(14);
    doc.setFont('helvetica', 'bold');
    doc.text('BHS PATAG', pageWidth / 2, 65, { align: 'center' });

    const tableStartY = 60;

    autoTable(doc, {
        head: [['Name', 'Weight', 'Height', 'Zone', 'WFA', 'HFA', 'WFH']],
        body: sortedData.value.map(data => [
            `${data.first_name} ${data.last_name}`,
            data.growth_monitorings.length ? `${data.growth_monitorings[0].weight} kg` : '-',
            data.growth_monitorings.length ? `${data.growth_monitorings[0].height} cm` : '-',
            data.zone,
            data.growth_monitorings.length ? getAcronym(data.growth_monitorings[0].weight_age_status) : '-',
            data.growth_monitorings.length ? getAcronym(data.growth_monitorings[0].height_age_status) : '-',
            data.growth_monitorings.length ? getAcronym(data.growth_monitorings[0].weight_height_status) : '-'
        ]),
        startY: tableStartY + 16,
        margin: { top: 20, left: 14, right: 14, bottom: 20 },
        styles: { overflow: 'linebreak', cellPadding: 3, fontSize: 10 },
        headStyles: { fillColor: [22, 160, 133] },
        alternateRowStyles: { fillColor: [240, 240, 240] },
        columnStyles: {
            0: { cellWidth: 'auto' },
            1: { cellWidth: 'auto' },
            2: { cellWidth: 'auto' },
            3: { cellWidth: 'auto' },
            4: { cellWidth: 'auto' },
            5: { cellWidth: 'auto' },
            6: { cellWidth: 'auto' }
        }
    });
    doc.save('growth_monitoring_data.pdf');
};

const getAcronym = (status) => {
    switch (status.toLowerCase()) {
        case 'severely underweight':
            return 'SU';
        case 'underweight':
            return 'U';
        case 'normal':
            return 'N';
        case 'overweight':
            return 'OW';
        case 'severely stunted':
            return 'SS';
        case 'stunted':
            return 'S';
        case 'tall':
            return 'T';
        case 'severely wasted':
            return 'SW';
        case 'moderately wasted':
            return 'MW';
        case 'obese':
            return 'O';
        default:
            return status;
    }
};

</script>

<template>
     <Head title=" | Growth Monitoring"/>
     <div class="header">
        <h1 class="text-slate-500">Growth Monitoring</h1>
    </div>
    <div class="main-content">
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
                        <option value="zone">Zone</option>
                    </select>
                    <button @click="downloadPDF"> <i class="fas fa-download"></i></button>
                </div>
                
            </div>
            <div class="scrollable-table">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Weight</th>
                        <th>Height</th>
                        <th>Zone</th>
                        <th>Weight for Age</th>
                        <th>Height for Age</th>
                        <th>Weight for Height</th>
                    </tr>
                </thead>
                <tbody>
                        <tr v-if="paginatedData.length === 0">
                            <td colspan="9">No data found</td>
                        </tr>
                        <tr v-for="data in paginatedData" :key="data.id">
                            <td>{{ data.first_name }} {{ data.last_name }}</td>
                            <td v-if="data.growth_monitorings.length">{{ data.growth_monitorings[0].weight }} kg</td>
                            <td v-else>-</td>
                            <td v-if="data.growth_monitorings.length">{{ data.growth_monitorings[0].height }} cm</td>
                            <td v-else>-</td>
                            <td>{{ data.zone }}</td>
                            <td v-if="data.growth_monitorings.length">{{ data.growth_monitorings[0].weight_age_status }}</td>
                            <td v-else>-</td>
                            <td v-if="data.growth_monitorings.length">{{ data.growth_monitorings[0].height_age_status }}</td>
                            <td v-else>-</td>
                            <td v-if="data.growth_monitorings.length">{{ data.growth_monitorings[0].weight_height_status }}</td>
                            <td v-else>-</td>
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
        <div class="total-count">
            <h2 style="margin-left: 5px; margin-bottom: 10px;">Weight for Age</h2>
            <p style="margin-bottom: 10px; margin-left: 20px;">SU: {{ totalSU }}</p>
            <p style="margin-bottom: 10px; margin-left: 20px;">Underweight: {{ totalUnderweight }}</p>
            <p style="margin-bottom: 10px; margin-left: 20px;">Normal: {{ totalNormalWeight }}</p>
            <p style="margin-left: 20px; margin-bottom: 40px;">Overweight: {{ totalOverweightWeight }}</p>

            <h2 style="margin-left: 5px; margin-bottom: 10px;">Height for Age</h2>
            <p style="margin-bottom: 10px; margin-left: 20px;">SS: {{ totalSS }}</p>
            <p style="margin-bottom: 10px; margin-left: 20px;">Stunted: {{ totalStunted }}</p>
            <p style="margin-bottom: 10px; margin-left: 20px;">Normal: {{ totalNormalHeight }}</p>
            <p style="margin-left: 20px; margin-bottom: 40px;">Tall: {{ totalTall }}</p>

            <h2 style="margin-left: 5px; margin-bottom: 10px;">Weight for Height</h2>
            <p style="margin-bottom: 10px; margin-left: 20px;">SW: {{ totalSW }}</p>
            <p style="margin-bottom: 10px; margin-left: 20px;">MW: {{ totalMW }}</p>
            <p style="margin-bottom: 10px; margin-left: 20px;">Normal: {{ totalNormal }}</p>
            <p style="margin-left: 20px; margin-bottom: 10px;">Overweight: {{ totalOverweight }}</p>
            <p style="margin-left: 20px; margin-bottom: 20px;">Obese: {{ totalObese }}</p>
        </div>
    </div>
</template>

<style scoped>
.total-count{
    font-size: 14px;
}
.total-count h2{
    color: #065c71;
}
.total-count p{
    color: #392f2f;
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
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
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

.main-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    width: 105%;
}
</style>
