<script setup>
import { ref } from 'vue';
import axios from 'axios';
import Forms from '../../Layouts/Forms.vue';

defineOptions({ layout: Forms });

const props = defineProps(['pnea']); 

const formData = ref({
  // Row 1
  prenatal_care_counseled: false,
  prenatal_care_date_counseled: '',
  prenatal_care_practiced: '',
  // Row 2
  prenatal_checkup_counseled: false,
  prenatal_checkup_date_counseled: '',
  prenatal_care_dates: [{
    prenatal_checkup_trimester_practiced: '',
    prenatal_checkup_date_practiced: ''
  }],
  
  // Row 3
  iron_folic_acid_counseled: false,
  iron_folic_acid_date_counseled: '',
  iron_folic_acid_dates: [{
    iron_folic_acid_trimester_practiced: '',
    iron_folic_acid_date_practiced: ''
  }],
  // Row 4
  iodized_salt_counseled: false,
  iodized_salt_date_counseled: '',
  iodized_salt_practiced: '',
  // Row 5
  tetanus_counseled: false,
  tetanus_date_counseled: '',
  doses: [{ tetanus_dose_practiced: '', tetanus_date_practiced: '' }],
  // Row 6
  initiation: 0,
  exclusivity: 0,
  duration: 0,
  dietary_intake: 0,
  personal_willingness: 0,
  family_support: 0,
  initiation_counseled: false,
  exclusivity_counseled: false,
  duration_counseled: false,
  dietary_intake_counseled: false,
  personal_willingness_counseled: false,
  family_support_counseled: false,
  initiation_start_date_practiced: '',
  initiation_end_date_practiced: '',
  exclusivity_start_date_practiced: '',
  exclusivity_end_date_practiced: '',
  duration_start_date_practiced: '',
  duration_end_date_practiced: '',
  // Row 7
  proper_infant: 0,
  nutripak: 0,
  health_nutrition: 0,
  membership: 0,
  plant_malunggay: 0,
  other_interventions: '',
  proper_infant_counseled: false,
  nutripak_counseled: false,
  health_nutrition_counseled: false,
  membership_counseled: false,
  plant_malunggay_counseled: false,
  other_interventions_counseled: false,
  proper_infant_practiced: false,
  nutripak_practiced: 0,
  health_nutrition_practiced: false,
  membership_member_practiced: false,
  membership_leader_practiced: false,
  plant_malunggay_number_practiced: 0,
  date_planted_practiced: '',
  location_practiced: '',
  other_interventions_practiced: false,
  // Row 8
  postnatal_checkup_counseled: false,
  postnatal_checkup_date_counseled: '',
  postnatal_last_checkup_date_practiced: '',
  // Row 9
  iron_supplementation_counseled: false,
  iron_supplementation_date_counseled: '',
  iron_supplementation_last_date_taken_practiced: '',
  iron_supplementation_amount_practiced: 0,
  // Row 10
  breastfeed_initiation_counseled: false,
  breastfeed_initiation_date_counseled: '',
  normal_delivery: 0,
  cs_delivery: 0,
  // Row 11
  given_colostrums: false,
  no_water_given: false,
  no_food_given: false,
  no_vitamins_given: false,
  no_formula_milk_given: false,
  no_other_liquid_given: false,
  exclusive_breastfeed_colostrums_1: '',
  exclusive_breastfeed_colostrums_2: '',
  exclusive_breastfeed_colostrums_3: '',
  exclusive_breastfeed_colostrums_4: '',
  exclusive_breastfeed_colostrums_5: '',
  exclusive_breastfeed_colostrums_6: '',
  exclusive_breastfeed_water_1: '',
  exclusive_breastfeed_water_2: '',
  exclusive_breastfeed_water_3: '',
  exclusive_breastfeed_water_4: '',
  exclusive_breastfeed_water_5: '',
  exclusive_breastfeed_water_6: '',
  exclusive_breastfeed_food_1: '',
  exclusive_breastfeed_food_2: '',
  exclusive_breastfeed_food_3: '',
  exclusive_breastfeed_food_4: '',
  exclusive_breastfeed_food_5: '',
  exclusive_breastfeed_food_6: '',
  exclusive_breastfeed_vitamins_1: '',
  exclusive_breastfeed_vitamins_2: '',
  exclusive_breastfeed_vitamins_3: '',
  exclusive_breastfeed_vitamins_4: '',
  exclusive_breastfeed_vitamins_5: '',
  exclusive_breastfeed_vitamins_6: '',
  exclusive_breastfeed_formula_milk_1: '',
  exclusive_breastfeed_formula_milk_2: '',
  exclusive_breastfeed_formula_milk_3: '',
  exclusive_breastfeed_formula_milk_4: '',
  exclusive_breastfeed_formula_milk_5: '',
  exclusive_breastfeed_formula_milk_6: '',
  exclusive_breastfeed_other_liquid_1: '',
  exclusive_breastfeed_other_liquid_2: '',
  exclusive_breastfeed_other_liquid_3: '',
  exclusive_breastfeed_other_liquid_4: '',
  exclusive_breastfeed_other_liquid_5: '',
  exclusive_breastfeed_other_liquid_6: '',
  // Row 12
  child_sick_counseled: false,
  mother_sick_counseled: false,
  child_sick_practiced: false,
  mother_sick_practiced: false,
  // Row 13
  continue_breastfeed_beyond_2_counseled: false,
  continue_breastfeed_beyond_2_practiced: false,
  // Row 14
  backyard_counseled: false,
  clean_environment_counseled: false,
  sanitary_toilet_counseled: false,
  potable_water_counseled: false,
  backyard_practiced: false,
  clean_environment_practiced: false,
  sanitary_toilet_practiced: false,
  potable_water_practiced: false,
});

