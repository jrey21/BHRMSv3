<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import Layout from "../Layouts/Dash.vue";
import RightSidebar from "./Components/RightSidebar.vue";
import { ref, onMounted, computed, watchEffect, onUnmounted } from 'vue';
import axios from 'axios';
import { Line, Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, PointElement, LinearScale, CategoryScale, ArcElement } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, LinearScale, CategoryScale, ArcElement);

defineOptions({ layout: Layout });

const isMobile = ref(false);


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

const totalCitizens = computed(() => dataCitizens.value.length);
defineExpose({
    totalCitizens
});

const dataPWD = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get(route('pwd-data'));
        dataPWD.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('pwd-data'));
        dataPWD.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

const totalPWDs = computed(() => dataPWD.value.length);

const dataFourPs = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get(route('four-ps-data'));
        dataFourPs.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('four-ps-data'));
        dataFourPs.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

const total4Ps = computed(() => dataFourPs.value.length);

const surveyData = ref([]);
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

const totalResidents = computed(() => surveyData.value.length);


const childcareData = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get(route('childcare-data'));
        childcareData.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('childcare-data'));
        childcareData.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

const totalChildcare = computed(() => childcareData.value.length);

const lineChartData = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    datasets: [
        {
            label: 'Dataset 1',
            backgroundColor: '#f87979',
            data: [40, 39, 10, 40, 39, 80, 40, 60, 55, 30, 20, 70]
        },
        {
            label: 'Dataset 2',
            backgroundColor: '#36A2EB',
            data: [20, 30, 50, 60, 70, 90, 100, 110, 120, 130, 140, 150]
        }
    ]
};

const pieChartData = {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple'],
    datasets: [
        {
            label: 'Dataset 1',
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
            data: [300, 50, 100, 200, 150]
        }
    ]
};

const pneaData = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get(route('pnea-enrollment-data'));
        pneaData.value = response.data;
    } catch (error) {
        console.error('Error fetching pnea enrollment data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('pnea-enrollment-data'));
        pneaData.value = response.data;
    } catch (error) {
        console.error('Error fetching childcare data:', error);
    }
});

const totalPregnants = computed(() => pneaData.value.length);

const dataUnderweights = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get(route('underweight'));
        dataUnderweights.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('underweight'));
        dataUnderweights.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

const totalUnderweights = computed(() => dataUnderweights.value.length);

const handleResize = () => {
    isMobile.value = window.innerWidth <= 768;
};

onMounted(() => {
    handleResize();
    window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
});

</script>

