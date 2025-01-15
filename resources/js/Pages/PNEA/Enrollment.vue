<template>
    <!-- Flash Message -->
    <div v-if="showFlashMessage" :class="['flash-message', { error: isError }]">
        {{ flashMessage }}
    </div>
    <div v-if="pnea">
        <h1 style="margin-top: 20px;">Personal Information <Space/>
            <button @click="isEditing ? saveData() : editData()" :class="['icon-buttons', { 'save-button': isEditing }]">
                <i :class="isEditing ? 'fas fa-save' : 'fas fa-edit'"></i>
            </button>
            <!-- <button v-if="isEditing" @click="cancelEdit" class="icon-buttons">
                <i class="fas fa-times"></i>
            </button> -->
        </h1>
        <div class="card">
            <div class="container-1">
                <p class="width-50">
                    <strong class="labels">Name of Mother:</strong> <Space />
                    <span v-if="!isEditing">{{ capitalize(pnea.fullName) }}</span>
                    <input v-else v-model="editablePnea.fullName" class="short-input" />
                </p>
                <p class="width-35">
                    <strong class="labels">Birthdate:</strong> <Space />
                    <span v-if="!isEditing">{{ formattedBirthDate }}</span>
                    <input v-else type="date" v-model="editablePnea.birth_date" class="short-input" />
                </p>
                <p class="width-20">
                    <strong class="labels">Age:</strong> <Space />
                    <span v-if="!isEditing">{{ pnea.age }} years</span>
                    <input v-else v-model="editablePnea.age" class="short-input" />
                </p>
            </div>
            <div class="container-1">
                <p class="width-50">
                    <strong class="labels">Educational Level:</strong> <Space />
                    <span v-if="!isEditing">{{ capitalize(pnea.education) }}</span>
                    <select v-else v-model="editablePnea.education" class="short-input">
                        <option value="None">N/A</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Highschool">High School</option>
                        <option value="College">College</option>
                        <option value="Postgraduate">Post Graduate</option>
                    </select>
                </p>
                <p class="width-30">
                    <strong class="labels">MUAC:</strong> <Space />
                    <span v-if="!isEditing">{{ pnea.muac }}</span>
                    <input v-else v-model="editablePnea.muac" class="short-input" />
                </p>
            </div>
            <div class="container-1">
                <p class="width-50">
                    <strong class="labels">Occupation:</strong> <Space />
                    <span v-if="!isEditing">{{ capitalize(pnea.occupation) }}</span>
                    <input v-else v-model="editablePnea.occupation" class="short-input" />
                </p>
                <p class="width-30">
                    <strong class="labels">Height:</strong> <Space />
                    <span v-if="!isEditing">{{ pnea.height }} cm</span>
                    <input v-else v-model="editablePnea.height" class="short-input" />
                </p>
                <p class="width-20" style="margin-left: 10%;">
                    <strong class="labels">Weight:</strong> <Space />
                    <span v-if="!isEditing">{{ pnea.weight }} kg</span>
                    <input v-else v-model="editablePnea.weight" class="short-input" />
                </p>
            </div>
            <div class="container-1">
                <p class="width-50">
                    <strong class="labels">Term of Pregnancy:</strong> <Space />
                    <span v-if="!isEditing">{{ capitalize(pnea.term_of_pregnancy) }}</span>
                    <input v-else v-model="editablePnea.term_of_pregnancy" class="short-input" />
                </p>
                <p class="width-50">
                    <strong class="labels">Interval of Delivery:</strong> <Space />
                    <span v-if="!isEditing">{{ pnea.interval_of_delivery }}</span>
                    <input v-else v-model="editablePnea.interval_of_delivery" class="short-input" />
                </p>
            </div>
            <div class="container-1">
                <p class="width-50">
                    <strong class="labels">Number of Pregnancy:</strong> <Space />
                    <span v-if="!isEditing">{{ pnea.number_of_pregnancy }}</span>
                    <input v-else v-model="editablePnea.number_of_pregnancy" class="short-input" />
                </p>
                <p class="width-20">
                    <strong class="labels">BMI:</strong> <Space />
                    <span v-if="!isEditing">{{ pnea.bmi }}</span>
                    <input v-else v-model="editablePnea.bmi" class="short-input" />
                </p>
            </div>
            <div class="container-1">
                <p class="width-50">
                    <strong class="labels">Number of Children:</strong> <Space />
                    <span v-if="!isEditing">{{ pnea.number_of_children }}</span>
                    <input v-else v-model="editablePnea.number_of_children" class="short-input" />
                </p>
                <p class="width-30">
                    <strong class="labels">NS:</strong> <Space />
                    <span v-if="!isEditing">{{ pnea.ns }}</span>
                    <input v-else v-model="editablePnea.ns" class="short-input" />
                </p>
            </div>
            <div class="container-1">
                <p class="width-50">
                    <strong class="labels">Name of Husband:</strong> <Space />
                    <span v-if="!isEditing">{{ capitalize(pnea.name_of_husband) }}</span>
                    <input v-else v-model="editablePnea.name_of_husband" class="short-input" />
                </p>
                <p class="width-50">
                    <strong class="labels">Date of Last Delivery:</strong> <Space />
                    <span v-if="!isEditing">{{ formattedLastDeliveryDate }}</span>
                    <input v-else type="date" v-model="editablePnea.date_last_delivery" class="short-input" />
                </p>
            </div>
            <div class="container-1">
                <p class="width-50">
                    <strong class="labels">Occupation of Husband:</strong> <Space />
                    <span v-if="!isEditing">{{ capitalize(pnea.husband_occupation) }}</span>
                    <input v-else v-model="editablePnea.husband_occupation" class="short-input" />
                </p>
                <p class="width-50">
                <strong class="labels">Husband's Educational Level:</strong> <Space />
                    <span v-if="!isEditing">{{ capitalize(pnea.husband_education) }}</span>
                    <select v-else v-model="editablePnea.husband_education" class="short-input">
                        <option value="None">N/A</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Highschool">High School</option>
                        <option value="College">College</option>
                        <option value="Postgraduate">Post Graduate</option>
                    </select>
                </p>

            </div>
            <div class="container-1">
                <p class="width-50">
                    <strong class="labels">Monthly Family Income:</strong> <Space />
                    <span v-if="!isEditing">{{ pnea.monthly_family_income }}</span>
                    <input v-else v-model="editablePnea.monthly_family_income" class="short-input" />
                </p>
                <p class="width-50">
                    <strong class="labels">Household Size:</strong> <Space />
                    <span v-if="!isEditing">{{ pnea.household_size }}</span>
                    <input v-else v-model="editablePnea.household_size" class="short-input" />
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';
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

