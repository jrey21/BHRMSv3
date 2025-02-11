<script setup>
import Layout from "../Layouts/FormLayout.vue";
import RightSidebar from "./Components/RightSidebar.vue";
import { ref, onMounted, computed, watchEffect, onUnmounted } from 'vue';
import axios from 'axios';
import { Line, Pie, Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, BarElement, PointElement, LinearScale, CategoryScale, ArcElement } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, LineElement, BarElement, PointElement, LinearScale, CategoryScale, ArcElement);

defineOptions({ layout: Layout });

const isMobile = ref(false);

const lactatingMothers = ref([]);

onMounted(async () => {
    try {
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('lactating-data'));
        lactatingMothers.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

const totalLactating = computed(() => lactatingMothers.value.length);

const childVaccinated = ref([]);

onMounted(async () => {
    try {
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('vaccination-record-data'));
        childVaccinated.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

const totalVaccinated = computed(() => childVaccinated.value.length);

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

const calculateAge = (birthdate) => {
    const today = new Date();
    const birthDate = new Date(birthdate);
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDifference = today.getMonth() - birthDate.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
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
        const age = calculateAge(data.birth_date);
        let ageGroup = '';
        if (age <= 0) {
            ageGroup = '0-11 months';
        } else if (age >= 1 && age <= 4) {
            ageGroup = '1-4 years';
        } else if (age >= 5 && age <= 9) {
            ageGroup = '5-9 years';
        } else if (age >= 10 && age <= 19) {
            ageGroup = '10-19 years';
        } else if (age >= 20 && age <= 49) {
            ageGroup = '20-49 years';
        } else if (age >= 50 && age <= 64) {
            ageGroup = '50-64 years';
        } else if (age >= 65) {
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

const lineChartData = computed(() => ({
    labels: Object.keys(totalZoneCounts.value),
    datasets: [
        {
            label: 'Number of Records',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgba(75, 192, 192, 1)',
            tension: 0.4, 
            fill: true,
            data: Object.values(totalZoneCounts.value)
        }
    ]
}));

const lineChartOptions = {
    responsive: true,
    plugins: {
        legend: {
            display: true,
            position: 'top',
            labels: {
                color: '#333',
                font: {
                    size: 14,
                    weight: 'bold'
                }
            }
        },
        tooltip: {
            enabled: true,
            backgroundColor: 'rgba(0, 0, 0, 0.7)',
            titleFont: {
                size: 16,
                weight: 'bold'
            },
            bodyFont: {
                size: 14
            },
            footerFont: {
                size: 12,
                style: 'italic'
            }
        }
    },
    scales: {
        x: {
            grid: {
                display: false
            },
            ticks: {
                color: '#333',
                font: {
                    size: 12
                }
            }
        },
        y: {
            grid: {
                color: 'rgba(200, 200, 200, 0.2)'
            },
            ticks: {
                color: '#333',
                font: {
                    size: 12
                }
            }
        }
    }
};

const pieChartData = computed(() => ({
    labels: ['Total Child Vaccinated','Lactating Mothers', 'Pregnants', '4P\'s', 'PWD\'s', 'Senior Citizens', 'Residents', 'Underweights', 'Childcare'],
    datasets: [
        {
            label: 'Legend',
            backgroundColor: ['#D70C24ff','#007BFF', '#FFC107', '#6F42C1', '#C2B11D', '#191FC5', '#038624', '#994B10', '#A12873'],
            hoverBackgroundColor: ['#D70C24ff','#0056b3', '#e0a800', '#5a2d91', '#a89b1a', '#1418a5', '#02691b', '#7a3a0d', '#7d2056'],
            borderWidth: 1,
            data: [
                totalVaccinated.value,
                totalLactating.value,
                totalPregnants.value,
                total4Ps.value,
                totalPWDs.value,
                totalCitizens.value,
                totalResidents.value,
                totalUnderweights.value,
                totalChildcare.value
            ]
        }
    ]
}));

const pieChartOptions = {
    responsive: true,
    plugins: {
        legend: {
            display: true,
            position: 'bottom', 
            align: 'start',
            labels: {
                color: '#333',
                font: {
                    size: 10, 
                    weight: 'bold'
                }
            },
            padding:{
                top: 20,
                bottom: 0
            }
        },
        tooltip: {
            enabled: true,
            backgroundColor: 'rgba(0, 0, 0, 0.7)',
            titleFont: {
                size: 16,
                weight: 'bold'
            },
            bodyFont: {
                size: 14
            },
            footerFont: {
                size: 12,
                style: 'italic'
            },
            callbacks: {
                label: function(tooltipItem) {
                    const dataset = tooltipItem.dataset;
                    const total = dataset.data.reduce((sum, value) => sum + value, 0);
                    const currentValue = dataset.data[tooltipItem.dataIndex];
                    const percentage = ((currentValue / total) * 100).toFixed(2);
                    return `${tooltipItem.label}: ${currentValue} (${percentage}%)`;
                }
            }
        },
        datalabels: {
            display: true,
            color: 'white',
            formatter: (value, context) => {
                const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                const percentage = ((value / total) * 100).toFixed(2);
                return `${percentage}%`;
            }
        }
    },
    layout: {
        padding: {
            top: 20,
            bottom: 0 
        }
    }
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

const pneaZoneData = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get(route('pnea-zone-data'));
    pneaZoneData.value = response.data;
    } catch (error) {
        console.error('Error fetching zone data:', error);
    }
});

const totalPneaZones = computed(() => {
    const pneaZoneCounts = {};
    pneaZoneData.value.forEach(item => {
        if (pneaZoneCounts[item.zone]) {
            pneaZoneCounts[item.zone]++;
        } else {
            pneaZoneCounts[item.zone] = 1;
        }
    });
    // Add default count of 0 for zones without records
    const allZones = ['Zone 1', 'Zone 2', 'Zone 3', 'Zone 4', 'Zone 5','Zone 6','Zone 7'];
    allZones.forEach(zone => {
        if (!pneaZoneCounts[zone]) {
            pneaZoneCounts[zone] = 0;
        }
    });
    return Object.keys(pneaZoneCounts).sort().reduce((obj, key) => {
        obj[key] = pneaZoneCounts[key];
        return obj;
    }, {});
});

const childZoneData = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get(route('childcare-zone-data'));
        childZoneData.value = response.data;
    } catch (error) {
        console.error('Error fetching zone data:', error);
    }
});

const totalChildZones = computed(() => {
    const zoneCounts = {};
    childZoneData.value.forEach(item => {
        if (zoneCounts[item.zone]) {
            zoneCounts[item.zone]++;
        } else {
            zoneCounts[item.zone] = 1;
        }
    });
    // Add default count of 0 for zones without records
    const allZones = ['Zone 1', 'Zone 2', 'Zone 3', 'Zone 4', 'Zone 5','Zone 6','Zone 7']; 
    allZones.forEach(zone => {
        if (!zoneCounts[zone]) {
            zoneCounts[zone] = 0;
        }
    });
    return Object.keys(zoneCounts).sort().reduce((obj, key) => {
        obj[key] = zoneCounts[key];
        return obj;
    }, {});
});

const surveyZoneData = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get(route('comprehensive-survey-zone-data'));
        surveyZoneData.value = response.data;
    } catch (error) {
        console.error('Error fetching zone data:', error);
    }
});

