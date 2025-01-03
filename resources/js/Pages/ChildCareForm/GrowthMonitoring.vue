<script setup>
import { defineProps, ref, computed, watch, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    child: { type: Object, required: true },
});

// Utility function to format the date
const formatDate = (dateString) => {
    if (!dateString) return ' ';
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

// BMI calculation (weight in kg, height in cm)
const calculateChildBMI = (weight, height) => {
    if (!weight || !height) return '';
    const heightInMeters = height / 100; // Convert height from cm to meters
    return (weight / (heightInMeters * heightInMeters)).toFixed(2);
};

// BMI Classification based on WHO standards
const classifyBMI = (bmi) => {
    if (bmi < 18.5) return 'Underweight';
    if (bmi >= 18.5 && bmi < 24.9) return 'Normal weight';
    if (bmi >= 25 && bmi < 29.9) return 'Overweight';
    return 'Obesity';
};


// Function to calculate Weight-for-Age Z-Score (WAZ)
const calculateWeightForAgeZScore = (age, sex, weight) => {
    // Placeholder for actual WAZ calculation using WHO data
    // Replace this with the real WAZ calculation using WHO charts
    const zScore = getWeightZScoreFromWHOCharts(age, sex, weight);
    return zScore.toFixed(2);
};

// Placeholder function to get Weight Z-Score from WHO charts
const getWeightZScoreFromWHOCharts = (age, sex, weight) => {
    const weightForAgeTableBoys = {
        0: [0.4, 2.6, 4.7, 11.0, 25.7, 48.1, 72.8, 90.6, 95.1, 96.7, 99.1],
        1: [0.8, 3.8, 5.9, 9.5, 27.4, 47.3, 71.6, 87.7, 94.4, 97.4, 99.0],
        2: [1.4, 3.3, 7.7, 12.7, 29.9, 51.9, 75.4, 90.7, 96.4, 98.6, 99.5],
        3: [1.4, 2.6, 4.5, 10.3, 25.8, 50.5, 73.9, 89.0, 95.5, 97.7, 99.3],
        4: [1.2, 1.7, 4.5, 9.5, 24.5, 48.5, 73.9, 91.4, 95.2, 97.9, 99.0],
        5: [1.7, 2.8, 5.0, 9.5, 23.9, 49.6, 74.9, 89.8, 94.8, 97.4, 98.8],
        6: [1.2, 2.4, 5.0, 10.3, 23.2, 48.9, 74.2, 90.7, 95.7, 97.4, 98.8],
        7: [1.2, 2.2, 4.4, 9.8, 24.3, 52.5, 75.2, 90.7, 95.1, 97.5, 99.0],
        8: [0.5, 2.4, 4.1, 10.2, 23.4, 50.7, 74.1, 89.5, 95.1, 97.3, 99.0],
        9: [0.7, 1.5, 4.9, 10.5, 26.0, 51.6, 75.4, 90.3, 96.1, 98.3, 99.3],
        10: [1.0, 3.4, 6.2, 11.1, 22.7, 51.2, 74.9, 88.9, 95.1, 96.8, 98.3],
        11: [1.0, 3.6, 5.5, 10.2, 23.8, 48.6, 74.3, 90.5, 94.8, 96.4, 98.3],
        12: [1.0, 3.3, 5.9, 11.7, 24.7, 53.3, 75.8, 90.6, 95.2, 96.7, 99.5],
        13: [0.2, 2.6, 5.7, 10.8, 25.1, 50.0, 73.4, 88.8, 95.5, 96.9, 99.5],
        14: [1.0, 3.1, 4.1, 9.8, 25.8, 51.2, 75.6, 90.4, 95.5, 96.9, 99.0],
        15: [0.5, 1.8, 3.8, 9.0, 24.7, 50.7, 74.9, 91.4, 95.0, 96.4, 98.9],
        16: [0.8, 3.2, 4.9, 11.0, 25.5, 51.5, 75.5, 89.4, 94.5, 96.6, 99.2],
        17: [0.9, 3.3, 5.1, 10.3, 27.2, 50.7, 73.9, 90.9, 94.4, 97.1, 99.3],
        18: [1.0, 3.7, 5.1, 10.8, 27.1, 50.3, 75.6, 91.6, 96.5, 97.6, 99.7]
    };

    const weightForAgeTableGirls = {
        0: [0.6, 2.3, 3.7, 8.0, 24.5, 50.8, 77.4, 91.6, 94.6, 96.5, 98.7],
        1: [1.5, 5.6, 8.3, 12.1, 25.0, 48.0, 71.7, 88.9, 94.9, 96.0, 99.0],
        2: [1.6, 5.8, 7.2, 11.2, 25.3, 51.8, 76.9, 91.9, 95.1, 96.2, 99.1],
        3: [0.9, 2.7, 4.4, 9.6, 22.4, 48.9, 75.6, 91.1, 94.9, 96.7, 99.6],
        4: [1.1, 2.5, 4.5, 8.3, 23.2, 47.7, 75.9, 90.3, 94.8, 96.8, 98.6],
        5: [0.7, 2.7, 5.2, 10.1, 23.4, 50.6, 74.8, 91.0, 94.2, 96.9, 99.1],
        6: [0.9, 2.7, 5.2, 9.9, 25.0, 50.2, 74.3, 90.5, 95.3, 96.8, 98.9],
        7: [0.7, 3.8, 5.9, 10.4, 24.5, 49.8, 75.7, 89.9, 94.4, 96.4, 99.5],
        8: [0.9, 3.2, 5.4, 10.2, 23.1, 47.6, 73.7, 90.2, 94.8, 97.1, 98.9],
        9: [0.9, 2.9, 5.0, 10.0, 24.9, 49.7, 74.8, 89.6, 95.7, 97.7, 99.3],
        10: [0.9, 3.5, 4.9, 10.9, 23.8, 47.7, 75.5, 90.5, 95.8, 97.5, 99.1],
        11: [0.7, 2.8, 5.3, 10.6, 25.7, 49.0, 74.9, 91.5, 94.5, 96.8, 99.3],
        12: [0.7, 2.7, 5.0, 9.8, 25.3, 47.4, 74.9, 90.4, 93.8, 95.7, 99.1],
        13: [0.9, 2.7, 4.5, 9.0, 25.9, 49.8, 76.8, 91.2, 95.7, 97.1, 99.1],
        14: [1.0, 2.7, 4.2, 9.0, 26.3, 48.5, 74.6, 90.2, 94.4, 95.4, 97.9],
        15: [0.4, 2.7, 5.5, 12.0, 24.2, 47.9, 76.7, 89.4, 94.5, 95.8, 98.7],
        16: [0.7, 3.1, 5.4, 12.1, 25.3, 51.0, 75.4, 89.0, 94.2, 96.6, 97.8],
        17: [0.4, 2.5, 5.6, 12.1, 25.7, 51.0, 75.8, 90.4, 94.9, 97.1, 98.9],
        18: [0.4, 2.8, 5.8, 11.9, 24.1, 49.9, 75.9, 91.7, 95.3, 96.8, 98.5]
    };

    const ageInMonths = Math.floor(age * 12);
    const centiles = sex === 'male' ? weightForAgeTableBoys[ageInMonths] || weightForAgeTableBoys[0] : weightForAgeTableGirls[ageInMonths] || weightForAgeTableGirls[0];
    const zScore = (weight - centiles[5]) / ((centiles[7] - centiles[3]) / 2); 

    return zScore;
};

const getHeightZScoreFromWHOCharts = (age, sex, height) => {
    const heightForAgeTableBoys = {
        24: [78.0, 81.0, 84.1, 87.1, 90.2, 93.2, 96.3],
        25: [78.6, 81.7, 84.9, 88.0, 91.1, 94.2, 97.3],
        26: [79.3, 82.5, 85.6, 88.8, 92.0, 95.2, 98.3],
        27: [79.9, 83.1, 86.4, 89.6, 92.9, 96.1, 99.3],
        28: [80.5, 83.8, 87.1, 90.4, 93.7, 97.0, 100.3],
        29: [81.1, 84.5, 87.8, 91.2, 94.5, 97.9, 101.2],
        30: [81.7, 85.1, 88.5, 91.9, 95.3, 98.7, 102.1],
        31: [82.3, 85.7, 89.2, 92.7, 96.1, 99.6, 103.0],
        32: [82.8, 86.4, 89.9, 93.4, 96.9, 100.4, 103.9],
        33: [83.4, 86.9, 90.5, 94.1, 97.6, 101.2, 104.8],
        34: [83.9, 87.5, 91.1, 94.8, 98.4, 102.0, 105.6],
        35: [84.4, 88.1, 91.8, 95.4, 99.1, 102.7, 106.4],
        36: [85.0, 88.7, 92.4, 96.1, 99.8, 103.5, 107.2],
        37: [85.5, 89.2, 93.0, 96.7, 100.5, 104.2, 108.0],
        38: [86.0, 89.8, 93.6, 97.4, 101.2, 105.0, 108.8],
        39: [86.5, 90.3, 94.2, 98.0, 101.8, 105.7, 109.5],
        40: [87.0, 90.9, 94.7, 98.6, 102.5, 106.4, 110.3],
        41: [87.5, 91.4, 95.3, 99.2, 103.2, 107.1, 111.0],
        42: [88.0, 91.9, 95.9, 99.9, 103.8, 107.8, 111.7],
        43: [88.4, 92.4, 96.4, 100.4, 104.5, 108.5, 112.5],
        44: [88.9, 93.0, 97.0, 101.0, 105.1, 109.1, 113.2],
        45: [89.4, 93.5, 97.5, 101.6, 105.7, 109.8, 113.9],
        46: [89.8, 94.0, 98.1, 102.2, 106.3, 110.4, 114.6],
        47: [90.3, 94.4, 98.6, 102.8, 106.9, 111.1, 115.2],
        48: [90.7, 94.9, 99.1, 103.3, 107.5, 111.7, 115.9],
        49: [91.2, 95.4, 99.7, 103.9, 108.1, 112.4, 116.6],
        50: [91.6, 95.9, 100.2, 104.4, 108.7, 113.0, 117.3],
        51: [92.1, 96.4, 100.7, 105.0, 109.3, 113.6, 117.9],
        52: [92.5, 96.9, 101.2, 105.6, 109.9, 114.2, 118.6],
        53: [93.0, 97.4, 101.7, 106.1, 110.5, 114.9, 119.2],
        54: [93.4, 97.8, 102.3, 106.7, 111.1, 115.5, 119.9],
        55: [93.9, 98.3, 102.8, 107.2, 111.7, 116.1, 120.6],
        56: [94.3, 98.8, 103.3, 107.8, 112.3, 116.7, 121.2],
        57: [94.7, 99.3, 103.8, 108.3, 112.8, 117.4, 121.9],
        58: [95.2, 99.7, 104.3, 108.9, 113.4, 118.0, 122.6],
        59: [95.6, 100.2, 104.8, 109.4, 114.0, 118.6, 123.2],
        60: [96.1, 100.7, 105.3, 110.0, 114.6, 119.2, 123.9]
    };

    const heightForAgeTableGirls = {
        0: [43.6, 45.4, 47.3, 49.1, 51.0, 52.9, 54.7],
        1: [47.8, 49.8, 51.7, 53.7, 55.6, 57.6, 59.5],
        2: [51.0, 53.0, 55.0, 57.1, 59.1, 61.1, 63.2],
        3: [53.5, 55.6, 57.7, 59.8, 61.9, 64.0, 66.1],
        4: [55.6, 57.8, 59.9, 62.1, 64.3, 66.4, 68.6],
        5: [57.4, 59.6, 61.8, 64.0, 66.2, 68.5, 70.7],
        6: [58.9, 61.2, 63.5, 65.7, 68.0, 70.3, 72.5],
        7: [60.3, 62.7, 65.0, 67.3, 69.6, 71.9, 74.2],
        8: [61.7, 64.0, 66.4, 68.7, 71.1, 73.5, 75.8],
        9: [62.9, 65.3, 67.7, 70.1, 72.6, 75.0, 77.4],
        10: [64.1, 66.5, 69.0, 71.5, 73.9, 76.4, 78.9],
        11: [65.2, 67.7, 70.3, 72.8, 75.3, 77.8, 80.3],
        12: [66.3, 68.9, 71.4, 74.0, 76.6, 79.2, 81.7],
        13: [67.3, 70.0, 72.6, 75.2, 77.8, 80.5, 83.1],
        14: [68.3, 71.0, 73.7, 76.4, 79.1, 81.7, 84.4],
        15: [69.3, 72.0, 74.8, 77.5, 80.2, 83.0, 85.7],
        16: [70.2, 73.0, 75.8, 78.6, 81.4, 84.2, 87.0],
        17: [71.1, 74.0, 76.8, 79.7, 82.5, 85.4, 88.2],
        18: [72.0, 74.9, 77.8, 80.7, 83.6, 86.5, 89.4],
        19: [72.8, 75.8, 78.8, 81.7, 84.7, 87.6, 90.6],
        20: [73.7, 76.7, 79.7, 82.7, 85.7, 88.7, 91.7],
        21: [74.5, 77.5, 80.6, 83.7, 86.7, 89.8, 92.9],
        22: [75.2, 78.4, 81.5, 84.6, 87.7, 90.8, 94.0],
        23: [76.0, 79.2, 82.3, 85.5, 88.7, 91.9, 95.0],
        24: [76.7, 80.0, 83.2, 86.4, 89.6, 92.9, 96.1],
        49: [90.3, 94.6, 99.0, 103.3, 107.7, 112.0, 116.4],
        50: [90.7, 95.1, 99.5, 103.9, 108.3, 112.7, 117.1],
        51: [91.2, 95.6, 100.1, 104.5, 108.9, 113.3, 117.7],
        52: [91.7, 96.1, 100.6, 105.0, 109.5, 114.0, 118.4],
        53: [92.1, 96.6, 101.1, 105.6, 110.1, 114.6, 119.1],
        54: [92.6, 97.1, 101.6, 106.2, 110.7, 115.2, 119.8],
        55: [93.0, 97.6, 102.2, 106.7, 111.3, 115.9, 120.4],
        56: [93.4, 98.1, 102.7, 107.3, 111.9, 116.5, 121.1],
        57: [93.9, 98.5, 103.2, 107.8, 112.5, 117.1, 121.8],
        58: [94.3, 99.0, 103.7, 108.4, 113.0, 117.7, 122.4],
        59: [94.7, 99.5, 104.2, 108.9, 113.6, 118.3, 123.1],
        60: [95.2, 99.9, 104.7, 109.4, 114.2, 118.9, 123.7]
    };

    const ageInMonths = Math.floor(age * 12);
    const centiles = sex === 'male' ? heightForAgeTableBoys[ageInMonths] || heightForAgeTableBoys[24] : heightForAgeTableGirls[ageInMonths] || heightForAgeTableGirls[0];
    const zScore = (height - centiles[3]) / (centiles[5] - centiles[1]); // Simplified Z-Score calculation

    return zScore;
};

// Function to calculate BMI-for-Age Z-Score (BAZ)
const calculateBMIForAgeZScore = (age, sex, bmi) => {
    // Placeholder for actual BAZ calculation using WHO data
    // Replace this with the real BAZ calculation using WHO charts
    const zScore = getBMIZScoreFromWHOCharts(age, sex, bmi);
    return zScore.toFixed(2);
};

// Placeholder function to get BMI Z-Score from WHO charts
const getBMIZScoreFromWHOCharts = (age, sex, bmi) => {
    // Placeholder data for BMI Z-Score calculation
    // Replace this with actual data from WHO charts
    const bmiForAgeTable = {
        24: [14.0, 15.0, 16.0, 17.0, 18.0, 19.0, 20.0],
        25: [14.1, 15.1, 16.1, 17.1, 18.1, 19.1, 20.1],
    };

    const ageInMonths = Math.floor(age * 12);
    const centiles = bmiForAgeTable[ageInMonths] || bmiForAgeTable[24];
    const zScore = (bmi - centiles[3]) / (centiles[5] - centiles[1]); 

    return zScore;
};

// Classification based on Z-Scores
const classifyWeightForAgeZScore = (zScore) => {
    if (zScore < -3) return 'Severely Underweight';
    if (zScore >= -3 && zScore < -2) return 'Underweight';
    if (zScore >= -2 && zScore <= 2) return 'Normal Weight';
    return 'Overweight';
};

const classifyHeightForAgeZScore = (zScore) => {
    if (zScore < -3) return 'Severely Stunted';
    if (zScore >= -3 && zScore < -2) return 'Stunted';
    return 'Normal Height';
};

const classifyWeightForHeightZScore = (zScore) => {
    if (zScore < -3) return 'Severely Wasted';
    if (zScore >= -3 && zScore < -2) return 'Wasted';
    if (zScore >= -2 && zScore <= 2) return 'Normal';
    if (zScore > 2 && zScore <= 3) return 'Overweight';
    return 'Obese';
};

// Function to calculate expected weight based on age in months
const calculateExpectedWeight = (ageInMonths) => {
    if (ageInMonths <= 12) {
        return (ageInMonths + 9) / 2;
    } else if (ageInMonths <= 60) {
        return 2 * ((ageInMonths / 12) + 5);
    } else if (ageInMonths <= 168) {
        return 4 * (ageInMonths / 12);
    }
    return null;
};

// Function to classify weight based on expected weight
const classifyWeightBasedOnExpected = (ageInMonths, weight) => {
    const expectedWeight = calculateExpectedWeight(ageInMonths);
    if (expectedWeight === null) return 'Unknown';
    const weightDifference = weight - expectedWeight;
    if (weightDifference < -3) return 'Severely Underweight';
    if (weightDifference >= -3 && weightDifference < -1) return 'Underweight';
    if (weightDifference >= -1 && weightDifference <= 1) return 'Normal Weight';
    return 'Overweight';
};

// Function to calculate Age
const calculateAge = (birthDate) => {
    const birth = new Date(birthDate);
    const today = new Date();
    let age = today.getFullYear() - birth.getFullYear();
    const m = today.getMonth() - birth.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) {
        age--;
    }
    return age;
};