const showFlashMessage = ref(false);
const flashMessage = ref('');



const handleSubmit = () => {
  console.log('Submitting form data:', formData.value);
  axios.post(`/pnea/${props.pnea.id}/addOptimumPractice`, { 
    prenatal_care_counseled: formData.value.prenatal_care_counseled,
      prenatal_care_date_counseled: formData.value.prenatal_care_date_counseled,
      prenatal_care_practiced: formData.value.prenatal_care_practiced,
      prenatal_checkup_counseled: formData.value.prenatal_checkup_counseled,
      prenatal_checkup_date_counseled: formData.value.prenatal_checkup_date_counseled,
      prenatal_care_dates: formData.value.prenatal_care_dates,
      iron_folic_acid_counseled: formData.value.iron_folic_acid_counseled,
      iron_folic_acid_date_counseled: formData.value.iron_folic_acid_date_counseled,
      iron_folic_acid_dates: formData.value.iron_folic_acid_dates,
      iodized_salt_counseled: formData.value.iodized_salt_counseled,
      iodized_salt_date_counseled: formData.value.iodized_salt_date_counseled,
      iodized_salt_practiced: formData.value.iodized_salt_practiced,
      tetanus_counseled: formData.value.tetanus_counseled,
      tetanus_date_counseled: formData.value.tetanus_date_counseled,
      doses: formData.value.doses,
      initiation: formData.value.initiation,
      exclusivity: formData.value.exclusivity,
      duration: formData.value.duration,
      dietary_intake: formData.value.dietary_intake,
      personal_willingness: formData.value.personal_willingness,
      family_support: formData.value.family_support,
      initiation_counseled: formData.value.initiation_counseled,
      exclusivity_counseled: formData.value.exclusivity_counseled,
      duration_counseled: formData.value.duration_counseled,
      dietary_intake_counseled: formData.value.dietary_intake_counseled,
      personal_willingness_counseled: formData.value.personal_willingness_counseled,
      family_support_counseled: formData.value.family_support_counseled,
      initiation_start_date_practiced: formData.value.initiation_start_date_practiced,
      initiation_end_date_practiced: formData.value.initiation_end_date_practiced,
      exclusivity_start_date_practiced: formData.value.exclusivity_start_date_practiced,
      exclusivity_end_date_practiced: formData.value.exclusivity_end_date_practiced,
      duration_start_date_practiced: formData.value.duration_start_date_practiced,
      duration_end_date_practiced: formData.value.duration_end_date_practiced,
      proper_infant: formData.value.proper_infant,
      nutripak: formData.value.nutripak,
      health_nutrition: formData.value.health_nutrition,
      membership: formData.value.membership,
      plant_malunggay: formData.value.plant_malunggay,
      other_interventions: formData.value.other_interventions,
      proper_infant_counseled: formData.value.proper_infant_counseled,
      nutripak_counseled: formData.value.nutripak_counseled,
      health_nutrition_counseled: formData.value.health_nutrition_counseled,
      membership_counseled: formData.value.membership_counseled,
      plant_malunggay_counseled: formData.value.plant_malunggay_counseled,
      other_interventions_counseled: formData.value.other_interventions_counseled,
      proper_infant_practiced: formData.value.proper_infant_practiced,
      nutripak_practiced: formData.value.nutripak_practiced,
      health_nutrition_practiced: formData.value.health_nutrition_practiced,
      membership_member_practiced: formData.value.membership_member_practiced,
      membership_leader_practiced: formData.value.membership_leader_practiced,
      plant_malunggay_number_practiced: formData.value.plant_malunggay_number_practiced,
      date_planted_practiced: formData.value.date_planted_practiced,
      location_practiced: formData.value.location_practiced,
      other_interventions_practiced: formData.value.other_interventions_practiced,
      postnatal_checkup_counseled: formData.value.postnatal_checkup_counseled,
      postnatal_checkup_date_counseled: formData.value.postnatal_checkup_date_counseled,
      postnatal_last_checkup_date_practiced: formData.value.postnatal_last_checkup_date_practiced,
      iron_supplementation_counseled: formData.value.iron_supplementation_counseled,
      iron_supplementation_date_counseled: formData.value.iron_supplementation_date_counseled,
      iron_supplementation_last_date_taken_practiced: formData.value.iron_supplementation_last_date_taken_practiced,
      iron_supplementation_amount_practiced: formData.value.iron_supplementation_amount_practiced,
      breastfeed_initiation_counseled: formData.value.breastfeed_initiation_counseled,
      breastfeed_initiation_date_counseled: formData.value.breastfeed_initiation_date_counseled,
      normal_delivery: formData.value.normal_delivery,
      cs_delivery: formData.value.cs_delivery,
      given_colostrums: formData.value.given_colostrums,
      no_water_given: formData.value.no_water_given,
      no_food_given: formData.value.no_food_given,
      no_vitamins_given: formData.value.no_vitamins_given,
      no_formula_milk_given: formData.value.no_formula_milk_given,
      no_other_liquid_given: formData.value.no_other_liquid_given,
      exclusive_breastfeed_colostrums_1: formData.value.exclusive_breastfeed_colostrums_1,
      exclusive_breastfeed_colostrums_2: formData.value.exclusive_breastfeed_colostrums_2,
      exclusive_breastfeed_colostrums_3: formData.value.exclusive_breastfeed_colostrums_3,
      exclusive_breastfeed_colostrums_4: formData.value.exclusive_breastfeed_colostrums_4,
      exclusive_breastfeed_colostrums_5: formData.value.exclusive_breastfeed_colostrums_5,
      exclusive_breastfeed_colostrums_6: formData.value.exclusive_breastfeed_colostrums_6,
      exclusive_breastfeed_water_1: formData.value.exclusive_breastfeed_water_1,
      exclusive_breastfeed_water_2: formData.value.exclusive_breastfeed_water_2,
      exclusive_breastfeed_water_3: formData.value.exclusive_breastfeed_water_3,
      exclusive_breastfeed_water_4: formData.value.exclusive_breastfeed_water_4,
      exclusive_breastfeed_water_5: formData.value.exclusive_breastfeed_water_5,
      exclusive_breastfeed_water_6: formData.value.exclusive_breastfeed_water_6,
      exclusive_breastfeed_food_1: formData.value.exclusive_breastfeed_food_1,
      exclusive_breastfeed_food_2: formData.value.exclusive_breastfeed_food_2,
      exclusive_breastfeed_food_3: formData.value.exclusive_breastfeed_food_3,
      exclusive_breastfeed_food_4: formData.value.exclusive_breastfeed_food_4,
      exclusive_breastfeed_food_5: formData.value.exclusive_breastfeed_food_5,
      exclusive_breastfeed_food_6: formData.value.exclusive_breastfeed_food_6,
      exclusive_breastfeed_vitamins_1: formData.value.exclusive_breastfeed_vitamins_1,
      exclusive_breastfeed_vitamins_2: formData.value.exclusive_breastfeed_vitamins_2,
      exclusive_breastfeed_vitamins_3: formData.value.exclusive_breastfeed_vitamins_3,
      exclusive_breastfeed_vitamins_4: formData.value.exclusive_breastfeed_vitamins_4,
      exclusive_breastfeed_vitamins_5: formData.value.exclusive_breastfeed_vitamins_5,
      exclusive_breastfeed_vitamins_6: formData.value.exclusive_breastfeed_vitamins_6,
      exclusive_breastfeed_formula_milk_1: formData.value.exclusive_breastfeed_formula_milk_1,
      exclusive_breastfeed_formula_milk_2: formData.value.exclusive_breastfeed_formula_milk_2,
      exclusive_breastfeed_formula_milk_3: formData.value.exclusive_breastfeed_formula_milk_3,
      exclusive_breastfeed_formula_milk_4: formData.value.exclusive_breastfeed_formula_milk_4,
      exclusive_breastfeed_formula_milk_5: formData.value.exclusive_breastfeed_formula_milk_5,
      exclusive_breastfeed_formula_milk_6: formData.value.exclusive_breastfeed_formula_milk_6,
      exclusive_breastfeed_other_liquid_1: formData.value.exclusive_breastfeed_other_liquid_1,
      exclusive_breastfeed_other_liquid_2: formData.value.exclusive_breastfeed_other_liquid_2,
      exclusive_breastfeed_other_liquid_3: formData.value.exclusive_breastfeed_other_liquid_3,
      exclusive_breastfeed_other_liquid_4: formData.value.exclusive_breastfeed_other_liquid_4,
      exclusive_breastfeed_other_liquid_5: formData.value.exclusive_breastfeed_other_liquid_5,
      exclusive_breastfeed_other_liquid_6: formData.value.exclusive_breastfeed_other_liquid_6,
      child_sick_counseled: formData.value.child_sick_counseled,
      mother_sick_counseled: formData.value.mother_sick_counseled,
      child_sick_practiced: formData.value.child_sick_practiced,
      mother_sick_practiced: formData.value.mother_sick_practiced,
      continue_breastfeed_beyond_2_counseled: formData.value.continue_breastfeed_beyond_2_counseled,
      continue_breastfeed_beyond_2_practiced: formData.value.continue_breastfeed_beyond_2_practiced,
      backyard_counseled: formData.value.backyard_counseled,
      clean_environment_counseled: formData.value.clean_environment_counseled,
      sanitary_toilet_counseled: formData.value.sanitary_toilet_counseled,
      potable_water_counseled: formData.value.potable_water_counseled,
      backyard_practiced: formData.value.backyard_practiced,
      clean_environment_practiced: formData.value.clean_environment_practiced,
      sanitary_toilet_practiced: formData.value.sanitary_toilet_practiced,
      potable_water_practiced: formData.value.potable_water_practiced,




  })
    .then(response => {
      console.log('Record Added:', response.data);
      flashMessage.value = 'Record added successfully!';
      showFlashMessage.value = true;
      setTimeout(() => (showFlashMessage.value = false), 5000);
      props.pnea.optimum_practice.push(response.data.record);
    })
    .catch(error => {
      console.error('Error adding record:', error);
      flashMessage.value = 'Failed to add record! ' + (error.response?.data?.message || error.message);
      showFlashMessage.value = true;
      setTimeout(() => (showFlashMessage.value = false), 5000);
    });
};