<template>
    <Head title=" | Dashboard"/>
    <div class="dashboard-container">
        <div class="main-content">
            <div class="content-wrapper">
                <div>
                    <h1 class="dashboard-head text-slate-500">Dashboard</h1>
                </div>
                <div class="medicine-search-container">
                    <div class="medicine">
                        <Link :href="route('medicine-list-view')">Medicine</Link>
                        <!-- <a href="#">Medicine</a> -->
                    </div>
                    <!-- <div class="search-bar">
                        <input type="text" placeholder="Search..." v-model="searchQuery" />
                        <button class="search-icon-button">
                            <i class="fas fa-search search-icon"></i>
                        </button>
                    </div> -->
                </div>
                <div class="dashboard-boxes">
                    <div class="total-cases">
                        <h2 class="numbers">145</h2>
                        <p class="labels">Total Cases</p>
                        <p class="view-dets">View Details</p>
                        <i class="fas fa-chart-bar" style="position: absolute; top: 25px; right: 15px; color: white; opacity:45%; font-size: 50px"></i>
                    </div>
                    <div class="breastfeeding">
                        <h2 class="numbers">145</h2>
                        <p class="labels">Number of Breastfeeding</p>
                        <p class="view-dets">View Details</p>
                        <i class="fas fa-baby" style="position: absolute; top: 25px; right: 15px; color: white; opacity:45%; font-size: 50px"></i>
                    </div>
                    <div class="pregnant">
                        <h2 class="numbers">{{totalPregnants}}</h2>
                        <p class="labels">Number of Pregnants</p>
                        <Link :href="route('pnea-enrollment-view')" class="view-dets">View Details</Link>
                        <i class="fas fa-female" style="position: absolute; top: 25px; right: 15px; color: white; opacity:45%; font-size: 50px"></i>
                    </div>
                    <div class="pantawid">
                        <h2 class="numbers">{{total4Ps}}</h2>
                        <p class="labels">Number of 4P's</p>
                        <Link :href="route('four-ps-view')" class="view-dets">View Details</Link>
                        <i class="fas fa-users" style="position: absolute; top: 25px; right: 15px; color: white; opacity:45%; font-size: 50px"></i>
                    </div>
                    <div class="pwd">
                        <h2 class="numbers">{{totalPWDs}}</h2>
                        <p class="labels">Number of PWD's</p>
                        <Link :href="route('pwd-view')" class="view-dets">View Details</Link>
                        <i class="fas fa-wheelchair" style="position: absolute; top: 25px; right: 15px; color: white; opacity:45%; font-size: 50px"></i>
                    </div>
                    <div class="senior-citizen">
                        <h2 class="numbers">{{ totalCitizens }}</h2>
                        <p class="labels">Senior Citizen</p>
                        <Link :href="route('senior-citizen-view')" class="view-dets">View Details</Link>
                        <i class="fas fa-blind" style="position: absolute; top: 25px; right: 15px; color: white; opacity:45%; font-size: 50px"></i>
                    </div>
                    <div class="residents">
                        <h2 class="numbers">{{totalResidents}}</h2>
                        <p class="labels">Number of</p>
                        <p class="label1">Residents</p>
                        <Link :href="route('comprehensive-survey-view')" class="view-dets">View Details</Link>
                        <i class="fas fa-home" style="position: absolute; top: 25px; right: 15px; color: white; opacity:45%; font-size: 50px"></i>
                    </div>
                    <div class="age-grouping">
                        <h2 class="age">Age</h2>
                        <p class="labels">Grouping</p>
                        <Link :href="route('age-grouping-view')" class="view-dets">View Details</Link>
                        <i class="fas fa-chart-line" style="position: absolute; top: 25px; right: 15px; color: white; opacity:45%; font-size: 50px"></i>
                    </div>
                    <div class="Underweights">
                        <h2 class="numbers">{{totalUnderweights}}</h2>
                        <p class="labels">Underweights</p>
                        <Link :href="route('growth-monitoring')" class="view-dets">View Details</Link>
                        <i class="fas fa-weight" style="position: absolute; top: 25px; right: 15px; color: white; opacity:45%; font-size: 50px"></i>
                    </div>
                    <div class="child-care">
                        <h2 class="numbers">{{totalChildcare}}</h2>
                        <p class="labels">Childcare</p>
                        <p class="label1">Data</p>
                        <Link :href="route('childcare-form-view')" class="view-dets">View Details</Link>
                        <i class="fas fa-child" style="position: absolute; top: 25px; right: 15px; color: white; opacity:45%; font-size: 50px"></i>
                    </div>
                </div>
                <div class="border-line"></div>
                
                <div class="additional-boxes">
                    <div class="box">
                        <Line :data="lineChartData" />
                        <p class="labels">Line Chart</p>
                    </div>
                    <div class="box">
                        <Pie :data="pieChartData" />
                        <p class="labels">Pie Chart</p>
                    </div>
                </div>
            </div>
        </div>
         <RightSidebar v-if="!isMobile" class="right-sidebar"/>
    </div>
</template>

<style scoped>
.dashboard-boxes {
    display: grid;
    grid-template-columns: repeat(5, 1fr); 
    gap: 20px;
}

.total-cases, .pregnant, .breastfeeding, .pwd, .pantawid, .senior-citizen, .Underweights,.residents,.age-grouping,.child-care{
    padding: 30px;
    border: 1px solid #ccc;
    border-radius: 8px;
    position: relative;
    cursor: pointer;
    text-align: left; 
    min-width: 90px; 
    max-width: 400px; 
    min-height: 140px; 
}
.child-care{
    background-color: rgb(161, 40, 115);
}
.total-cases {
    background-color: #D70C24ff;
}

.pregnant {
    background-color: #FFC107ff;
}
.residents {
    background-color: rgb(3, 134, 36);
}

.breastfeeding {
    background-color: #007BFFff;
}

.pwd {
    background-color: rgb(194, 177, 29);
}

.pantawid {
    background-color: #6F42C1ff;
}

.senior-citizen {
    background-color: rgb(25, 31, 197);
}