// Computed property to sort and map growth monitoring records
const sortedGrowthMonitoringRecords = computed(() => {
    console.log('props.child.growth_monitorings:', props.child.growth_monitorings);
    const records = props.child.growth_monitorings.map(record => {
        const bmi = calculateChildBMI(record.weight, record.height);
        const bmiClassification = classifyBMI(bmi);
        const bmiZScore = calculateBMIForAgeZScore(record.age, record.sex, bmi);
        let weightZScore = '';
        let weightForAgeClassification = '';
        let heightForAgeClassification = '';
        let weightForHeightClassification = '';

        if (record.age <= 59) {
            weightZScore = calculateWeightForAgeZScore(record.age, record.sex, record.weight);
            weightForAgeClassification = classifyWeightForAgeZScore(weightZScore);
            heightForAgeClassification = classifyHeightForAgeZScore(record.age, record.sex, record.height);
            weightForHeightClassification = classifyWeightForHeightZScore(bmiZScore);
        }

        const weightBasedClassification = classifyWeightBasedOnExpected(record.age, record.weight);

        return {
            date: record.date,
            weight: record.weight,
            height: record.height,
            bmi: bmi,
            age: record.age,
            sex: record.sex,
            weight_status: weightBasedClassification, // Use weightBasedClassification instead of bmiClassification
            bmi_zscore: bmiZScore,
            weight_zscore: weightZScore,
            weight_for_age_status: weightForAgeClassification,
            height_for_age_status: heightForAgeClassification,
            weight_for_height_status: weightForHeightClassification
        };
    });
    console.log('sortedGrowthMonitoringRecords:', records);
    return records;
});