const capitalize = (str) => (str ? str.charAt(0).toUpperCase() + str.slice(1) : '');

const isEditing = ref(false);
const editablePnea = ref({ ...props.pnea });
const flashMessage = ref('');
const showFlashMessage = ref(false);
const isError = ref(false);

const editData = () => {
    isEditing.value = true;
};

const saveData = async () => {
    try {
        const response = await axios.put(
            route('pnea-enrollment-update', { id: props.pnea.id }),
            { ...editablePnea.value }
        );
        Object.assign(props.pnea, response.data);
        flashMessage.value = 'Changes saved successfully!';
        isError.value = false;
        showFlashMessage.value = true;
        isEditing.value = false;
        setTimeout(() => (showFlashMessage.value = false), 900);
    } catch (error) {
        console.error('Error updating data:', error);
        flashMessage.value = `Failed to update! Please check your input and try again.`;
        isError.value = true;
        showFlashMessage.value = true;
        setTimeout(() => (showFlashMessage.value = false), 5000);
    }
};

const cancelEdit = () => {
    Object.assign(editablePnea.value, props.pnea);
    isEditing.value = false;
};
</script>


<style scoped>
h1 {
    color: #488a99;
    font-size: 20px;
    padding-top: 20px;
    padding-bottom: 10px;
    font-weight: bold;
    text-align: left;
    border-bottom: 2px solid #488a99;
    margin-bottom: 20px;
}
.labels {
    color:#3e6e79;
}
.card {
    position: relative;
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
}
.width-35 {
    flex: 0 0 35%;
}
.width-20 {
    flex: 0 0 20%;
}
.flash-message {
    position: fixed;
    top: 60px;
    left: 50%;
    transform: translateX(-50%);
    padding: 10px;
    color: #fff;
    background-color: #4caf50; 
    border-radius: 5px;
    text-align: center;
    z-index: 1000;
}
.flash-message.error {
    background-color: #ff5722;
}
.icon-buttons {
    background: none;
    border: none;
    cursor: pointer;
    color: #ffc107; 
}
.icon-buttons:hover {
    color: #ec971f; 
}
.icon-buttons.save-button {
    color: #007bff;
}
.short-input {
    width: 40%;
    margin: 0;
    padding: 0;
    border: 1px solid rgba(204, 204, 204, 0.3); 
    border-radius: 4px; 
}
</style>