const addTetanusDose = () => {
  formData.value.doses.push({ type: '', date: '' });
};

const removeTetanusDose = (index) => {
  formData.value.doses.splice(index, 1);
};

const adDate = () => {
  formData.value.iron_folic_acid_dates.push({ trimester: '', date: '' });
};

const removDate = (index) => {
  formData.value.iron_folic_acid_dates.splice(index, 1);
};

const addPreNatalCheckUpDate = () => {
  formData.value.prenatal_care_dates.push({ trimester: '', date: '' });
};

const removePreNatalCheckUpDate = (index) => {
  formData.value.prenatal_care_dates.splice(index, 1);
};
</script>

<template>
  <Head title=" | Optimum Practices"/>
  <div class="container">
    <h2 style="text-align: center; color: #1c4e80">Optimum Practices Form</h2>
    <form @submit.prevent="handleSubmit">
      <table class="info-table">
        <thead>
          <tr>
            <th class="col-practices">OPTIMUM PRACTICES</th>
            <th class="col-counseled">Counseled</th>
            <th class="col-practiced">Practiced</th>
          </tr>
        </thead>
        <tbody>
          <!-- Row 1 -->
          <tr>
            <td class="col-practices">1. Pre-natal care provider</td>
            <td class="col-counseled">
              <div class="radio-container">
                <label><input type="radio" v-model="formData.prenatal_care_counseled" value="Yes"> Yes</label>
                <label><input type="radio" v-model="formData.prenatal_care_counseled" value="No"> No </label>
              </div>
              <div v-if="formData.prenatal_care_counseled === 'Yes'">
                <input type="date" class="date-input" v-model="formData.prenatal_care_date_counseled">
              </div>
            </td>
            <td class="col-practiced">
              <div class="data-practiced">
                <select v-model="formData.prenatal_care_practiced" class="dropdown-pre-natals">
                  <option value="Doctor">Private Hospital/Clinic</option>
                  <option value="Midwife">Rural Health Unit</option>
                </select>
              </div>
            </td>
          </tr>

          <!-- Row 2 -->
          <tr>
            <td class="col-practices">2. Pre-natal check up</td>
            <td class="col-counseled">
              <div class="radio-container">
                <label><input type="radio" v-model="formData.prenatal_checkup_counseled" value="Yes"> Yes</label>
                <label><input type="radio" v-model="formData.prenatal_checkup_counseled" value="No"> No</label>
              </div>
              <div v-if="formData.prenatal_checkup_counseled === 'Yes'">
                <input type="date" class="date-input" v-model="formData.prenatal_checkup_date_counseled">
              </div>
            </td>
            <td class="col-practiced">
              <table class="nested-table">
                <thead>
                  <tr class="data-headers">
                    <th>Trimester</th>
                    <th>Date</th>
                    <th class="add-date">
                      <button type="button" @click="addPreNatalCheckUpDate" class="icon-button">
                        <i class="fas fa-plus-circle"></i>
                      </button>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(date, index) in formData.prenatal_care_dates" :key="'preNatal-' + index">
                    <td>
                      <select v-model="date.prenatal_checkup_trimester_practiced" class="dropdown-pre-natal">
                        <option value="First Trimester">First Trimester</option>
                        <option value="Second Trimester">Second Trimester</option>
                        <option value="Third Trimester">Third Trimester</option>
                      </select>
                    </td>
                    <td><input class="date-input" type="date" v-model="date.prenatal_checkup_date_practiced"></td>
                    <td v-if="index !== 0">
                      <button type="button" @click="removePreNatalCheckUpDate(index)" class="icon-button">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>

          <!-- Row 3 -->
          <tr>
            <td class="col-practices">3. Iron Folic Acid Supplementation</td>
            <td class="col-counseled">
              <div class="radio-container">
                <label><input type="radio" v-model="formData.iron_folic_acid_counseled" value="Yes"> Yes</label>
                <label><input type="radio" v-model="formData.iron_folic_acid_counseled" value="No"> No</label>
              </div>
              <div v-if="formData.iron_folic_acid_counseled === 'Yes'">
                <input type="date" class="date-input" v-model="formData.iron_folic_acid_date_counseled">
              </div>
            </td>
            <td class="col-practiced">
              <table class="nested-table">
                <thead>
                  <tr>
                    <th>Trimester</th>
                    <th>Date</th>
                    <th class="add-date">
                      <button type="button" @click="adDate" class="icon-button">
                        <i class="fas fa-plus-circle"></i>
                      </button>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(date, index) in formData.iron_folic_acid_dates" :key="'iron-' + index">
                    <td>
                      <select v-model="date.iron_folic_acid_trimester_practiced" class="dropdown-pre-natal">
                        <option value="First Trimester">First Trimester</option>
                        <option value="Second Trimester">Second Trimester</option>
                        <option value="Third Trimester">Third Trimester</option>
                      </select>
                    </td>
                    <td><input class="date-input" type="date" v-model="date.iron_folic_acid_date_practiced"></td>
                    <td v-if="index !== 0">
                      <button type="button" @click="removDate(index)" class="icon-button">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>

          <!-- Row 4 -->
          <tr>
            <td class="col-practices">4. Iodized Salt Utilization</td>
            <td class="col-counseled">
              <div class="radio-container">
                <label><input type="radio" v-model="formData.iodized_salt_counseled" value="Yes"> Yes</label>
                <label><input type="radio" v-model="formData.iodized_salt_counseled" value="No"> No</label>
              </div>
              <div v-if="formData.iodized_salt_counseled === 'Yes'">
                <input type="date" class="date-input" v-model="formData.iodized_salt_date_counseled">
              </div>
            </td>
            <td class="col-practiced">
              <label>Date Tested</label>
              <input class="date-tested" type="date" v-model="formData.iodized_salt_practiced">
            </td>
          </tr>

          <!-- Row 5 -->
          <tr>
            <td class="col-practices">5. With Tetanus Toxoid vaccination</td>
            <td class="col-counseled">
              <div class="radio-container">
                <label><input type="radio" v-model="formData.tetanus_counseled" value="Yes"> Yes</label>
                <label><input type="radio" v-model="formData.tetanus_counseled" value="No"> No</label>
              </div>
              <div v-if="formData.tetanus_counseled === 'Yes'">
                <input type="date" class="date-input" v-model="formData.tetanus_date_counseled">
              </div>
            </td>
            <td class="col-practiced">
              <table class="nested-table">
                <thead>
                  <tr>
                    <th>Dose</th>
                    <th>Date</th>
                    <th class="add-date">
                      <button type="button" @click="addTetanusDose" class="icon-button">
                        <i class="fas fa-plus-circle"></i>
                      </button>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(dose, index) in formData.doses" :key="'dose-' + index">
                    <td>
                      <select v-model="dose.tetanus_dose_practiced" class="dropdown-tetanus">
                        <option value="First Dose">First Dose</option>
                        <option value="Second Dose">Second Dose</option>
                        <option value="Third Dose">Third Dose</option>
                        <option value="Fourth Dose">Fourth Dose</option>
                        <option value="Fifth Dose">Fifth Dose</option>
                      </select>
                    </td>
                    <td><input class="date-input" type="date" v-model="dose.tetanus_date_practiced"></td>
                    <td v-if="index !== 0">
                      <button type="button" @click="removeTetanusDose(index)" class="icon-button">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>

          <!-- Row 6 -->
          <tr>
            <td class="col-practices">6. Preparation for breastfeed
              <table class="checkbox-container">
                <tr><td><input type="checkbox" v-model="formData.initiation" value="Yes"> Initiation (at least 30 min after delivery)</td></tr>
                <tr><td><input type="checkbox" v-model="formData.exclusivity" value="Yes"> Exclusivity (0-6 months)</td></tr>
                <tr><td><input type="checkbox" v-model="formData.duration" value="Yes"> Duration (at least 2 years)</td></tr>
                <tr><td><input type="checkbox" v-model="formData.dietary_intake" value="Yes"> Dietary Intake (Balanced and Adequacy)</td></tr>
                <tr><td><input type="checkbox" v-model="formData.personal_willingness" value="Yes"> Personal Willingness/Interest to Breastfeed</td></tr>
                <tr><td><input type="checkbox" v-model="formData.family_support" value="Yes"> Family Support (Husband and Parents)</td></tr>
              </table>
            </td>
            <td class="col-counseled">
              <table class="checkbox-counseled">
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="formData.initiation_counseled" value="Yes"> Yes</label>
                      <label><input type="radio" v-model="formData.initiation_counseled" value="No"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="formData.exclusivity_counseled" value="Yes"> Yes</label>
                      <label><input type="radio" v-model="formData.exclusivity_counseled" value="No"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="formData.duration_counseled" value="Yes"> Yes</label>
                      <label><input type="radio" v-model="formData.duration_counseled" value="No"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="formData.dietary_intake_counseled" value="Yes"> Yes</label>
                      <label><input type="radio" v-model="formData.dietary_intake_counseled" value="No"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="formData.personal_willingness_counseled" value="Yes"> Yes</label>
                      <label><input type="radio" v-model="formData.personal_willingness_counseled" value="No"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="formData.family_support_counseled" value="Yes"> Yes</label>
                      <label><input type="radio" v-model="formData.family_support_counseled" value="No"> No</label>
                    </div>
                  </td>
                </tr>
              </table>
            </td>
            <td class="col-practiced">
              <table class="nested-table">
                <thead>
                  <tr>
                    <th class="blank"></th>
                    <th class="header-input-2">Date/Time Started</th>
                    <th class="header-input-2">Date/Time Ended</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Initiation</td>
                    <td><input type="datetime-local" class="datetime-local" v-model="formData.initiation_start_date_practiced"></td>
                    <td><input type="datetime-local" class="datetime-local" v-model="formData.initiation_end_date_practiced"></td>
                  </tr>
                  <tr>
                    <td>Exclusivity</td>
                    <td><input type="datetime-local" class="datetime-local" v-model="formData.exclusivity_start_date_practiced"></td>
                    <td><input type="datetime-local" class="datetime-local" v-model="formData.exclusivity_end_date_practiced"></td>
                  </tr>
                  <tr>
                    <td>Duration</td>
                    <td><input type="datetime-local" class="datetime-local" v-model="formData.duration_start_date_practiced"></td>
                    <td><input type="datetime-local" class="datetime-local" v-model="formData.duration_end_date_practiced"></td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>

          <!-- Row 7 -->
          <tr>
            <td class="col-practices">7. Attendance to Nutrition Interventions
              <table class="checkbox-container">
                <tr><td><input type="checkbox" v-model="formData.proper_infant" value="Yes"> Proper Infant and Young Child Feeding</td></tr>
                <tr><td><input type="checkbox" v-model="formData.nutripak" value="Yes"> NUTRIPAK Utilization</td></tr>
                <tr><td><input type="checkbox" v-model="formData.health_nutrition" value="Yes"> Health, Nutrition, and Food Safety</td></tr>
                <tr><td><input type="checkbox" v-model="formData.membership" value="Yes"> Membership in Peer Counseling Group</td></tr>
                <tr><td><input type="checkbox" v-model="formData.plant_malunggay" value="Yes"> "Plant-A-Malunggay Project"</td></tr> 
                <tr><td><label>Other Interventions, specify<input type="text" v-model="formData.other_interventions" placeholder="Please specify"></label></td></tr> 
              </table>
            </td>

            <td class="col-counseled">
              <table class="checkbox-counseled">
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="formData.proper_infant_counseled" value="Yes"> Yes</label>
                      <label><input type="radio" v-model="formData.proper_infant_counseled" value="No"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="formData.nutripak_counseled" value="Yes"> Yes</label>
                      <label><input type="radio" v-model="formData.nutripak_counseled" value="No"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="formData.health_nutrition_counseled" value="Yes"> Yes</label>
                      <label><input type="radio" v-model="formData.health_nutrition_counseled" value="No"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="formData.membership_counseled" value="Yes"> Yes</label>
                      <label><input type="radio" v-model="formData.membership_counseled" value="No"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="formData.plant_malunggay_counseled" value="Yes"> Yes</label>
                      <label><input type="radio" v-model="formData.plant_malunggay_counseled" value="No"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="formData.other_interventions_counseled" value="Yes"> Yes</label>
                      <label><input type="radio" v-model="formData.other_interventions_counseled" value="No"> No</label>
                    </div>
                  </td>
                </tr>
              </table>
            </td>

            <td class="col-practiced">
              <table class="nested-table-2">
                <thead>
                  <tr>
                    <th class="blank-2 small-header"></th>
                    <th class="small-header">Details</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="small-row">
                    <td></td>
                    <td>
                      <div class="radio-container">
                        <label><input type="radio" v-model="formData.proper_infant" value="Yes"> Yes</label>
                        <label><input type="radio" v-model="formData.proper_infant" value="No"> No</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>No. of recipes cooked with NUTRIPAK</td>
                    <td>
                      <input type="number" class="nutripak-number" v-model="formData.nutripak">
                    </td>
                  </tr>
                  <tr class="small-row">
                    <td></td>
                    <td>
                      <div class="radio-container">
                        <label><input type="radio" v-model="formData.health_nutrition" value="Yes"> Yes</label>
                        <label><input type="radio" v-model="formData.health_nutrition" value="No"> No</label>
                      </div>
                    </td>
                  </tr>
                  <tr class="small-row">
                    <td></td>
                    <td>
                      <div class="radio-container">
                        <p class="row7-radio">Member: </p>
                        <label><input type="radio" v-model="formData.membership_member_practiced" value="Yes"> Yes</label>
                        <label><input type="radio" v-model="formData.membership_member_practiced" value="No"> No</label>
                      </div>
                      <div class="radio-container">
                        <p class="row7-radio">Leader: </p>
                        <label><input type="radio" v-model="formData.membership_leader_practiced" value="Yes"> Yes</label>
                        <label><input type="radio" v-model="formData.membership_leader_practiced" value="No"> No</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>No. of Malunggay Trees Planted </td>
                    <td>
                      <input type="number" class="nutripak-number" v-model="formData.plant_malunggay_number_practiced">
                    </td>
                  </tr>
                  <tr>
                    <td>Date Planted</td>
                    <td>
                      <input type="date" class="date-input-planted" v-model="formData.date_planted_practiced">
                    </td>
                  </tr>
                  <tr>
                    <td>Location</td>
                    <td>
                      <div class="location-container">
                        <input type="text" class="date-input-location" v-model="formData.location_practiced">
                      </div>
                    </td>
                  </tr>
                  <tr class="small-row">
                    <td></td>
                    <td>
                      <div class="radio-container">
                        <label><input type="radio" v-model="formData.other_interventions_practiced" value="Yes"> Yes</label>
                        <label><input type="radio" v-model="formData.other_interventions_practiced" value="No"> No</label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>

          <!-- Row 8 -->
          <tr>
            <td class="col-practices">8. Undergo post-natal check up</td>
            <td class="col-counseled">
              <div class="radio-container">
                <label><input type="radio" v-model="formData.postnatal_checkup_counseled" value="Yes"> Yes</label>
                <label><input type="radio" v-model="formData.postnatal_checkup_counseled" value="No"> No </label>
              </div>
              <div v-if="formData.counseled === 'Yes'">
                <input type="date" class="date-input" v-model="formData.postnatal_checkup_date_counseled">
              </div>
            </td>
            <td class="col-practiced">
              <div class="data-practiced">
                <label>Date of last check up <input type="date" class="date-input-8" v-model="formData.postnatal_last_checkup_date_practiced"></label>
              </div>
            </td>
          </tr>
        <!-- Row 9 -->
        <tr>
            <td class="col-practices">9. Iron Supplementation</td>
            <td class="col-counseled">
              <div class="radio-container">
                <label><input type="radio" v-model="formData.iron_supplementation_counseled" value="Yes"> Yes</label>
                <label><input type="radio" v-model="formData.iron_supplementation_counseled" value="No"> No </label>
              </div>
              <div v-if="formData.counseled === 'Yes'">
                <input type="date" class="date-input" v-model="formData.iron_supplementation_date_counseled">
              </div>
            </td>
            <td class="col-practiced">
              <table class="nested-table">
                <thead>
                  <tr>
                    <th>Amount intake per month</th>
                    <th>Date of last taken</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input type="text" class="amount-intake" v-model="formData.iron_supplementation_amount_practiced"></td>
                    <td><input type="date" class="date-input" v-model="formData.iron_supplementation_last_date_taken_practiced"></td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>

          <!-- Row 10 -->
            <tr>
                <td class="col-practices">10. breastfeed Initiation</td>
                <td class="col-counseled">
                <div class="radio-container">
                    <label><input type="radio" v-model="formData.breastfeed_initiation_counseled" value="Yes"> Yes</label>
                    <label><input type="radio" v-model="formData.breastfeed_initiation_counseled" value="No"> No </label>
                </div>
                <div v-if="formData.breastfeed_initiation_counseled === 'Yes'">
                    <input type="date" class="date-input" v-model="formData.breastfeed_initiation_date_counseled">
                </div>
                </td>
                <td class="col-practiced">
                <div class="data-practiced">
                    <label><input type="checkbox" class="data-row-11" v-model="formData.normal_delivery" value="Yes"> Normal Delivery (within half an hour)</label>
                    <label><input type="checkbox" class="data-row-11" v-model="formData.cs_delivery" value="Yes"> Caesarian Delivery (within 3 hour)</label>
                </div>
                </td>
            </tr>

            <!-- Row 11 -->
            <tr>
                <td class="col-practices">11. Exclusive breastfeed (0-6 months)
                    <table class="checkbox-container">
                        <tr><td><label>1. Given colostrums to the newborn</label></td></tr>
                        <tr><td><label>2. No water given</label></td></tr>
                        <tr><td><label>3. No food given</label></td></tr>
                        <tr><td><label>4. No vitamins given</label></td></tr>
                        <tr><td><label>5. No other formula milk given</label></td></tr>
                        <tr><td><label>6. No other liquid</label></td></tr>
                    </table>
                </td>
                <td class="col-counseled">
                    <table class="checkbox-counseled">
                        <tr>
                        <td>
                            <div class="radio-container">
                            <label><input type="radio" v-model="formData.given_colostrums" value="Yes"> Yes</label>
                            <label><input type="radio" v-model="formData.given_colostrums" value="No"> No</label>
                            </div>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="radio-container">
                            <label><input type="radio" v-model="formData.no_water_given" value="Yes"> Yes</label>
                            <label><input type="radio" v-model="formData.no_water_given" value="No"> No</label>
                            </div>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="radio-container">
                            <label><input type="radio" v-model="formData.no_food_given" value="Yes"> Yes</label>
                            <label><input type="radio" v-model="formData.no_food_given" value="No"> No</label>
                            </div>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="radio-container">
                            <label><input type="radio" v-model="formData.	no_vitamins_given" value="Yes"> Yes</label>
                            <label><input type="radio" v-model="formData.	no_vitamins_given" value="No"> No</label>
                            </div>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="radio-container">
                            <label><input type="radio" v-model="formData.no_formula_milk_given" value="Yes"> Yes</label>
                            <label><input type="radio" v-model="formData.no_formula_milk_given" value="No"> No</label>
                            </div>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="radio-container">
                            <label><input type="radio" v-model="formData.	no_other_liquid_given" value="Yes"> Yes</label>
                            <label><input type="radio" v-model="formData.	no_other_liquid_given" value="No"> No</label>
                            </div>
                        </td>
                        </tr>
                    </table>
                </td>
                <td class="col-practiced">
                    <table class="row-12-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>1st</th>
                                <th>2nd</th>
                                <th>3rd</th>
                                <th>4th</th>
                                <th>5th</th>
                                <th>6th</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_colostrums_1">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_colostrums_2">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_colostrums_3">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_colostrums_4">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_colostrums_5">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_colostrums_6">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_water_1">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_water_2">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_water_3">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_water_4">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_water_5">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_water_6">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_food_1">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_food_2">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_food_3">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_food_4">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_food_5">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_food_6">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_vitamins_1">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_vitamins_2">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_vitamins_3">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_vitamins_4">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_vitamins_5">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_vitamins_6">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_formula_milk_1">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_formula_milk_2">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_formula_milk_3">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_formula_milk_4">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_formula_milk_5">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_formula_milk_6">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_other_liquid_1">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_other_liquid_2">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_other_liquid_3">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_other_liquid_4">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_other_liquid_5">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="formData.exclusive_breastfeed_other_liquid_6">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <!-- Row 12 -->
             <tr>
                <td class="col-practices">12. Continue breastfeed even:
                    <table class="checkbox-container">
                        <tr><td><label>1. When child is sick</label></td></tr>
                        <tr><td><label>2. When mother is sick</label></td></tr>
                    </table>
                </td>
                <td class="col-counseled">
                    <table class="checkbox-counseled">
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.child_sick_counseled" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.mother_sick_counseled" value="No"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.child_sick_counseled" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.mother_sick_counseled" value="No"> No</label>
                                </div>
                            </td>
                        </tr>
                    </table>

                </td>
                <td class="col-practiced">
                    <table class="checkbox-counseled">
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.child_sick_practiced" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.child_sick_practiced" value="No"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.mother_sick_practiced" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.mother_sick_practiced" value="No"> No</label>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Row 13 -->
            <tr>
                <td class="col-practices">13. Continue breastfeed even beyond 2 years old:
                    <table class="checkbox-container">
                        <tr><td><label>(before and after giving complementary food)</label></td></tr>
                    </table>
                </td>
                <td class="col-counseled">
                    <table class="checkbox-counseled">
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.continue_breastfeed_beyond_2_counseled" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.continue_breastfeed_beyond_2_counseled" value="No"> No</label>
                                </div>
                            </td>
                        </tr>
                    </table>

                </td>
                <td class="col-practiced">
                    <table class="checkbox-counseled">
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.continue_breastfeed_beyond_2_practiced" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.continue_breastfeed_beyond_2_practiced" value="No"> No</label>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Row 14 -->
            <tr>
                <td class="col-practices">14. Health Sanitation/Food Availability:
                    <table class="checkbox-container">
                        <tr><td><label> 1. Backyard Gardening</label></td></tr>
                        <tr><td><label> 2. Clean Environment</label></td></tr>
                        <tr><td><label> 3. With Sanitary Toilet</label></td></tr>
                        <tr><td><label> 4. With Potable Water</label></td></tr>                 
                    </table>
                </td>
                <td class="col-counseled">
                    <table class="checkbox-counseled">
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.backyard_gardening_counseled" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.backyard_gardening_counseled" value="No"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.clean_environment_counseled" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.clean_environment_counseled" value="No"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.sanitary_counseled" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.sanitary_counseled" value="No"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.potable_water_counseled" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.potable_water_counseled" value="No"> No</label>
                                </div>
                            </td>
                        </tr>
                    </table>

                </td>
                <td class="col-practiced">
                    <table class="checkbox-counseled">
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.backyard_gardening_practiced" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.backyard_gardening_practiced" value="No"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.clean_environment_practiced" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.clean_environment_practiced" value="No"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.sanitary_practiced" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.sanitary_practiced" value="No"> No</label>
                                </div>
                            </td>   
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="formData.potable_water_practiced" value="Yes"> Yes</label>
                                <label><input type="radio" v-model="formData.potable_water_practiced" value="No"> No</label>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Up remove -->
        </tbody>
      </table>
        <div class="form-row-buttons">
            <button type="button" @click="redirectToDashboard" class="cancel-button">Cancel</button>
            <button type="submit" class="save-button">Save</button>
        </div>
    </form>
  </div>
