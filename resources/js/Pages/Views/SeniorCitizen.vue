<script setup>
import { ref, onMounted, computed, watchEffect } from 'vue';
import axios from 'axios';
import QRCode from 'qrcode';
import FormLayout from '../../Layouts/FormLayout.vue';
import FinancialAssistance from '../SeniorCitizen/Events.vue';
import jsPDF from 'jspdf';
import 'jspdf-autotable';
import { useRouter } from 'vue-router';

defineOptions({
    layout: FormLayout
});

const showQR = ref(null);

const toggleQR = (id) => {
    showQR.value = showQR.value === id ? null : id;
};

const dataCitizens = ref([]);

onMounted(async () => {
    try {
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('senior-citizen-data'));
        dataCitizens.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});
const currentPage = ref(1);
const itemsPerPage = 20;

const searchQuery = ref('');

const filteredData = computed(() => {
    if (!searchQuery.value) {
        return dataCitizens.value;
    }
    return dataCitizens.value.filter(data =>
        data.first_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        data.last_name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

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
        data.sort((a, b) => a.age - b.age);
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
    return Math.ceil(dataCitizens.value.length / itemsPerPage);
});

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const generateQRCode = async (text) => {
    try {
        return await QRCode.toDataURL(text);
    } catch (error) {
        console.error('Error generating QR code:', error);
        return '';
    }
};

const paginatedDataWithQR = ref([]);

watchEffect(async () => {
    const dataWithQR = [];
    for (const data of paginatedData.value) {
        const qrCode = await generateQRCode(`Name: ${data.last_name}, ${data.first_name} ` + '\n' + `Age: ${data.age}` + '\n' + `Sex: ${data.sex}` + '\n' + `${data.zone}`);
        dataWithQR.push({ ...data, qrCode });
    }
    paginatedDataWithQR.value = dataWithQR;
});

const totalCitizens = computed(() => dataCitizens.value.length);

const downloadPDF = async () => {
    let data = [...sortedData.value];

    const doc = new jsPDF();
    doc.setFontSize(12);
    const pageWidth = doc.internal.pageSize.getWidth();

    doc.setFont('helvetica', 'normal');
    doc.text('Republic of the Philippines', pageWidth / 2, 10, { align: 'center' });
    doc.text('Province of Leyte', pageWidth / 2, 16, { align: 'center' });
    doc.text('City of Baybay', pageWidth / 2, 22, { align: 'center' });

    doc.setFontSize(14);
    doc.setFont('helvetica', 'bold');
    doc.text('Comprehensive Survey', pageWidth / 2, 40, { align: 'center' });

    doc.setFont('helvetica', 'normal');
    doc.text('Senior Citizen List', pageWidth / 2, 50, { align: 'center' });

    doc.setFont('helvetica', 'bold');
    doc.text('BHS PATAG', pageWidth / 2, 60, { align: 'center' });

    const tableStartY = 70;

    const dataWithoutQR = data.map((data, index) => [
        `${index + 1}.`,
        `${data.last_name.charAt(0).toUpperCase() + data.last_name.slice(1)}, ${data.first_name.charAt(0).toUpperCase() + data.first_name.slice(1)}`,
        `${data.age_display}`,
        data.sex.charAt(0).toUpperCase(),
        data.zone
    ]);

    doc.autoTable({
        head: [['', 'Name', 'Age', 'Sex', 'Zone']],
        body: dataWithoutQR,
        startY: tableStartY,
        didDrawPage: function (data) {
            let pageCount = doc.internal.getNumberOfPages();
            doc.setFontSize(10);
            doc.setTextColor(150);
            doc.text(`Page ${pageCount}`, doc.internal.pageSize.width / 2, doc.internal.pageSize.height - 10, { align: 'center' });
        }
    });
    doc.save('Senior-Citizen-List.pdf');
};

const downloadQRCode = async (data) => {
    const qrCode = await generateQRCode(`${data.id}`);
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const img = new Image();
    img.src = qrCode;
    img.onload = () => {
        const qrCodeSize = 300;
        canvas.width = qrCodeSize;
        canvas.height = qrCodeSize + 70; 
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 50, qrCodeSize, qrCodeSize);
        ctx.fillStyle = 'black';
        ctx.font = '20px Arial'; 
        ctx.textAlign = 'center';
        ctx.fillText(`${data.first_name} ${data.last_name}`, canvas.width / 2, 20);
        ctx.fillText(`${data.zone}`, canvas.width / 2, 50);
        ctx.fillStyle = 'rgba(0, 0, 0, 0.5)'; 
        ctx.font = '16px Arial'; 
        ctx.fillText('© BHRMS 2024', canvas.width / 2, canvas.height - 18);
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png', 1.0); 
        link.download = `${data.first_name}_${data.last_name}_QRCode.png`;
        link.click();
    };
};

