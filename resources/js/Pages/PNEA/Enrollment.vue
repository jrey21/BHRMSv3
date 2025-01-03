<template>
    <div v-if="pnea">
        <h1>Personal Information</h1>
        <div class="card">
            <div class="container-1">
                <p class="width-50"><strong>Name of Mother:</strong> <Space/><span>{{ capitalize(pnea.fullName) }}</span></p>
                <p class="width-35"><strong>Birthdate: </strong><Space/><span>{{ formattedBirthDate }}</span></p>
                <p class="width-20"><strong>Age:  </strong><Space/><span>{{ pnea.age }} years</span></p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Educational Level:</strong> <Space/><span>{{ capitalize(pnea.education) }}</span></p>
                <p class="width-30"><strong>MUAC:</strong> <Space/><span>{{ pnea.muac }}</span></p>
            </div>     
            <div class="container-1">
                <p class="width-50"><strong>Occupation:</strong> <Space/><span>{{ capitalize(pnea.occupation) }}</span></p>
                <p class="width-30"><strong>Height:</strong> <Space/><span>{{ pnea.height }} cm</span></p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Term of Pregnancy:</strong> <Space/><span>{{ capitalize(pnea.term_of_pregnancy) }}</span></p>
                <p class="width-20"><strong>Weight:</strong> <Space/><span>{{ pnea.weight }} kg</span></p>
            </div>   
            <div class="container-1">
                <p class="width-50"><strong>Number of Pregnancy:</strong> <Space/><span>{{ pnea.number_of_pregnancy }}</span></p>
                <p class="width-20"><strong>BMI:</strong> <Space/><span>{{ pnea.bmi }}</span></p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Number of Children:</strong> <Space/><span>{{ pnea.number_of_children }}</span></p>
                <p class="width-30"><strong>NS:</strong> <Space/><span>{{ pnea.ns }}</span></p>
            </div> 
            <div class="container-1">
                <p class="width-50"><strong>Name of Husband:</strong> <Space/><span>{{ capitalize(pnea.name_of_husband) }}</span></p>
                <p class="width-50"><strong>Date of last Delivery:</strong> <Space/><span>{{ formattedLastDeliveryDate }}</span></p>
            </div> 
            <div class="container-1">
                <p class="width-50"><strong>Occupation of Husband:</strong> <Space/><span>{{ capitalize(pnea.husband_occupation) }}</span></p>
                <p class="width-50"><strong>Interval of Delivery:</strong> <Space/><span>{{ pnea.interval_of_delivery }}</span></p>
            </div>   
            <div class="container-1">
                <p class="width-50"><strong>Monthly Family Income:</strong> <Space/><span>{{ pnea.monthly_family_income }}</span></p>
                <p class="width-50"><strong>Household Size:</strong> <Space/><span>{{ pnea.household_size }}</span></p>
            </div>
        </div>
    </div>
    <div v-if="showSuccessModal" class="modal">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <p>Data added successfully!</p>
        </div>
    </div>
</template>

<script setup>
import { defineProps, computed, ref } from 'vue';
import Space from '../../Components/Space.vue';

const props = defineProps({
    pnea: { type: Object, required: true },
});

const formattedBirthDate = computed(() => {
    const date = new Date(props.pnea.birth_date);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
});

const formattedLastDeliveryDate = computed(() => {
    const date = new Date(props.pnea.date_last_delivery);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
});

const capitalize = (str) => {
    if (!str) return '';
    return str.charAt(0).toUpperCase() + str.slice(1);
};

const showSuccessModal = ref(false);

const closeModal = () => {
    showSuccessModal.value = false;
};

// Simulate adding data and showing the modal
const addData = () => {
    // ...code to add data...
    showSuccessModal.value = true;
};
</script>

<style scoped>
h1 {
    color: #488a99;
    font-size: 20px;
    padding-top: 20px;
    padding-bottom:10px;
    font-weight: bold;
    text-align: left;
    border-bottom: 2px solid #488a99;
    margin-bottom: 20px;
}
.card {
    background-color: #fff;
    padding: 10px;
    margin: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.container-1 {
    display: flex;
    margin-bottom: 5px;
}
.width-50 {
    flex: 0 0 50%;
    margin-bottom: 5px;
}
.width-35 {
    flex: 0 0 35%;
}
.width-30 {
    flex: 0 0 30%;
}
.width-20 {
    flex: 0 0 25%;
}
.width-10 {
    flex: 0 0 10%;
}
p {
    margin: 0;
    padding: 0;
    color: #34495e;
}
strong {
    color: #34495e;
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
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    text-align: center;
    border-radius: 10px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>