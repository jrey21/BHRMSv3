<template>
    <div v-if="showFlashMessage" :class="['flash-message', { error: isError }]">
        {{ flashMessage }}
    </div>
    <div v-if="child">
        <h1>Child's Information <Space/>
            <button @click="isEditing ? saveData() : editData()" :class="['icon-buttons', { 'save-button': isEditing }]">
                <i :class="isEditing ? 'fas fa-save' : 'fas fa-edit'"></i>
            </button>
            <!-- <button v-if="isEditing" @click="cancelEdit" class="icon-buttons">
                <i class="fas fa-times"></i>
            </button> -->
        </h1>
        <div class="card">
            <div class="container-1">
                <p class="width-50"><strong>Full Name:</strong> <Space/>
                    <span>{{ child.first_name }} {{ child.middle_name }} {{ child.last_name }} {{ child.suffix }}</span>
                    <!-- <input v-if="isEditing" v-model="editableChild.first_name" class="short-input" disabled /> -->
                </p>
                <p class="width-50"><strong>Gestational Age at Birth:</strong> <Space/>
                    <span v-if="!isEditing">{{ child.gestational_age }}</span>
                    <select v-else v-model="editableChild.gestational_age" class="short-input">
                        <option value="Less than 28 weeks">Less than 28 weeks</option>
                        <option value="28-31 Weeks">28-31 weeks</option>
                        <option value="32-36 Weeks">32-36 weeks</option>
                        <option value="37-38 Weeks">37-48 weeks</option>
                        <option value="39-40 Weeks">39-40 weeks</option>
                        <option value="41 Weeks">41 weeks</option>
                        <option value="42 Weeks Or More">42 weeks or more</option>
                    </select>
                </p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Complete Address:</strong> <Space/>
                    <span v-if="!isEditing">{{ child.complete_address }}</span>
                    <input v-else v-model="editableChild.complete_address" class="short-input" />
                </p>
                <p class="width-50"><strong>Type of Birth:</strong> <Space/>
                    <span v-if="!isEditing">{{ child.type_of_birth }}</span>
                    <select v-else v-model="editableChild.type_of_birth" class="short-input">
                        <option value="Normal">Normal</option>
                        <option value="Cesarean">CS</option>
                    </select>
                </p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Birth Date:</strong> <Space/>
                    <span v-if="!isEditing">{{ formattedBirthDate }}</span>
                    <input v-else type="date" v-model="editableChild.birth_date" class="short-input" />
                </p>
                <p class="width-50"><strong>Birth Order:</strong> <Space/>
                    <span v-if="!isEditing">{{ child.birth_order }}</span>
                    <input v-else v-model="editableChild.birth_order" class="short-input" />
                </p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Place of Delivery:</strong> <Space/>
                    <span v-if="!isEditing && child.birth_place === 'Others'">{{ child.other_birth_place }}</span>
                    <span v-else-if="!isEditing">{{ child.birth_place }}</span>
                    <select v-else v-model="editableChild.birth_place" class="short-input-other">
                        <option value="Home">Home</option>
                        <option value="Hospital">Hospital</option>
                        <option value="Lying-in">Lying-in</option>
                        <option value="Others">Others</option>
                    </select>
                    <input v-if="isEditing && editableChild.birth_place === 'Others'" v-model="editableChild.other_birth_place" class="short-input" />
                </p>
                <p class="width-50"><strong>Family No. :</strong> <Space/>
                    <span v-if="!isEditing">{{ child.family_no }}</span>
                    <input v-else v-model="editableChild.family_no" class="short-input" />
                </p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Birth Weight:</strong> <Space/>
                    <span v-if="!isEditing">{{ child.birth_weight }}</span>
                    <input v-else v-model="editableChild.birth_weight" class="short-input" />
                </p>
                <p class="width-50"><strong>Child No. :</strong> <Space/>
                    <span v-if="!isEditing">{{ child.child_no }}</span>
                    <input v-else v-model="editableChild.child_no" class="short-input" />
                </p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Birth Length:</strong> <Space/>
                    <span v-if="!isEditing">{{ child.birth_length }}</span>
                    <input v-else v-model="editableChild.birth_length" class="short-input" />
                </p>
                <p class="width-50"><strong>Birth Attendant:</strong> <Space/>
                    <span v-if="!isEditing && child.birth_attendant === 'Others'">{{ child.other_birth_attendant }}</span>
                    <span v-else-if="!isEditing">{{ child.birth_attendant }}</span>
                    <select v-else v-model="editableChild.birth_attendant" class="short-input-other">
                        <option value="Doctor">Doctor</option>
                        <option value="Midwife">Midwife</option>
                        <option value="Nurse">Nurse</option>
                        <option value="Others">Others</option>
                    </select>
                    <input v-if="isEditing && editableChild.birth_attendant === 'Others'" v-model="editableChild.other_birth_attendant" class="short-input" />
                </p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Birth Registered:</strong> <Space/>
                    <span v-if="!isEditing">{{ formattedBirthRegistered }}</span>
                    <input v-else type="date" v-model="editableChild.birth_registered" class="short-input" />
                </p>
                <p class="width-50"><strong>Zone: </strong> <Space/>
                    <span v-if="!isEditing">{{ child.zone }}</span>
                    <select v-else v-model="editableChild.zone" class="short-input">
                        <option value="Zone 1">Zone 1</option>
                        <option value="Zone 2">Zone 2</option>
                        <option value="Zone 3">Zone 3</option>
                        <option value="Zone 4">Zone 4</option>
                        <option value="Zone 5">Zone 5</option>
                        <option value="Zone 6">Zone 6</option>
                        <option value="Zone 7">Zone 7</option>
                    </select>
                </p>
            </div>
        </div>
        <h1>Mother's Information</h1>
        <div class="card">
            <div class="container-1">
                <p class="width-50"><strong>Full Name:</strong> <Space/>
                    <span v-if="!isEditing">{{ child.mother_name }}</span>
                    <input v-else v-model="editableChild.mother_name" class="short-input" />
                </p>
                <p class="width-50"><strong>Education:</strong> <Space/>
                    <span v-if="!isEditing">{{ child.mother_education }}</span>
                    <select v-else v-model="editableChild.mother_education" class="short-input">
                        <option value="None">N/A</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Highschool">High School</option>
                        <option value="College">College</option>
                        <option value="Postgraduate">Post Graduate</option>
                    </select>
                </p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>No. of Pregnancies:</strong> <Space/>
                    <span v-if="!isEditing">{{ child.no_pregancies }}</span>
                    <input v-else v-model="editableChild.no_pregancies" class="short-input" />
                </p>
                <p class="width-50"><strong>Occupation:</strong> <Space/>
                    <span v-if="!isEditing">{{ child.mother_occupation }}</span>
                    <input v-else v-model="editableChild.mother_occupation" class="short-input" />
                </p>
            </div>
        </div>
        <h1>Father's Information</h1>
        <div class="card">
            <div class="container-1">
                <p class="width-50"><strong>Full Name:</strong> <Space/>
                    <span v-if="!isEditing">{{ child.father_name }}</span>
                    <input v-else v-model="editableChild.father_name" class="short-input" />
                </p>
                <p class="width-50"><strong>Education:</strong> <Space/>
                    <span v-if="!isEditing">{{ child.father_education }}</span>
                    <select v-else v-model="editableChild.father_education" class="short-input">
                        <option value="None">N/A</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Highschool">High School</option>
                        <option value="College">College</option>
                        <option value="Postgraduate">Post Graduate</option>
                    </select>
                </p>
            </div>
            <div class="container-1">
                <p class="width-50"><strong>Occupation:</strong> <Space/>
                    <span v-if="!isEditing">{{ child.father_occupation }}</span>
                    <input v-else v-model="editableChild.father_occupation" class="short-input" />
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, computed, ref } from 'vue';
import Space from '../../Components/Space.vue';
import axios from 'axios';

const props = defineProps({
    child: { type: Object, required: true },
});

const formattedBirthDate = computed(() => {
    const date = new Date(props.child.birth_date);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
});

const formattedBirthRegistered = computed(() => {
    const date = new Date(props.child.birth_registered);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
});

const isEditing = ref(false);
const editableChild = ref({ ...props.child });
const flashMessage = ref('');
const showFlashMessage = ref(false);
const isError = ref(false);

const editData = () => {
    isEditing.value = true;
};

const saveData = async () => {
    try {
        const response = await axios.put(
            route('childcare-form-update', { id: props.child.id }),
            { ...editableChild.value }
        );
        Object.assign(props.child, response.data);
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
    Object.assign(editableChild.value, props.child);
    isEditing.value = false;
};
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
.short-input {
    width: 40%;
    margin: 0;
    padding: 0;
    border: 1px solid rgba(204, 204, 204, 0.3); 
    border-radius: 4px; 
}
.short-input-other {
    width: 18%;
    margin: 0;
    padding: 0;
    border: 1px solid rgba(204, 204, 204, 0.3); 
    border-radius: 4px; 
}
</style>