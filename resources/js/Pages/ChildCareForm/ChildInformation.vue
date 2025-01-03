<template>
    <div v-if="child">
        <h1>Child's Information</h1>
        <div class="card">
            <div class="container-1">
                <p class="width-50"><strong>Full Name:</strong> <Space/><span>{{ child.first_name }} {{ child.middle_name }} {{ child.last_name }} {{ child.suffix }}</span></p>
                <p class="width-50"><strong>Gestational Age at Birth:</strong> <Space/><span>{{ child.gestational_age }}</span></p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Complete Address:</strong> <Space/><span>{{ child.complete_address }}</span></p>
                <p class="width-50"><strong>Type of Birth:</strong> <Space/><span>{{ child.type_of_birth }}</span></p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Birth Date:</strong> <Space/><span>{{ formattedBirthDate }}</span></p>
                <p class="width-50"><strong>Birth Order:</strong> <Space/><span>{{ child.birth_order }}</span></p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Birth Place:</strong> <Space/><span>{{ child.birth_place }} {{ child.other_birth_place }}</span></p>
                <p class="width-50"><strong>Family No. :</strong> <Space/><span>{{ child.family_no }}</span></p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Birth Weight:</strong> <Space/><span>{{ child.birth_weight }}</span></p>
                <p class="width-50"><strong>Child No. :</strong> <Space/><span>{{ child.child_no }}</span></p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Birth Length:</strong> <Space/><span>{{ child.birth_length }}</span></p>
                <p class="width-50"><strong>Birth Attendant:</strong> <Space/><span>{{ child.birth_attendant }} {{ child.other_birth_attendant }}</span></p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Birth Registered:</strong> <Space/><span>{{ child.birth_registered }}</span></p>
            </div>
        </div>
        <h1>Mother's Information</h1>
        <div class="card">
            <div class="container-1">
                <p class="width-50"><strong>Full Name:</strong> <Space/><span>{{ child.mother_name }}</span></p>
                <p class="width-50"><strong>Education:</strong> <Space/><span>{{ child.mother_education }}</span></p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>No. of Pregnancies:</strong> <Space/><span>{{ child.no_pregancies }}</span></p>
                <p class="width-50"><strong>Occupation:</strong> <Space/><span>{{ child.mother_occupation }}</span></p>
            </div>
        </div>
        <h1>Father's Information</h1>
        <div class="card">
            <div class="container-1">
                <p class="width-50"><strong>Full Name:</strong> <Space/><span>{{ child.father_name }}</span></p>
                <p class="width-50"><strong>Education:</strong> <Space/><span>{{ child.father_education }}</span></p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Occupation:</strong> <Space/><span>{{ child.father_occupation }}</span></p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, computed } from 'vue';
import Space from '../../Components/Space.vue';

const props = defineProps({
    child: { type: Object, required: true },
});

const formattedBirthDate = computed(() => {
    const date = new Date(props.child.birth_date);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
});
</script>

<style scoped>
h1 {
    color: #488a99;
    font-size: 17px;
    padding-top: 20px;
    padding-bottom:10px;
    font-weight: bold;
    text-align: left;
    border-bottom: 2px solid #488a99;
    margin-bottom: 20px;
    margin-left: 10px;
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
</style>