</template>

<style scoped>
h2 {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

.save-button {
    display: block;
    padding: 8px 5px;
    margin-top: 5%;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 20%;
    font-size: 16px;
    transition: background-color 0.3s;
}

.cancel-button {
    background-color: #dc3545;
    display: block;
    padding: 8px 5px;
    margin-top: 5%;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 20%;
    font-size: 16px;
    transition: background-color 0.3s;
}

.save-button:hover {
    background-color: #0056b3;
}

.cancel-button:hover {
    background-color: #c82333;
}
.form-row-buttons {
    display: flex;
    justify-content: space-between;
}
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
  width: 100%;
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
  color: #333;
}
.info-table tr:hover {
  background-color: #f1f1f1;
}
.nested-table {
  width: 100%;
  border-collapse: collapse;
}
.nested-table-2 {
  width: 100%;
  border-collapse: collapse;
}
.row-12-table{
    width: 100%;
    border-collapse: collapse;
}
.row-12-table thead th {
  background-color: #f9f9f9;
  color: #333;
  padding: 0;
  margin: 0;
  text-align: center;
  font-weight: bold;
  border: 1px solid #ddd; 
}
.nested-table thead th {
  background-color: #f9f9f9;
  color: #333;
  padding: 0;
  margin: 0;
  text-align: center;
  font-weight: bold;
  border: 1px solid #ddd; 
}
.nested-table-2 thead th {
  background-color: #f9f9f9;
  color: #333;
  padding: 0;
  margin: 0;
  text-align: center;
  font-weight: bold;
  border: 1px solid #ddd; 
  width: 10%;
}
.add-date{
  width: 8%;
}
.nested-table td {
  border: 1px solid #ddd;
  padding: 5px;
  font-style: normal;
  text-align: center;
}
.nested-table-2 td {
  border: 1px solid #ddd;
  padding: 5px;
  font-style: normal;
  text-align: left;
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
  z-index: 1001;
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
.checkbox-container tr td{
  white-space: normal;
  word-wrap: break-word;
  font-style: normal;
  font-weight: normal;
  padding: 4px;
  padding-left: 10px;
  border: none;
  /* background-color: red; */
}
.checkbox-counseled tr td{
  white-space: normal;
  font-style: normal;
  font-weight: normal;
  padding: 8px;
  padding-left: 10px;
  border: none;

}
.checkbox-counseled {
  table-layout: fixed; 
  width: 100%;
}
.info-table thead th.col-practices {
  width:23%;
  border-right: 1px solid #ddd;
}
.info-table thead th.col-counseled {
  width: 10%;
  border-right: 1px solid #ddd;
}
.info-table thead th.col-practiced {
  width: 30%;
}
.info-table td.col-practices {
  width: 35%;
  border-right: 1px solid #ddd;
  white-space: normal; /* Allow text wrapping */
  word-wrap: break-word; /* Break long words */
}
.info-table td.col-counseled {
  width: 25%;
  border-right: 1px solid #ddd;
  text-align: center;
}
.info-table td.col-practiced {
  width: 15%;
  text-align: center;
}
.info-table th.col-practiced {
  width: 15%;
  text-align: center;
}
.blank{
  width: 20%;
}
.dropdown {
  width: 90%;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
  font-size: 14px;
  font-weight: normal; 
}
.dropdown-pre-natal {
  width: 90%;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
  font-size: 14px;
  font-weight: normal;
  text-align: center;
}
.dropdown-pre-natals{
  width: 50%;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
  font-size: 14px;
  font-weight: normal;
  text-align: center;
}
.date-input {
  width: 90%;
  text-align: center;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
  font-size: 14px;
  font-weight: normal;
}
.date-input-8 {
  width: 50%;
  margin-left:20px;
  text-align: center;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
  font-size: 14px;
  font-weight: normal;
}
.amount-intake{
    position: flex;
    width: 100%;
}
.date-input-planted {
  width: 100%;
  text-align: center;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
  font-size: 14px;
  font-weight: normal;
}
.date-input-location {
  width: 100%;
  text-align: left;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
  font-size: 14px;
  font-weight: normal;
  margin-left: 5px;
}
.date-tested{
  width: 30%;
  text-align: center;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
  font-size: 14px;
  font-weight: normal;
}
.datetime-local{
  width: 100%;
  text-align: center;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
  font-size: 14px;
  font-weight: normal;
}
.header-input{
  text-align: center;
  width: 10%;
  font-weight: bold;
}
.header-input-2{
  height: 40px;
}
.icon-button {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 18px;
  color: #007bff;
  padding: 5px;
  transition: color 0.3s ease;
}

.icon-button:hover {
  color: #0056b3;
}
.dropdown-tetanus {
  width: 90%;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
  font-size: 14px;
  font-weight: normal;
  text-align: center;
}
.nutripak-number{
  width:100%;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
  font-size: 14px;
  font-weight: normal;
  text-align: center;
}
.info-table, .nested-table {
  table-layout: fixed;
  width: 100%;
}

.info-table th, .info-table td, .nested-table th, .nested-table td {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.radio-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}
.row7-radio{
  margin-right: 10px;
}
.location-container {
  margin-top: 3px;
  display: flex;
  align-items: center;
}
.blank-2{
  width: 20%;
}
.info-table td, .nested-table td, .nested-table-2 td {
  text-transform: none;
}
.nested-table-2 td {
  text-align: left;
  width: 20%;
  white-space: normal; 
  word-wrap: break-word; 
}
.small-header {
  font-size: 14px;
  padding: 5px;
  width: 10px;
}

.small-row td {
  font-size: 14px;
  padding: 5px;
}
</style>