.Underweights {
    background-color: rgb(153, 75, 16);
}
.age-grouping{
    background-color: rgb(245, 115, 16);
}

.numbers, .labels, .view-dets ,.age{
    color: white;
    margin: 0; 
    position: absolute; 
}
.label1{
    color: white;
    margin: 0; 
    position: absolute; 
    top: 75px; 
    left: 20px; 
}

.numbers {
    font-size: 30px;
    font-weight: larger;
    top: 15px; 
    left: 20px; 
}
.age{
    font-size: 24px;
    font-weight: larger;
    top: 15px; 
    left: 20px; 
}

.labels {
    top: 55px; 
    left: 20px; 
}

.view-dets {
    font-size: 13px;
    padding: 5px; 
    bottom: 0; 
    left: 0; 
    background-color: rgba(99, 98, 98, 0.5); 
    width: 100%; 
    text-align: left; 
    padding-right: 30px; 
}

.view-dets:hover {
    background-color: rgba(99, 98, 98, 1); 
}

.view-dets::after {
    content: '>'; 
    font-family: Arial, sans-serif; 
    font-weight: bold;
    position: absolute;
    right: 10px; 
    top: 50%; 
    transform: translateY(-50%); 
    color: white; 
}

.border-line {
    border-top: 2px solid #476C88ff;
    margin-top: 20px;
}

.right-sidebar {
    margin-top: 50%; 
}

/* Medicine */
.medicine {
    width: 15%;
    height: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: green;
    border: 1px solid green;
    border-radius: 6px;
    cursor: pointer;
    margin-bottom: 10px;
    padding: 0 2px;
    color: white;
}

.medicine:hover {
    background-color: rgb(5, 96, 5);
    opacity:95%;
}

.medicine-search-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.search-bar {
    height: 40px;
    width: 20%;
    display: flex;
    align-items: center;
    position: relative;
}

.search-bar input {
    height: 30px;
    width: 100%;
    margin-top: -10px;
    padding: 0 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    color: #636262;
}

.search-icon-button {
    margin-top: -10px;
    position: absolute;
    right: 10px;
    background: none;
    color: none;
    border: none;
    cursor: pointer;
}

.search-icon {
    color: #ccc;
}

.additional-boxes {
    display: flex;
    justify-content: center; 
    flex-wrap: wrap; 
    gap: 20px;
    margin-top: 20px; 
}

.additional-boxes .box {
    flex: 1 1 45%; 
    padding: 30px;
    border: 1px solid #ccc;
    border-radius: 8px;
    position: relative;
    cursor: pointer;
    text-align: left;
    min-width: 200px; 
    max-width: 400px; 
    min-height: 300px;
    background-color: #6F42C1ff; 
}

.additional-boxes .numbers, .additional-boxes .labels, .additional-boxes .view-dets {
    color: white;
    margin: 0; 
    position: absolute; 
}

.additional-boxes .numbers {
    font-size: 30px;
    font-weight: larger;
    top: 15px; 
    left: 20px; 
}

.additional-boxes .labels {
    top: 10px; 
    left: 20px; 
    font-size: 18px;
    font-weight: bold;
}
.additional-boxes .view-dets {
    font-size: 13px;
    padding: 5px; 
    bottom: 0; 
    left: 0;
    background-color: rgba(99, 98, 98, 0.5); 
    width: 100%; 
    text-align: left; 
    padding-right: 30px; 
    transform: translateY(-50%); 
    color: white; 
}

.dashboard-container {
    display: flex;
}

.sidebar {
    width: 250px;
    position: fixed;
    left: 0;
    top: 5%; /* Adjusted value to reduce space */
    bottom: 0;
    background-color: #f8f9fa;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.main-content {
    /* margin-left: 270px; /* Adjust this value based on the sidebar width */
    /* padding: 20px; */
    flex: 2;
    display: flex;
    justify-content: center;
    align-items: center;
}

.content-wrapper {
    width: 100%;
    max-width: 1200px;
}

@media (max-width: 768px) {
    .dashboard-boxes {
        grid-template-columns: repeat(2, 1fr);
    }

    .additional-boxes .box {
        flex: 1 1 100%;
    }
}

@media (max-width: 480px) {
    .dashboard-boxes {
        grid-template-columns: 1fr;
    }
}
</style>