const totalSurveyZones = computed(() => {
    const zoneCounts = {};
    surveyZoneData.value.forEach(item => {
        if (zoneCounts[item.zone]) {
            zoneCounts[item.zone]++;
        } else {
            zoneCounts[item.zone] = 1;
        }
    });
    // Add default count of 0 for zones without records
    const allZones = ['Zone 1', 'Zone 2', 'Zone 3', 'Zone 4', 'Zone 5','Zone 6','Zone 7']; 
    allZones.forEach(zone => {
        if (!zoneCounts[zone]) {
            zoneCounts[zone] = 0;
        }
    });
    return Object.keys(zoneCounts).sort().reduce((obj, key) => {
        obj[key] = zoneCounts[key];
        return obj;
    }, {});
});

const totalZoneCounts = computed(() => {
    const combinedZoneCounts = {};

    const addCounts = (zoneData) => {
        zoneData.forEach(item => {
            if (combinedZoneCounts[item.zone]) {
                combinedZoneCounts[item.zone]++;
            } else {
                combinedZoneCounts[item.zone] = 1;
            }
        });
    };

    addCounts(pneaZoneData.value);
    addCounts(childZoneData.value);
    addCounts(surveyZoneData.value);

    return Object.keys(combinedZoneCounts).sort().reduce((obj, key) => {
        obj[key] = combinedZoneCounts[key];
        return obj;
    }, {});
});