// Show or hide modals and flash messages
const showAddModal = ref(false);
const showFlashMessage = ref(false);
const flashMessage = ref('');
const showGrowthMonitoring = ref(true);

// New record object for adding growth monitoring data
const newRecord = ref({
    date: "",
    weight: "",
    height: "",
    bmi: "",
    age: "",
    sex: "",
    weight_status: " ",
    height_for_age_status: " ",
    weight_for_age_status: " ",
    weight_for_height_status: " ",
});

// Get today's date
const today = new Date().toISOString().split('T')[0];

// Handle add record button click
const handleAddClick = () => {
    showAddModal.value = true;
};

// Add record function
const addRecord = () => {
    newRecord.value.bmi = calculateChildBMI(newRecord.value.weight, newRecord.value.height);
    newRecord.value.weight_status = classifyBMI(newRecord.value.bmi);
    newRecord.value.bmi_zscore = calculateBMIForAgeZScore(newRecord.value.age, newRecord.value.sex, newRecord.value.bmi);
    let weightZScore = '';
    let heightForAgeClassification = '';
    let weightForHeightClassification = '';
    if (newRecord.value.age <= 59) {
        weightZScore = calculateWeightForAgeZScore(newRecord.value.age, newRecord.value.sex, newRecord.value.weight);
        newRecord.value.weight_for_age_status = classifyWeightForAgeZScore(weightZScore);
        heightForAgeClassification = classifyHeightForAgeZScore(newRecord.value.age, newRecord.value.sex, newRecord.value.height);
        weightForHeightClassification = classifyWeightForHeightZScore(newRecord.value.bmi_zscore);
    }
    newRecord.value.weight_zscore = weightZScore;
    newRecord.value.height_for_age_status = heightForAgeClassification;
    newRecord.value.weight_for_height_status = weightForHeightClassification;

    axios.post(`/child/${props.child.id}/addGrowthMonitoring`, { 
        date: newRecord.value.date,
        weight: newRecord.value.weight,
        height: newRecord.value.height,
        bmi: newRecord.value.bmi,
        sex: newRecord.value.sex, 
        age: newRecord.value.age,
        weight_status: newRecord.value.weight_status,
        weight_zscore: newRecord.value.weight_zscore,
        weight_for_age_status: newRecord.value.weight_for_age_status,
        height_for_age_status: newRecord.value.height_for_age_status,
        weight_for_height_status: newRecord.value.weight_for_height_status
    })
    .then(response => {
        showAddModal.value = false;
        flashMessage.value = 'Record added successfully!';
        showFlashMessage.value = true;
        setTimeout(() => (showFlashMessage.value = false), 5000);
        props.child.growth_monitorings.push(response.data.record);
    })
    .catch(error => {
        flashMessage.value = 'Failed to add record! ' + (error.response?.data?.message || error.message);
        showFlashMessage.value = true;
        setTimeout(() => (showFlashMessage.value = false), 5000);
    });
};