const downloadAllQRCodesPDF = async () => {
    const doc = new jsPDF({
        orientation: 'portrait',
        unit: 'mm',
        format: 'legal'
    });
    doc.setFontSize(12);
    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();
    const qrCodeSize = 50; 
    const margin = 10;
    const qrCodesPerRow = 3;
    const qrCodesPerColumn = 4;
    const qrCodesPerPage = qrCodesPerRow * qrCodesPerColumn;

    let xPosition = margin;
    let yPosition = margin;

    for (let i = 0; i < sortedData.value.length; i++) {
        const data = sortedData.value[i];
        const qrCode = await generateQRCode(`${data.id}`);
        const img = new Image();
        img.src = qrCode;

        await new Promise((resolve) => {
            img.onload = () => {
                if (i % qrCodesPerPage === 0 && i !== 0) {
                    doc.addPage();
                    xPosition = margin;
                    yPosition = margin;
                } else if (i % qrCodesPerRow === 0 && i !== 0) {
                    xPosition = margin;
                    yPosition += qrCodeSize + margin * 3;
                }

                doc.setFontSize(12);
                doc.setTextColor(0);
                doc.text(`${data.first_name} ${data.last_name}`, xPosition + qrCodeSize / 2, yPosition, { align: 'center' });
                doc.text(`${data.zone}`, xPosition + qrCodeSize / 2, yPosition + 5, { align: 'center' });
                doc.addImage(img, 'PNG', xPosition, yPosition + 8, qrCodeSize, qrCodeSize);
                doc.setFontSize(10);
                doc.setTextColor(150);
                doc.text('© BHRMS 2024', xPosition + qrCodeSize / 2, yPosition + 5 + qrCodeSize + 10, { align: 'center' });

                // Add border box around QR code and name
                doc.setDrawColor(0);
                doc.setLineWidth(0.5);
                doc.rect(xPosition - 2, yPosition - 4, qrCodeSize + 4, qrCodeSize + 30);

                xPosition += qrCodeSize + margin;
                resolve();
            };
        });
    }

    doc.save('All-Senior-Citizen-QRCodes.pdf');
};

defineExpose({
    totalCitizens,
    downloadAllQRCodesPDF
});

</script>

<template>
     <Head title=" | Senior Citizen"/>
     <div class="header">
        <h1 class="text-slate-500">Senior Citizen List</h1>
    </div>
    <div class="data-container">
        <div class="action-bar">
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
                <button @click="downloadPDF" class="download-button">
                    <i class="fas fa-download"></i>
                </button>
                <button @click="downloadAllQRCodesPDF" class="download-button">
                    <i class="fas fa-qrcode"></i>
                </button>
            </div>
        </div>
        <div class="scrollable-table">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>Zone</th>
                    <th>QR Code</th>
                </tr>
            </thead>
            <tbody>
                    <tr v-if="paginatedDataWithQR.length === 0">
                        <td colspan="5">No senior citizens data found</td>
                    </tr>
                    <tr v-for="data in paginatedDataWithQR" :key="data.id">
                        <td>{{ data.last_name.charAt(0).toUpperCase() + data.last_name.slice(1) + ", " + data.first_name.charAt(0).toUpperCase() + data.first_name.slice(1) }}</td>
                        <td>{{ data.age_display }}</td>
                        <td>{{ data.sex.charAt(0).toUpperCase() }}</td>
                        <td>{{ data.zone }}</td>
                        <td @click="toggleQR(data.id)" style="cursor: pointer; color: #007bff; font-size: 12px;">
                            {{ showQR === data.id ? 'Hide' : 'View' }}
                            <div v-if="showQR === data.id">
                                <img :src="data.qrCode" alt="QR Code" />
                                <button @click="downloadQRCode(data)" style="font-size: 10px; color: maroon;">Download</button>
                            </div>
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
    <FinancialAssistance/>
</template>

<style scoped>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    margin-left: 5%;
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

.data-table img {
    width: 50px; 
    height: 50px;
    display: block;
    margin: 0 auto; 
}

.data-table th:nth-child(1){
    width: 30%; 
}

.data-table th:nth-child(2){
    width: 12%; 
}

.data-table th:nth-child(3){
    width: 12%; 
}

.data-table th:nth-child(4){
    width: 12%; 
}
.data-table th:nth-child(5){
    width: 15%; 
}

/* .data-table td {
    max-width: 0;
} */

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

.data-citizen-list h2 {
    color: #488a99;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.data-citizen-list table {
    width: 100%;
    border-collapse: collapse;
}

.data-citizen-list th, .data-citizen-list td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
    font-size: 14px;
}

.data-citizen-list th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.data-citizen-list img {
    width: 20px; 
    height: 20px; 
    display: block;
    margin: 0 auto; 
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
    margin-left: 10px; 
    cursor: pointer; 
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

.download-button {
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

.download-button:nth-of-type(1) {
    background-color: #007bff; 
}

.download-button:nth-of-type(2) {
    background-color: #28a745;
}

.download-button:nth-of-type(2):hover {
    background-color: #218838; 
}

</style>