const growthMonitoring = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get(route('growth-monitoring-data'));
        console.log('API Response:', response.data); 
        growthMonitoring.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

watchEffect(async () => {
    try {
        const response = await axios.get(route('growth-monitoring-data'));
        console.log('API Response:', response.data);
        growthMonitoring.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});


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

const nutritionalStatusData = computed(() => [
    { category: 'Weight for Age', status: 'Severely Underweight', total: totalSU.value },
    { category: 'Weight for Age', status: 'Underweight', total: totalUnderweight.value },
    { category: 'Weight for Age', status: 'Normal', total: totalNormalWeight.value },
    { category: 'Weight for Age', status: 'Overweight', total: totalOverweightWeight.value },
    { category: 'Height for Age', status: 'Severely Stunted', total: totalSS.value },
    { category: 'Height for Age', status: 'Stunted', total: totalStunted.value },
    { category: 'Height for Age', status: 'Normal', total: totalNormalHeight.value },
    { category: 'Height for Age', status: 'Tall', total: totalTall.value },
    { category: 'Weight for Height', status: 'Severely Wasted', total: totalSW.value },
    { category: 'Weight for Height', status: 'Moderately Wasted', total: totalMW.value },
    { category: 'Weight for Height', status: 'Normal', total: totalNormal.value },
    { category: 'Weight for Height', status: 'Overweight', total: totalOverweight.value },
    { category: 'Weight for Height', status: 'Obese', total: totalObese.value }
]);

const getCurrentYear = () => {
    return new Date().getFullYear();
};

const getHighestCountZone = (zoneCounts) => {
    let highestCount = 0;
    let highestZone = '';
    for (const [zone, count] of Object.entries(zoneCounts)) {
        if (count > highestCount) {
            highestCount = count;
            highestZone = zone;
        }
    }
    return highestZone;
};

console.log("Final Age Groups Data:", ageGroups.value);
const barChartData = computed(() => ({
    labels: [
        '0-11 months',
        '1-4 years',
        '5-9 years',
        '10-19 years',
        '20-49 years',
        '50-64 years',
        '65 above'
    ],
    datasets: [
        {
            label: 'Male',
            backgroundColor: '#007BFF',
            data: [
            ageGroups.value?.['0-11 months']?.male || 0,
                ageGroups.value?.['1-4 years']?.male || 0,
                ageGroups.value?.['5-9 years']?.male || 0,
                ageGroups.value?.['10-19 years']?.male || 0,
                ageGroups.value?.['20-49 years']?.male || 0,
                ageGroups.value?.['50-64 years']?.male || 0,
                ageGroups.value?.['65 above']?.male || 0
            ]
        },
        {
            label: 'Female',
            backgroundColor: '#FFC107',
            data: [
            ageGroups.value?.['0-11 months']?.female || 0,
                ageGroups.value?.['1-4 years']?.female || 0,
                ageGroups.value?.['5-9 years']?.female || 0,
                ageGroups.value?.['10-19 years']?.female || 0,
                ageGroups.value?.['20-49 years']?.female || 0,
                ageGroups.value?.['50-64 years']?.female || 0,
                ageGroups.value?.['65 above']?.female || 0
            ]
        }
    ]
}));

const barChartOptions = {
    responsive: true,
    maintainAspectRatio: false, 
    indexAxis: 'y', 
    layout: {
        padding: {
            top: 5,
        }
    },
    plugins: {
        legend: {
            display: true, 
            position: 'top',
            labels: {
                color: '#333',
                font: {
                    size: 14,
                    weight: 'bold'
                },
                margin: 20 
            }
        },
        tooltip: {
            enabled: true,
            backgroundColor: 'rgba(0, 0, 0, 0.7)',
            titleFont: {
                size: 18,
                weight: 'bold'
            },
            bodyFont: {
                size: 16
            },
            footerFont: {
                size: 16,
                style: 'italic'
            }
        },
    },
    scales: {
        x: {
            beginAtZero: true,
            grid: {
                display: true
            },
            ticks: {
                autoSkip: false,
                color: '#333',
                font: {
                    size: 12
                }
            }  
        },
        y: {
            beginAtZero: true,
            grid: {
                color: 'rgba(200, 200, 200, 0.2)'
            },
            ticks: {
                autoSkip: false,
                color: '#333',
                font: {
                    size: 14,
                    padding: 10
                }
            },
            categoryPercentage: 0.8, 
            barPercentage: 0.9 
        }
    },
};

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
                        <h2 class="numbers">{{ totalVaccinated }}</h2>
                        <p class="labels">Total Child Vaccinated</p>
                        <Link :href="route('vaccination-record')" class="view-dets">View Details</Link>
                        <i class="fas fa-syringe" style="position: absolute; top: 25px; right: 15px; color: white; opacity:45%; font-size: 50px"></i>
                    </div>
                    <div class="breastfeeding">
                        <h2 class="numbers">{{ totalLactating }}</h2>
                        <p class="labels">Number of Lactating Mothers</p>
                        <Link :href="route('lactating-form')" class="view-dets">View Details</Link>
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
                    <p class="overview">Records Overview</p>
                    <div class="box" >
                        
                            <Pie :data="pieChartData" :options="pieChartOptions" />
                       
                        <div style="margin-left: 80px;"></div>

                        <Line style="background-color: white; padding:5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" :data="lineChartData" :options="lineChartOptions" />
                    </div>
                </div>
                <div class="flex gap-5"> 
                    <div class="zone-counts">
                        <h2 class="zone-title">Population Distribution by Zone ({{ getCurrentYear(date) }})</h2>
                        <div class="zone-data-container">
                            <div>
                                <h1>PNEA Records</h1>
                                <ul>
                                    <li v-for="(count, zone) in totalPneaZones" :key="zone" :style="{ color: zone === getHighestCountZone(totalPneaZones) ? 'red' : 'inherit' }">
                                        {{ zone }} : <strong style="padding: 10px;">{{ count }}</strong>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h1>ECCD Records</h1>
                                <ul>
                                    <li v-for="(count, zone) in totalChildZones" :key="zone" :style="{ color: zone === getHighestCountZone(totalChildZones) ? 'red' : 'inherit' }">
                                        {{ zone }} : <strong style="padding: 10px;">{{ count }}</strong>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h1>Residents</h1>
                                <ul>
                                    <li v-for="(count, zone) in totalSurveyZones" :key="zone" :style="{ color: zone === getHighestCountZone(totalSurveyZones) ? 'red' : 'inherit' }">
                                        {{ zone }} : <strong style="padding: 10px;">{{ count }}</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="zone-counts-age">
                        <h2 class="zone-title">Population by Age Group ({{ getCurrentYear(date) }})</h2>
                        <div class="chart-container">
                            <Bar :data="barChartData" :options="barChartOptions" />
                        </div>
                    </div>
                </div>
                <div class="flex gap-5">
                    <!-- <div class="zone-counts-vac">
                        <h2 class="zone-title">Number of Vaccinated</h2>
                        <div class="chart-container">
                            <Bar :data="barChartData" :options="barChartOptions" />
                        </div>
                    </div> -->
                    <div class="zone-counts">  
                        <h2 class="zone-title">Nutritional Status</h2>
                        <div class="nutritional-status-container-horizontal">
                            <div class="status-card">
                                <h3>Weight for Age</h3>
                                <div class="status-row">
                                    <div class="status-column">
                                        <p class="status">Severely Underweight</p>
                                        <p class="total">{{ totalSU }}</p>
                                    </div>
                                    <div class="status-column">
                                        <p class="status">Underweight</p>
                                        <p class="total">{{ totalUnderweight }}</p>
                                    </div>
                                    <div class="status-column">
                                        <p class="status">Normal</p>
                                        <p class="total">{{ totalNormalWeight }}</p>
                                    </div>
                                    <div class="status-column">
                                        <p class="status">Overweight</p>
                                        <p class="total">{{ totalOverweightWeight }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="status-card">
                                <h3>Height for Age</h3>
                                <div class="status-row">
                                    <div class="status-column">
                                        <p class="status">Severely Stunted</p>
                                        <p class="total">{{ totalSS }}</p>
                                    </div>
                                    <div class="status-column">
                                        <p class="status">Stunted</p>
                                        <p class="total">{{ totalStunted }}</p>
                                    </div>
                                    <div class="status-column">
                                        <p class="status">Normal</p>
                                        <p class="total">{{ totalNormalHeight }}</p>
                                    </div>
                                    <div class="status-column">
                                        <p class="status">Tall</p>
                                        <p class="total">{{ totalTall }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="status-card">
                                <h3>Weight for Height</h3>
                                <div class="status-row">
                                    <div class="status-column">
                                        <p class="status">Severely Wasted</p>
                                        <p class="total">{{ totalSW }}</p>
                                    </div>
                                    <div class="status-column">
                                        <p class="status">Moderately Wasted</p>
                                        <p class="total">{{ totalMW }}</p>
                                    </div>
                                    <div class="status-column">
                                        <p class="status">Normal</p>
                                        <p class="total">{{ totalNormal }}</p>
                                    </div>
                                    <div class="status-column">
                                        <p class="status">Overweight</p>
                                        <p class="total">{{ totalOverweight }}</p>
                                    </div>
                                    <div class="status-column">
                                        <p class="status">Obese</p>
                                        <p class="total">{{ totalObese }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <RightSidebar v-if="!isMobile" class="right-sidebar"/>
    </div>
</template>

<style scoped>
.chart-container{
    width:100%;
    height:280px;
    background-color: white; 
    padding:5px; 
    margin-bottom:10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.overview {
    margin-top: 10px;  
    left: 10;
    font-size: 20px;
    font-weight: bold;
    color: #5713e9;
    position: absolute; 
   
}
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
    border: 1px solid #ccc;
    border-radius: 8px;
    /* background-color: #f2edf9;  */
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    /* background-color: red; */

}

.additional-boxes .box {
    flex: 1 1 45%; 
    padding: 30px;
    position: relative;
    cursor: pointer;
    text-align: left;
    min-width: 200px;
    max-width: 480px; 
    min-height: 400px; 
    display: flex;
    justify-content: center;
    align-items: center;
}

.additional-boxes .numbers, .additional-boxes .labels, .additional-boxes .view-dets {
    color: rgb(87, 19, 233);
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
    color: #5713e9;
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
    top: 5%; 
    bottom: 0;
    background-color: #f8f9fa;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.main-content {
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

.zone-counts {
    margin-top: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width:100%;
}
.zone-counts-age{
    margin-top: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.zone-counts-vac{
    margin-top: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.zone-title {
    font-size: 19.5px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

.zone-data-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-around;
}

.zone-data-container > div {
    flex: 1 1 30%;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.zone-data-container h1 {
    font-size: 17px;
    font-weight: bold;
    color: #5713e9;
    margin-bottom: 10px;
}

.zone-counts ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.zone-counts li {
    font-size: 16px;
    color: #555;
    margin-bottom: 5px;
    padding: 5px 0;
    border-bottom: 1px solid #eee;
}

.zone-counts li:last-child {
    border-bottom: none;
}

.age-group-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: -10px;
}

.age-group-table th, .age-group-table td {
    border-right: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

.age-group-table th {
    /* background-color: #f2f2f2; */
    color: #5713e9;
    font-weight: bold;
}

.nutritional-status-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.nutritional-status-table th, .nutritional-status-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

.nutritional-status-table th {
    background-color: #f2f2f2;
    color: #5713e9;
    font-weight: bold;
}

.nutritional-status-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-around;
}

.status-card {
    flex: 1 1 20%;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.status-card h3 {
    font-size: 17px;
    font-weight: bold;
    color: #5713e9;
    margin-bottom: 10px;
}

.status-card .status {
    font-size: 14px;
    color: #555;
    margin-bottom: 5px;
}

.status-card .total {
    font-size: 20px;
    font-weight: bold;
    color: #333;
}

.nutritional-status-container-horizontal {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
}

.status-row {
    margin-top: 15px;
    display: flex;
    justify-content: space-between;
}

.status-column {
    flex: 1;
    text-align: center;
}
</style>
