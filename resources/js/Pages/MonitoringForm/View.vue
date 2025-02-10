<script setup>
import FormLayout from '../../Layouts/FormLayout.vue';
import { ref, onMounted, computed, watchEffect } from 'vue';
import { router } from '@inertiajs/vue3'; 
import axios from 'axios';
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';

defineOptions({
    layout: FormLayout
});

const pregnancyPeriodData = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get(route('monitoring-data'));
        console.log('API Response:', response.data); 
        pregnancyPeriodData.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('monitoring-data'));
        console.log('API Response:', response.data); 
        pregnancyPeriodData.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

const currentPage = ref(1);
const itemsPerPage = 20;

const searchQuery = ref('');

const filteredData = computed(() => {
    if (!searchQuery.value) {
        return pregnancyPeriodData.value;
    }
    return pregnancyPeriodData.value.filter(data =>
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
    return Math.ceil(pregnancyPeriodData.value.length / itemsPerPage);
});

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const getLatestPregnancy = (person) => {
    return person.pregnancy_periods.sort((a, b) => new Date(b.date) - new Date(a.date))[0];
};

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
    doc.text('Monitoring Form for Nutritional Status', pageWidth / 2, 40, { align: 'center' });

    doc.setFontSize(11); 
    doc.setFont('helvetica', 'normal');
    doc.text('of', pageWidth / 2, 48, { align: 'center' });

    doc.setFontSize(13);
    doc.setFont('helvetica', 'normal');
    doc.text('Pregnant Mothers', pageWidth / 2, 55, { align: 'center' });

    doc.setFontSize(14);
    doc.setFont('helvetica', 'bold');
    doc.text('BHS PATAG', pageWidth / 2, 65, { align: 'center' });

    const tableStartY = 60;

    autoTable(doc, {
        head: [[' ', 'Name', 'Month', 'Weight', 'Height', 'BMI', 'Nutritional Status', 'MUAC (color)', 'MUAC Status']],
        body: sortedData.value.map((data, index) => [
            `${index + 1}.`,
            data.fullName,
            data.pregnancy_periods.length ? getLatestPregnancy(data).month : '-' ,
            data.pregnancy_periods.length ? getLatestPregnancy(data).weight : '-',
            data.pregnancy_periods.length ? getLatestPregnancy(data).height : '-',
            data.pregnancy_periods.length ? getLatestPregnancy(data).bmi : '-',
            data.pregnancy_periods.length ? getLatestPregnancy(data).status : '-',
            data.pregnancy_periods.length ? getLatestPregnancy(data).muac_color : '-',
            data.pregnancy_periods.length ? getLatestPregnancy(data).muac_status : '-'
        ]),
        startY: tableStartY + 16,
        didDrawPage: function (data) {
            let pageCount = doc.internal.getNumberOfPages();
            doc.setFontSize(10);
            doc.setTextColor(150);
            doc.text(`Page ${pageCount}`, doc.internal.pageSize.width -14, doc.internal.pageSize.height - 10, { align: 'right' });
        },
        margin: { top: 20, left: 14, right: 14, bottom: 20 },
        styles: { overflow: 'linebreak', cellPadding: 3, fontSize: 10 },
        headStyles: { fillColor: [22, 160, 133] },
        alternateRowStyles: { fillColor: [240, 240, 240] },
        columnStyles: {
            0: { cellWidth: 'auto' },
            1: { cellWidth: 40 },
            2: { cellWidth: 'auto', halign: 'center' },
            3: { cellWidth: 'auto', halign: 'center'  },
            4: { cellWidth: 'auto', halign: 'center'  },
            5: { cellWidth: 'auto', halign: 'center' },
            6: { cellWidth: 'auto', halign: 'center' },
            7: { cellWidth: 'auto', halign: 'center'  },
            8: { cellWidth: 'auto', halign: 'center'  }
        }
    });
    doc.save('pregnancy_period_monitoring_data.pdf');
};

const interpretMuacStatus = (muacStatus) => {
    if (!muacStatus) return '';
    if (muacStatus === 'N') return 'Normal';
    if (muacStatus === 'MM') return 'Moderately Malnutrition';
    if (muacStatus === 'SM') return 'Severe Malnutrition';
    return '';
};

const interpretStatus = (status) => {
    if (!status) return '';
    if (status === 'UW') return 'Underweight';
    if (status === 'N') return 'Normal';
    if (status === 'OW') return 'Overweight';
    return 'Obese';
};

</script>

<template>
    <Head title=" | Pregnancy Period Monitoring"/>
    <div class="header">
        <h1 class="text-slate-500">Monitoring Form for Nutritional Status of Pregnant Mothers</h1>
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
                        <option value="" disabled>Sort By</option>
                        <option value="asc">Name (A-Z)</option>
                        <option value="desc">Name (Z-A)</option>
                    </select>
                    <button @click="downloadPDF"> <i class="fas fa-download"></i></button>
                </div>
            </div>
            <div class="scrollable-table">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Month</th>
                            <th>Weight</th>
                            <th>Height</th>
                            <th>BMI</th>
                            <th>Nutritional Status</th>
                            <th>MUAC (color)</th>
                            <th>Nutritional Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="paginatedData.length === 0">
                            <td colspan="7">No data found</td>
                        </tr>
                        <tr v-for="data in paginatedData" :key="data.id">
                            <td>{{ data.fullName }}</td>
                            <td v-if="data.pregnancy_periods.length">{{ getLatestPregnancy(data).month }}</td>
                            <td v-if="data.pregnancy_periods.length">{{ getLatestPregnancy(data).weight }}</td>
                            <td v-else>-</td>
                            <td v-if="data.pregnancy_periods.length">{{ getLatestPregnancy(data).height }}</td>
                            <td v-else>-</td>
                            <td v-if="data.pregnancy_periods.length">{{ getLatestPregnancy(data).bmi }}</td>
                            <td v-else>-</td>
                            <td v-if="data.pregnancy_periods.length">{{ interpretStatus(getLatestPregnancy(data).status) }}</td>
                            <td v-else>-</td>
                            <td v-if="data.pregnancy_periods.length">{{ getLatestPregnancy(data).muac_color }}</td>
                            <td v-else>-</td>
                            <td v-if="data.pregnancy_periods.length">{{ interpretMuacStatus(getLatestPregnancy(data).muac_status) }}</td>
                            <td v-else>-</td>
                            <td>
                                <button @click="router.get(route('pnea.show', { id: data.id }))" class="address-button">
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
    </div>
</template>

<style scoped>
.data-pwd-list{
    width: 100%;
}
.data-table th:nth-child(1){
    width: 30%; 
}

.data-table th:nth-child(2),.data-table th:nth-child(3),.data-table th:nth-child(4),.data-table th:nth-child(5) {
    width: 8%; 
}

.data-table th:nth-child(6) {
    width: 15%; 
}
.data-table th:nth-child(7){
    width: 10%; 
}
.data-table th:nth-child(8){
    width: 15%; 
}

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

</style>