// Toggle the visibility of growth monitoring records
const togglegrowth_monitorings = () => {
    showGrowthMonitoring.value = !showGrowthMonitoring.value;
};
</script>

<template>
    <!-- Growth Monitoring Records Section -->
    <div v-if="child" class="container">
        <div class="header" @click="togglegrowth_monitorings" style="cursor: pointer;">
            <div style="display: flex; align-items: center;">
                <h1>Counseling (Growth Monitoring)</h1>
                <span style="margin-left: 10px; margin-bottom:10px;color:#488a99;">
                    {{ showGrowthMonitoring ? '▼' : '▲' }}
                </span>
            </div>
            <button @click.stop="handleAddClick" class="add-button">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <transition name="fade">
            <div v-if="showGrowthMonitoring" class="scrollable-table">
                <table class="info-table">
                    <thead>
                        <tr>
                            <th>Age in months</th>
                            <th>Weight (kgs)</th>
                            <th>Height (cm)</th>
                            <th>Sex</th>
                            <th>Weight for Age</th>
                            <th>Height for Age</th>
                            <th>Weight for Height</th>
                            <th>Date of Monitoring</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="!child.growth_monitorings || child.growth_monitorings.length === 0">
                            <td colspan="10" class="no-data" style="text-align: center; font-weight: normal; text-transform: none;">No records available</td>
                        </tr>
                        <tr v-for="record in sortedGrowthMonitoringRecords" :key="record.date">
                            <td>{{ record.age }}</td>
                            <td>{{ record.weight }}</td>
                            <td>{{ record.height }}</td>
                            <td>{{ record.sex }}</td>
                            <td>{{ record.weight_for_age_status }}</td>
                            <td>{{ record.height_for_age_status }}</td>
                            <td>{{ record.weight_for_height_status }}</td>
                            <td>{{ formatDate(record.date) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </transition>
    </div>

    <!-- Add Growth Monitoring Record Modal -->
    <transition name="fade">
        <div v-if="showAddModal" class="modal-overlay">
            <div class="modal-content">
                <h2 class="add-vac" style="color: #488a99;">Add Growth Monitoring Record</h2>
                <form @submit.prevent="addRecord">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="date">Monitoring Date:</label>
                            <input type="date" v-model="newRecord.date" :max="today" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="weight">Weight (kgs):</label>
                            <input type="number" v-model="newRecord.weight" step="0.01" required />
                        </div>
                        <div class="form-group">
                            <label for="height">Height (cm):</label>
                            <input type="number" v-model="newRecord.height" step="0.01" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="age">Age in months:</label>
                            <input type="text" v-model="newRecord.age" required />
                        </div>
                        <div class="form-group">
                            <label for="sex">Sex:</label>
                            <select name="sex" id="sex" v-model="newRecord.sex" required>
                                <option value="">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="button-container">
                        <button type="submit">Add</button>
                        <button type="button" @click="showAddModal = false">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </transition>

    <!-- Flash Message -->
    <transition name="fade">
        <div v-if="showFlashMessage" class="flash-modal">
            <div class="flash-content">{{ flashMessage }}</div>
        </div>
    </transition>
</template>

<style scoped>
.no-data {
    text-transform: none;
}
.scrollable-table {
    max-height: 350px;
    overflow-y: auto;
    margin-top: 10px;
    scroll-snap-type: y mandatory;
    position: relative;
}
.scrollable-table > .data-table {
    width: 100%;
}
.add-vac {
    font-size: 18px;
    font-weight: bold;
}
.add-button {
    position: absolute;
    right: 0;
    top: 90%;
    transform: translateY(-50%);
    background-color: #4CAF50; 
    border: none; 
    color: white;
    padding: 5px 15px; 
    text-align: center; 
    text-decoration: none; 
    display: inline-block; 
    font-size: 14px; 
    cursor: pointer;
    border-radius: 8px; 
    transition: background-color 0.3s ease; 
}
.add-button:hover {
    background-color: #45a049; 
}
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 2px solid #ddd;
    position: relative;
}
.container {
    max-width: 100%;
    padding: 20px;
    margin-top: 0;
    margin-bottom: 5%;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
}
.info-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-size: 14px;
}
.info-table thead th {
    position: sticky;
    top: 0;
    background-color: #007bff;
    padding: 10px;
    text-align: center;
    font-weight: bold;
    z-index: 1;
}
.info-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
    color: #333;
}
.info-table td:first-child {
    text-align: center;
    width:1%;
}
.info-table td:nth-child(2){
    width: 10%; 
}
.info-table td:nth-child(3),.info-table td:nth-child(4){
    width: 10%; 
}
.info-table td:nth-child(5),.info-table td:nth-child(6),.info-table td:nth-child(7){
    width: 17%; 
}
.info-table tr:hover {
    background-color: #f1f1f1;
}
h1 {
    color: #488a99;
    font-size: 16px;
    padding-bottom: 10px;
    font-weight: bold;
    width: 100%;
}
button {
    padding: 5px 10px;
    font-size: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #488a99;
    color: white;
    cursor: pointer;
    margin-bottom: 10px;
}
button:hover {
    background-color: #3a6f7a;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
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
    width: 500px; 
    width: 35%; 
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
.modal-content input[type="text"][placeholder="5 mins"] {
    width: 50%;
}
.modal-content select[name="breastfeeding_status"] {
    width: 100%;
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
.flash-message {
    background-color: #f44336;
    color: white;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 10px;
    text-align: center;
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
.form-row {

    display: flex;
    justify-content: space-between;
}
.form-group {
    flex: 1;
    margin-right: 10px;
}
.form-group-duration {
    flex: 1;
    right: 0;
}
.form-group:last-child {
    margin-right: 0;
}
</style>