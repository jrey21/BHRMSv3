<script setup>
import { useForm } from '@inertiajs/vue3';
import FormLayout from '../../Layouts/FormLayout.vue';
import { ref, watch } from 'vue';

defineOptions({ layout: FormLayout });

const form = useForm({
    pinkCardNumber: null,
    date: null,
    zone: null,
    fullName: null,
    birth_date: null,
    age: null,
    education: null,
    occupation: null,
    term_of_pregnancy: null,
    number_of_pregnancy: null,
    date_last_delivery: null,
    number_of_children: null,
    interval_of_delivery: null,
    muac: null,
    height: null,
    weight: null,
    bmi: null,
    ns: null,
    name_of_husband: null,
    husband_age: null,
    husband_education: null,
    husband_occupation: null,
    monthly_family_income: null,
    household_size: null,
      // Row 1
  prenatal_care_counseled: false,
  prenatal_care_date_counseled: null,
  prenatal_care_practiced: null,
  // Row 2
  prenatal_checkup_counseled: false,
  prenatal_checkup_date_counseled: null,
  prenatal_care_date_1: null,
  prenatal_care_date_2: null,
  prenatal_care_date_3: null,
  prenatal_care_date_4: null,
  prenatal_care_date_5: null,
  prenatal_care_date_6: null, 
  prenatal_care_date_7: null,
  prenatal_care_date_8: null,
  prenatal_care_date_9: null,
  
  // Row 3
  iron_folic_acid_counseled: false,
  iron_folic_acid_date_counseled: null,
  iron_folic_acid_date_1: null,
  iron_folic_acid_date_2: null,
  iron_folic_acid_date_3: null,
  iron_folic_acid_date_4: null,
  iron_folic_acid_date_5: null,
  iron_folic_acid_date_6: null,
  iron_folic_acid_date_7: null,
  iron_folic_acid_date_8: null,
  iron_folic_acid_date_9: null,

  // Row 4
  iodized_salt_counseled: null,
  iodized_salt_date_counseled: null,
  iodized_salt_practiced: null,
  // Row 5
  tetanus_counseled: false,
  tetanus_date_counseled: null,
  dose_date_1: null,
  dose_date_2: null,
  dose_date_3: null,
  dose_date_4: null,
  dose_date_5: null,

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
  initiation_start_date_practiced: null,
  initiation_end_date_practiced: null,
  exclusivity_start_date_practiced: null,
  exclusivity_end_date_practiced: null,
  duration_start_date_practiced: null,
  duration_end_date_practiced: null,
  // Row 7
  proper_infant: 0,
  nutripak: 0,
  health_nutrition: 0,
  membership: 0,
  plant_malunggay: 0,
  other_interventions: null,
  proper_infant_counseled: null,
  nutripak_counseled: null,
  health_nutrition_counseled: null,
  membership_counseled: null,
  plant_malunggay_counseled: null,
  other_interventions_counseled: null,
  proper_infant_practiced: 0,
  nutripak_practiced: 0,
  health_nutrition_practiced: 0,
  membership_member_practiced: false,
  membership_leader_practiced: false,
  plant_malunggay_number_practiced: 0,
  date_planted_practiced: null,
  location_practiced: null,
  other_interventions_practiced: false,
  // Row 8
  postnatal_checkup_counseled: null,
  postnatal_checkup_date_counseled: null,
  postnatal_last_checkup_date_practiced: null,
  // Row 9
  iron_supplementation_counseled: null,
  iron_supplementation_date_counseled: null,
  iron_supplementation_last_date_taken_practiced: null,
  iron_supplementation_amount_practiced: 0,
  // Row 10
  breastfeed_initiation_counseled: null,
  breastfeed_initiation_date_counseled: null,
  normal_delivery: 0,
  cs_delivery: 0,
  // Row 11
  given_colostrums: null,
  no_water_given: null,
  no_food_given: null,
  no_vitamins_given: null,
  no_formula_milk_given: null,
  no_other_liquid_given: null,
  exclusive_breastfeed_colostrums_1: null,
  exclusive_breastfeed_colostrums_2: null,
  exclusive_breastfeed_colostrums_3: null,
  exclusive_breastfeed_colostrums_4: null,
  exclusive_breastfeed_colostrums_5: null,
  exclusive_breastfeed_colostrums_6: null,
  exclusive_breastfeed_water_1: null,
  exclusive_breastfeed_water_2: null,
  exclusive_breastfeed_water_3: null,
  exclusive_breastfeed_water_4: null,
  exclusive_breastfeed_water_5: null,
  exclusive_breastfeed_water_6: null,
  exclusive_breastfeed_food_1: null,
  exclusive_breastfeed_food_2: null,
  exclusive_breastfeed_food_3: null,
  exclusive_breastfeed_food_4: null,
  exclusive_breastfeed_food_5: null,
  exclusive_breastfeed_food_6: null,
  exclusive_breastfeed_vitamins_1: null,
  exclusive_breastfeed_vitamins_2: null,
  exclusive_breastfeed_vitamins_3: null,
  exclusive_breastfeed_vitamins_4: null,
  exclusive_breastfeed_vitamins_5: null,
  exclusive_breastfeed_vitamins_6: null,
  exclusive_breastfeed_formula_milk_1: null,
  exclusive_breastfeed_formula_milk_2: null,
  exclusive_breastfeed_formula_milk_3: null,
  exclusive_breastfeed_formula_milk_4: null,
  exclusive_breastfeed_formula_milk_5: null,
  exclusive_breastfeed_formula_milk_6: null,
  exclusive_breastfeed_other_liquid_1: null,
  exclusive_breastfeed_other_liquid_2: null,
  exclusive_breastfeed_other_liquid_3: null,
  exclusive_breastfeed_other_liquid_4: null,
  exclusive_breastfeed_other_liquid_5: null,
  exclusive_breastfeed_other_liquid_6: null,
  // Row 12
  child_sick_counseled: null,
  mother_sick_counseled: null,
  child_sick_practiced: null,
  mother_sick_practiced: null,
  // Row 13
  continue_breastfeed_beyond_2_counseled: null,
  continue_breastfeed_beyond_2_practiced: null,
  // Row 14
  backyard_counseled: null,
  clean_environment_counseled: null,
  sanitary_toilet_counseled: null,
  potable_water_counseled: null,
  backyard_practiced: null,
  clean_environment_practiced: null,
  sanitary_toilet_practiced: null,
  potable_water_practiced: null,
});

const showModal = ref(false);
const modalMessage = ref('');
const modalTitle = ref('');
const showCancelModal = ref(false);
const cancelMessage = ref('Do you really want to cancel?');
const formSubmittedSuccessfully = ref(false);

const flashMessage = (message, type) => {
    const flash = document.createElement('div');
    flash.className = `flash-message ${type}`;
    flash.innerText = message;
    document.body.appendChild(flash);
    setTimeout(() => flash.remove(), 3000);
};

const submit = () => {
    // Normalize boolean fields
    form.prenatal_care_counseled = form.prenatal_care_counseled === 'yes';
    form.prenatal_checkup_counseled = form.prenatal_checkup_counseled === 'yes';
    form.iron_folic_acid_counseled = form.iron_folic_acid_counseled === 'yes';
    form.iodized_salt_counseled = form.iodized_salt_counseled === 'yes';
    form.tetanus_counseled = form.tetanus_counseled === 'yes';
    form.initiation = form.initiation === 'yes' ? 1 : 0;
    form.exclusivity = form.exclusivity === 'yes' ? 1 : 0;
    form.duration = form.duration === 'yes' ? 1 : 0;
    form.dietary_intake = form.dietary_intake === 'yes' ? 1 : 0;
    form.personal_willingness = form.personal_willingness === 'yes' ? 1 : 0;
    form.family_support = form.family_support === 'yes' ? 1 : 0;
    form.initiation_counseled = form.initiation_counseled === 'yes';
    form.exclusivity_counseled = form.exclusivity_counseled === 'yes';
    form.duration_counseled = form.duration_counseled === 'yes';
    form.dietary_intake_counseled = form.dietary_intake_counseled === 'yes';
    form.personal_willingness_counseled = form.personal_willingness_counseled === 'yes';
    form.family_support_counseled = form.family_support_counseled === 'yes';
    form.postnatal_checkup_counseled = form.postnatal_checkup_counseled === 'yes';
    form.iron_supplementation_counseled = form.iron_supplementation_counseled === 'yes';
    form.breastfeed_initiation_counseled = form.breastfeed_initiation_counseled === 'yes';
    form.child_sick_counseled = form.child_sick_counseled === 'yes';
    form.mother_sick_counseled = form.mother_sick_counseled === 'yes';
    form.continue_breastfeed_beyond_2_counseled = form.continue_breastfeed_beyond_2_counseled === 'yes';
    form.backyard_counseled = form.backyard_counseled === 'yes';
    form.clean_environment_counseled = form.clean_environment_counseled === 'yes';
    form.sanitary_toilet_counseled = form.sanitary_toilet_counseled === 'yes';
    form.potable_water_counseled = form.potable_water_counseled === 'yes';
    form.proper_infant_counseled = form.proper_infant_counseled === 'yes';
    form.nutripak_counseled = form.nutripak_counseled === 'yes';
    form.health_nutrition_counseled = form.health_nutrition_counseled === 'yes';
    form.membership_counseled = form.membership_counseled === 'yes';
    form.plant_malunggay_counseled = form.plant_malunggay_counseled === 'yes';
    form.other_interventions_counseled = form.other_interventions_counseled === 'yes';
    form.given_colostrums = form.given_colostrums === 'yes';
    form.no_water_given = form.no_water_given === 'yes';
    form.no_food_given = form.no_food_given === 'yes';
    form.no_vitamins_given = form.no_vitamins_given === 'yes';
    form.no_formula_milk_given = form.no_formula_milk_given === 'yes';
    form.no_other_liquid_given = form.no_other_liquid_given === 'yes';
    form.child_sick_practiced = form.child_sick_practiced === 'yes';
    form.mother_sick_practiced = form.mother_sick_practiced === 'yes';
    form.continue_breastfeed_beyond_2_practiced = form.continue_breastfeed_beyond_2_practiced === 'yes';
    form.clean_environment_practiced = form.clean_environment_practiced === 'yes';
    form.potable_water_practiced = form.potable_water_practiced === 'yes';
    form.proper_infant_practiced = form.proper_infant_practiced === 'yes' ? 1 : 0;
    form.membership_member_practiced = form.membership_member_practiced === 'yes';
    form.membership_leader_practiced = form.membership_leader_practiced === 'yes';
    form.other_interventions_practiced = form.other_interventions_practiced === 'yes';
    form.health_nutrition_practiced = form.health_nutrition_practiced === 'yes';
    form.normal_delivery = form.normal_delivery === 'yes' ? 1 : 0;
    form.cs_delivery = form.cs_delivery === 'yes' ? 1 : 0;

    // Submit the form
    form.post(route('pnea-enrollment'), {
        onSuccess: () => {
            formSubmittedSuccessfully.value = true;
            modalTitle.value = 'Success';
            modalMessage.value = 'The form has been successfully saved.';
            showModal.value = true;
            flashMessage('The form has been successfully saved.', 'success');
            window.location.href = route('pnea-enrollment-view');
        },
        onError: (errors) => {
            formSubmittedSuccessfully.value = false;
            modalTitle.value = 'Error';
            modalMessage.value = 'An error occurred while saving the form. Please review the following errors: ' + JSON.stringify(errors, null, 2);
            showModal.value = true;
            flashMessage('An error occurred while saving the form. Please review the errors.', 'error');
        }
    });
};

const closeModal = () => showModal.value = false;

const redirectToDashboard = () => {
    showCancelModal.value = true;
};

const confirmCancel = () => {
    // window.location.href = route('pnea-enrollment-view');
    form.get(route('pnea-enrollment-view'));
};

const today = new Date().toISOString().split('T')[0];

const calculateBMI = () => {
    if (form.weight && form.height) {
        const heightInMeters = form.height / 100;
        form.bmi = (form.weight / (heightInMeters * heightInMeters)).toFixed(2);
    }
};

const calculateAge = (birthDate) => {
    const today = new Date();
    const birthDateObj = new Date(birthDate);
    let age = today.getFullYear() - birthDateObj.getFullYear();
    const monthDifference = today.getMonth() - birthDateObj.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDateObj.getDate())) {
        age--;
    }
    return age;
};

// Watchers to automatically calculate BMI when weight or height changes
watch(() => form.weight, calculateBMI);
watch(() => form.height, calculateBMI);

// Watcher to automatically calculate age when birth_date changes
watch(() => form.birth_date, (newBirthDate) => {
    form.age = calculateAge(newBirthDate);
});

</script>

<template>
    <Head title=" | PNEA Enrollment Form"/>
    <div class="survey-container">
        <!-- <div class="header"> -->
            <h2>PNEA Enrollment Form</h2>
        <!-- </div> -->
        <form @submit.prevent="submit">
            <div class="form-section">
                <div class="form-group small-input">
                    <label for="date">Registration Date</label>
                    <input type="date" class="input" name="date" v-model="form.date" required/>
                </div>
                <div class="form-group small-input right-align">
                    <label for="pinkCardNumber">Pink Card Number</label>
                    <input type="text" name="pinkCardNumber" v-model="form.pinkCardNumber" required/>
                </div>
                <div class="form-group small-input-zone">
                    <label for="zone">Zone</label>
                    <select name="zone" class="select" id="zone" v-model="form.zone">
                        <option value=""></option>
                        <option value="Zone 1">Zone 1</option>
                        <option value="Zone 2">Zone 2</option>
                        <option value="Zone 3">Zone 3</option>
                        <option value="Zone 4">Zone 4</option>
                        <option value="Zone 5">Zone 5</option>
                        <option value="Zone 6">Zone 6</option>
                        <option value="Zone 7">Zone 7</option>
                    </select>
                </div>
            </div>
            <div class="form-section">
                <div class="form-group large-input-mother">
                    <label for="fullName">Name of Mother</label>
                    <input type="text" name="fullName" v-model="form.fullName" required/>
                </div>
                <div class="form-group small-input right-align">
                    <label for="birth_date">Birth Date</label>
                    <input type="date" class="input" name="birth_date" v-model="form.birth_date" :max="today" required/>
                </div>
                <div class="form-group small-input-age right-align">
                    <label for="age">Age</label>
                    <input type="number" class="input" name="age" v-model="form.age" readonly/>
                </div>
            </div>
            <div class="form-section">
                <div class="form-group medium-input-education">
                    <label for="education">Educational Level</label>
                    <select name="education" class="select" v-model="form.education" required>
                        <option value=""></option>
                        <option value="None">N/A</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Highschool">High School</option>
                        <option value="College">College</option>
                        <option value="Postgraduate">Post Graduate</option>
                    </select>
                </div>
                <div class="form-group medium-input-occupation">
                    <label for="occupation">Occupation</label>
                    <input type="text" name="occupation" v-model="form.occupation" required/>
                </div>
                <div class="form-group small-input">
                    <label for="term_of_pregnancy">Term of Pregnancy</label>
                    <input type="text" name="term_of_pregnancy" v-model="form.term_of_pregnancy" required/>
                </div>
                <div class="form-group">
                    <label for="number_of_pregnancy">Number of Pregnancy</label>
                    <input type="number" class="input" name="number_of_pregnancy" v-model="form.number_of_pregnancy" required/>
                </div>
            </div>
            <div class="form-section">
                <div class="form-group">
                    <label for="date_last_delivery">Date of Last Delivery</label>
                    <input type="date" class="input" name="date_last_delivery" v-model="form.date_last_delivery" required/>
                </div>
                <div class="form-group">
                    <label for="number_of_children">Number of Children</label>
                    <input type="number" class="input" name="number_of_children" v-model="form.number_of_children" required/>
                </div>
                <div class="form-group">
                    <label for="interval_of_delivery">Interval of Delivery</label>
                    <input type="text" name="interval_of_delivery" v-model="form.interval_of_delivery" required/>
                </div>
                <div class="form-group">
                    <label for="muac">MUAC</label>
                    <input type="text" name="muac" v-model="form.muac" required/>
                </div>
            </div>
            <div class="form-section">
                <div class="form-group">
                    <label for="height">Height (cm)</label>
                    <input type="number" class="input" name="height" v-model="form.height" required/>
                </div>
                <div class="form-group">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" class="input" name="weight" v-model="form.weight" required/>
                </div>
                <div class="form-group">
                    <label for="bmi">BMI</label>
                    <input type="number" class="input" name="bmi" v-model="form.bmi" readonly/>
                </div>
                <div class="form-group">
                    <label for="ns">NS</label>
                    <input type="text" name="ns" v-model="form.ns" required/>
                </div>
            </div>
            <div class="form-section">
                <div class="form-group">
                    <label for="name_of_husband">Name of Husband</label>
                    <input type="text" name="name_of_husband" v-model="form.name_of_husband" required/>
                </div>
                <div class="form-group small-input">
                    <label for="husband_age">Husband's Age</label>
                    <input type="number" class="input" name="husband_age" v-model="form.husband_age" required/>
                </div>
            </div>
            <div class="form-section">
                <div class="form-group medium-input-education">
                    <label for="husband_education">Educational Level</label>
                    <select name="husband_education" class="select" v-model="form.husband_education" required>
                        <option value=""></option>
                        <option value="None">N/A</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Highschool">High School</option>
                        <option value="College">College</option>
                        <option value="Postgraduate">Post Graduate</option>
                    </select>
                </div>
                <div class="form-group medium-input-occupation">
                    <label for="husband_occupation">Occupation</label>
                    <input type="text" name="husband_occupation" v-model="form.husband_occupation" required/>
                </div>
                <div class="form-group">
                    <label for="monthly_family_income">Monthly Family Income</label>
                    <input type="text" name="monthly_family_income" v-model="form.monthly_family_income" required/>
                </div>
                <div class="form-group">
                    <label for="household_size">Household Size</label>
                    <input type="number" class="input" name="household_size" v-model="form.household_size" required/>
                </div>
            </div>
            <hr style="margin-top: 40px; margin-bottom: 20px;">

            <h2 style="text-align: center; color: #1c4e80">Optimum Practice Form</h2>
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
                <label><input type="radio" v-model="form.prenatal_care_counseled" value="yes"> Yes</label>
                <label><input type="radio" v-model="form.prenatal_care_counseled" value="no"> No </label>
              </div>
              <div v-if="form.prenatal_care_counseled === 'yes'">
                <input type="date" class="date-input" v-model="form.prenatal_care_date_counseled">
              </div>
            </td>
            <td class="col-practiced">
              <div class="data-practiced">
                <select v-model="form.prenatal_care_practiced" class="dropdown-pre-natals">
                  <option value="Private Hospital/Clinic">Private Hospital/Clinic</option>
                  <option value="Rural Health Unit">Rural Health Unit</option>
                </select>
              </div>
            </td>
          </tr>

          <!-- Row 2 -->
          <tr>
            <td class="col-practices">2. Pre-natal check up</td>
            <td class="col-counseled">
              <div class="radio-container">
                <label><input type="radio" v-model="form.prenatal_checkup_counseled" value="yes"> Yes</label>
                <label><input type="radio" v-model="form.prenatal_checkup_counseled" value="no"> No</label>
              </div>
              <div v-if="form.prenatal_checkup_counseled === 'yes'">
                <input type="date" class="date-input" v-model="form.prenatal_checkup_date_counseled">
              </div>
            </td>
            <td class="col-practiced">
              <table class="nested-table">
                <thead>
                  <tr class="data-headers">
                    <th>1st Trimester</th>
                    <th>2nd Trimester</th>
                    <th>3rd Trimester</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input type="date" class="date-input" v-model="form.prenatal_care_date_1"></td>
                    <td><input class="date-input" type="date" v-model="form.prenatal_care_date_2"></td>
                    <td><input class="date-input" type="date" v-model="form.prenatal_care_date_3"></td>
                  </tr>
                  <tr>
                    <td><input class="date-input" type="date" v-model="form.prenatal_care_date_4"></td>
                    <td><input class="date-input" type="date" v-model="form.prenatal_care_date_5"></td>
                    <td><input class="date-input" type="date" v-model="form.prenatal_care_date_6"></td>
                  </tr>
                  <tr>
                    <td><input class="date-input" type="date" v-model="form.prenatal_care_date_7"></td>
                    <td><input class="date-input" type="date" v-model="form.prenatal_care_date_8"></td>
                    <td><input class="date-input" type="date" v-model="form.prenatal_care_date_9"></td>
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
                <label><input type="radio" v-model="form.iron_folic_acid_counseled" value="yes"> Yes</label>
                <label><input type="radio" v-model="form.iron_folic_acid_counseled" value="no"> No</label>
              </div>
              <div v-if="form.iron_folic_acid_counseled === 'yes'">
                <input type="date" class="date-input" v-model="form.iron_folic_acid_date_counseled">
              </div>
            </td>
            <td class="col-practiced">
              <table class="nested-table">
                <thead>
                  <tr>
                    <th>1st Trimester</th>
                    <th>2nd Trimester</th>
                    <th>3rd Trimester</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input class="date-input" type="date" v-model="form.iron_folic_acid_date_1"></td>
                    <td><input class="date-input" type="date" v-model="form.iron_folic_acid_date_2"></td>
                    <td><input class="date-input" type="date" v-model="form.iron_folic_acid_date_3"></td>
                  </tr>
                  <tr>
                    <td><input class="date-input" type="date" v-model="form.iron_folic_acid_date_4"></td>
                    <td><input class="date-input" type="date" v-model="form.iron_folic_acid_date_5"></td>
                    <td><input class="date-input" type="date" v-model="form.iron_folic_acid_date_6"></td>
                  </tr>
                  <tr>
                    <td><input class="date-input" type="date" v-model="form.iron_folic_acid_date_7"></td>
                    <td><input class="date-input" type="date" v-model="form.iron_folic_acid_date_8"></td>
                    <td><input class="date-input" type="date" v-model="form.iron_folic_acid_date_9"></td>
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
                <label><input type="radio" v-model="form.iodized_salt_counseled" value="yes"> Yes</label>
                <label><input type="radio" v-model="form.iodized_salt_counseled" value="no"> No</label>
              </div>
              <div v-if="form.iodized_salt_counseled === 'yes'">
                <input type="date" class="date-input" v-model="form.iodized_salt_date_counseled">
              </div>
            </td>
            <td class="col-practiced">
              <label>Date Tested</label>
              <input class="date-tested" type="date" v-model="form.iodized_salt_practiced">
            </td>
          </tr>

          <!-- Row 5 -->
          <tr>
            <td class="col-practices">5. With Tetanus Toxoid vaccination</td>
            <td class="col-counseled">
              <div class="radio-container">
                <label><input type="radio" v-model="form.tetanus_counseled" value="yes"> Yes</label>
                <label><input type="radio" v-model="form.tetanus_counseled" value="no"> No</label>
              </div>
              <div v-if="form.tetanus_counseled === 'yes'">
                <input type="date" class="date-input" v-model="form.tetanus_date_counseled">
              </div>
            </td>
            <td class="col-practiced">
              <table class="nested-table">
                <thead>
                  <tr>
                    <th>Doses</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1st Dose</td>
                    <td><input class="date-input" type="date" v-model="form.dose_date_1"></td>
                  </tr>
                  <tr>
                    <td>2nd Dose</td>
                    <td><input class="date-input" type="date" v-model="form.dose_date_2"></td>
                  </tr>
                  <tr>
                    <td>3rd Dose</td>
                    <td><input class="date-input" type="date" v-model="form.dose_date_3"></td>
                  </tr>
                  <tr>
                    <td>4th Dose</td>
                    <td><input class="date-input" type="date" v-model="form.dose_date_4"></td>
                  </tr>
                  <tr>
                    <td>5th Dose</td>
                    <td><input class="date-input" type="date" v-model="form.dose_date_5"></td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>

          <!-- Row 6 -->
          <tr>
            <td class="col-practices">6. Preparation for breastfeed
              <table class="checkbox-container">
                <tr><td><input type="checkbox" v-model="form.initiation" value="yes"> Initiation (at least 30 min after delivery)</td></tr>
                <tr><td><input type="checkbox" v-model="form.exclusivity" value="yes"> Exclusivity (0-6 months)</td></tr>
                <tr><td><input type="checkbox" v-model="form.duration" value="yes"> Duration (at least 2 years)</td></tr>
                <tr><td><input type="checkbox" v-model="form.dietary_intake" value="yes"> Dietary Intake (Balanced and Adequacy)</td></tr>
                <tr><td><input type="checkbox" v-model="form.personal_willingness" value="yes"> Personal Willingness/Interest to Breastfeed</td></tr>
                <tr><td><input type="checkbox" v-model="form.family_support" value="yes"> Family Support (Husband and Parents)</td></tr>
              </table>
            </td>
            <td class="col-counseled">
              <table class="checkbox-counseled">
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="form.initiation_counseled" value="yes"> Yes</label>
                      <label><input type="radio" v-model="form.initiation_counseled" value="no"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="form.exclusivity_counseled" value="yes"> Yes</label>
                      <label><input type="radio" v-model="form.exclusivity_counseled" value="no"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="form.duration_counseled" value="yes"> Yes</label>
                      <label><input type="radio" v-model="form.duration_counseled" value="no"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="form.dietary_intake_counseled" value="yes"> Yes</label>
                      <label><input type="radio" v-model="form.dietary_intake_counseled" value="no"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="form.personal_willingness_counseled" value="yes"> Yes</label>
                      <label><input type="radio" v-model="form.personal_willingness_counseled" value="no"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="form.family_support_counseled" value="yes"> Yes</label>
                      <label><input type="radio" v-model="form.family_support_counseled" value="no"> No</label>
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
                    <td><input type="datetime-local" class="datetime-local" v-model="form.initiation_start_date_practiced"></td>
                    <td><input type="datetime-local" class="datetime-local" v-model="form.initiation_end_date_practiced"></td>
                  </tr>
                  <tr>
                    <td>Exclusivity</td>
                    <td><input type="datetime-local" class="datetime-local" v-model="form.exclusivity_start_date_practiced"></td>
                    <td><input type="datetime-local" class="datetime-local" v-model="form.exclusivity_end_date_practiced"></td>
                  </tr>
                  <tr>
                    <td>Duration</td>
                    <td><input type="datetime-local" class="datetime-local" v-model="form.duration_start_date_practiced"></td>
                    <td><input type="datetime-local" class="datetime-local" v-model="form.duration_end_date_practiced"></td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>

          <!-- Row 7 -->
          <tr>
            <td class="col-practices">7. Attendance to Nutrition Interventions
              <table class="checkbox-container">
                <tr><td><input type="checkbox" v-model="form.proper_infant" value="yes"> Proper Infant and Young Child Feeding</td></tr>
                <tr><td><input type="checkbox" v-model="form.nutripak" value="yes"> NUTRIPAK Utilization</td></tr>
                <tr><td><input type="checkbox" v-model="form.health_nutrition" value="yes"> Health, Nutrition, and Food Safety</td></tr>
                <tr><td><input type="checkbox" v-model="form.membership" value="yes"> Membership in Peer Counseling Group</td></tr>
                <tr><td><input type="checkbox" v-model="form.plant_malunggay" value="yes"> "Plant-A-Malunggay Project"</td></tr> 
                <tr><td><label>Other Interventions, specify<input type="text" v-model="form.other_interventions" placeholder="Please specify"></label></td></tr> 
              </table>
            </td>

            <td class="col-counseled">
              <table class="checkbox-counseled">
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="form.proper_infant_counseled" value="yes"> Yes</label>
                      <label><input type="radio" v-model="form.proper_infant_counseled" value="no"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="form.nutripak_counseled" value="yes"> Yes</label>
                      <label><input type="radio" v-model="form.nutripak_counseled" value="no"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="form.health_nutrition_counseled" value="yes"> Yes</label>
                      <label><input type="radio" v-model="form.health_nutrition_counseled" value="no"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="form.membership_counseled" value="yes"> Yes</label>
                      <label><input type="radio" v-model="form.membership_counseled" value="no"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="form.plant_malunggay_counseled" value="yes"> Yes</label>
                      <label><input type="radio" v-model="form.plant_malunggay_counseled" value="no"> No</label>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="radio-container">
                      <label><input type="radio" v-model="form.other_interventions_counseled" value="yes"> Yes</label>
                      <label><input type="radio" v-model="form.other_interventions_counseled" value="no"> No</label>
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
                        <label><input type="radio" v-model="form.proper_infant_practiced" value="yes"> Yes</label>
                        <label><input type="radio" v-model="form.proper_infant_practiced" value="no"> No</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>No. of recipes cooked with NUTRIPAK</td>
                    <td>
                      <input type="number" class="nutripak-number" v-model="form.nutripak">
                    </td>
                  </tr>
                  <tr class="small-row">
                    <td></td>
                    <td>
                      <div class="radio-container">
                        <label><input type="radio" v-model="form.health_nutrition_practiced" value="yes"> Yes</label>
                        <label><input type="radio" v-model="form.health_nutrition_practiced" value="no"> No</label>
                      </div>
                    </td>
                  </tr>
                  <tr class="small-row">
                    <td></td>
                    <td>
                      <div class="radio-container">
                        <p class="row7-radio">Member: </p>
                        <label><input type="radio" v-model="form.membership_member_practiced" value="yes"> Yes</label>
                        <label><input type="radio" v-model="form.membership_member_practiced" value="no"> No</label>
                      </div>
                      <div class="radio-container">
                        <p class="row7-radio">Leader: </p>
                        <label><input type="radio" v-model="form.membership_leader_practiced" value="yes"> Yes</label>
                        <label><input type="radio" v-model="form.membership_leader_practiced" value="no"> No</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>No. of Malunggay Trees Planted </td>
                    <td>
                      <input type="number" class="nutripak-number" v-model="form.plant_malunggay_number_practiced">
                    </td>
                  </tr>
                  <tr>
                    <td>Date Planted</td>
                    <td>
                      <input type="date" class="date-input-planted" v-model="form.date_planted_practiced">
                    </td>
                  </tr>
                  <tr>
                    <td>Location</td>
                    <td>
                      <div class="location-container">
                        <input type="text" class="date-input-location" v-model="form.location_practiced">
                      </div>
                    </td>
                  </tr>
                  <tr class="small-row">
                    <td></td>
                    <td>
                      <div class="radio-container">
                        <label><input type="radio" v-model="form.other_interventions_practiced" value="yes"> Yes</label>
                        <label><input type="radio" v-model="form.other_interventions_practiced" value="no"> No</label>
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
                <label><input type="radio" v-model="form.postnatal_checkup_counseled" value="yes"> Yes</label>
                <label><input type="radio" v-model="form.postnatal_checkup_counseled" value="no"> No </label>
              </div>
              <div v-if="form.counseled === 'Yes'">
                <input type="date" class="date-input" v-model="form.postnatal_checkup_date_counseled">
              </div>
            </td>
            <td class="col-practiced">
              <div class="data-practiced">
                <label>Date of last check up <input type="date" class="date-input-8" v-model="form.postnatal_last_checkup_date_practiced"></label>
              </div>
            </td>
          </tr>
        <!-- Row 9 -->
        <tr>
            <td class="col-practices">9. Iron Supplementation</td>
            <td class="col-counseled">
              <div class="radio-container">
                <label><input type="radio" v-model="form.iron_supplementation_counseled" value="yes"> Yes</label>
                <label><input type="radio" v-model="form.iron_supplementation_counseled" value="no"> No </label>
              </div>
              <div v-if="form.counseled === 'Yes'">
                <input type="date" class="date-input" v-model="form.iron_supplementation_date_counseled">
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
                    <td><input type="text" class="amount-intake" v-model="form.iron_supplementation_amount_practiced"></td>
                    <td><input type="date" class="date-input" v-model="form.iron_supplementation_last_date_taken_practiced"></td>
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
                    <label><input type="radio" v-model="form.breastfeed_initiation_counseled" value="yes"> Yes</label>
                    <label><input type="radio" v-model="form.breastfeed_initiation_counseled" value="no"> No </label>
                </div>
                <div v-if="form.breastfeed_initiation_counseled === 'Yes'">
                    <input type="date" class="date-input" v-model="form.breastfeed_initiation_date_counseled">
                </div>
                </td>
                <td class="col-practiced">
                <div class="data-practiced">
                    <label><input type="checkbox" class="data-row-11" v-model="form.normal_delivery" value="yes"> Normal Delivery (within half an hour)</label>
                    <label><input type="checkbox" class="data-row-11" v-model="form.cs_delivery" value="yes"> Caesarian Delivery (within 3 hour)</label>
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
                            <label><input type="radio" v-model="form.given_colostrums" value="yes"> Yes</label>
                            <label><input type="radio" v-model="form.given_colostrums" value="no"> No</label>
                            </div>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="radio-container">
                            <label><input type="radio" v-model="form.no_water_given" value="yes"> Yes</label>
                            <label><input type="radio" v-model="form.no_water_given" value="no"> No</label>
                            </div>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="radio-container">
                            <label><input type="radio" v-model="form.no_food_given" value="yes"> Yes</label>
                            <label><input type="radio" v-model="form.no_food_given" value="no"> No</label>
                            </div>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="radio-container">
                            <label><input type="radio" v-model="form.	no_vitamins_given" value="yes"> Yes</label>
                            <label><input type="radio" v-model="form.	no_vitamins_given" value="no"> No</label>
                            </div>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="radio-container">
                            <label><input type="radio" v-model="form.no_formula_milk_given" value="yes"> Yes</label>
                            <label><input type="radio" v-model="form.no_formula_milk_given" value="no"> No</label>
                            </div>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="radio-container">
                            <label><input type="radio" v-model="form.	no_other_liquid_given" value="yes"> Yes</label>
                            <label><input type="radio" v-model="form.	no_other_liquid_given" value="no"> No</label>
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
                                    <select v-model="form.exclusive_breastfeed_colostrums_1">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_colostrums_2">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_colostrums_3">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_colostrums_4">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_colostrums_5">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_colostrums_6">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_water_1">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_water_2">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_water_3">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_water_4">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_water_5">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_water_6">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_food_1">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_food_2">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_food_3">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_food_4">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_food_5">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_food_6">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_vitamins_1">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_vitamins_2">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_vitamins_3">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_vitamins_4">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_vitamins_5">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_vitamins_6">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_formula_milk_1">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_formula_milk_2">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_formula_milk_3">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_formula_milk_4">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_formula_milk_5">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_formula_milk_6">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_other_liquid_1">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_other_liquid_2">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_other_liquid_3">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_other_liquid_4">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_other_liquid_5">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="form.exclusive_breastfeed_other_liquid_6">
                                        <option value=""></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
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
                                <label><input type="radio" v-model="form.child_sick_counseled" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.child_sick_counseled" value="no"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="form.mother_sick_counseled" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.mother_sick_counseled" value="no"> No</label>
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
                                <label><input type="radio" v-model="form.child_sick_practiced" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.child_sick_practiced" value="no"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="form.mother_sick_practiced" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.mother_sick_practiced" value="no"> No</label>
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
                                <label><input type="radio" v-model="form.continue_breastfeed_beyond_2_counseled" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.continue_breastfeed_beyond_2_counseled" value="no"> No</label>
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
                                <label><input type="radio" v-model="form.continue_breastfeed_beyond_2_practiced" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.continue_breastfeed_beyond_2_practiced" value="no"> No</label>
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
                                <label><input type="radio" v-model="form.backyard_gardening_counseled" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.backyard_gardening_counseled" value="no"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="form.clean_environment_counseled" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.clean_environment_counseled" value="no"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="form.sanitary_counseled" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.sanitary_counseled" value="no"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="form.potable_water_counseled" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.potable_water_counseled" value="no"> No</label>
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
                                <label><input type="radio" v-model="form.backyard_gardening_practiced" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.backyard_gardening_practiced" value="no"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="form.clean_environment_practiced" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.clean_environment_practiced" value="no"> No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="form.sanitary_practiced" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.sanitary_practiced" value="no"> No</label>
                                </div>
                            </td>   
                        </tr>
                        <tr>
                            <td>
                                <div class="radio-container">
                                <label><input type="radio" v-model="form.potable_water_practiced" value="yes"> Yes</label>
                                <label><input type="radio" v-model="form.potable_water_practiced" value="no"> No</label>
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

        <!-- Modal -->
        <div v-if="showModal" :class="['modal', formSubmittedSuccessfully ? 'modal-success' : 'modal-error']">
            <div class="modal-content-success" v-if="formSubmittedSuccessfully">
                <h2 style="color: white;">{{ modalTitle }}</h2>
                <p>{{ modalMessage }}</p>
            </div>
            <div class="modal-content-error" v-else>
                <h2 style="color: white;">{{ modalTitle }}</h2>
                <p>{{ modalMessage }}</p>
            </div>
        </div>
        <!-- Cancel Confirmation Modal -->
        <div v-if="showCancelModal" class="modal">
            <div class="modal-content">
                <h2 style="margin-bottom: 7px;">Cancel Confirmation</h2>
                <hr style="margin-bottom: 10px;">
                <p>{{ cancelMessage }}</p>
                <div class="modal-btn">
                    <button @click="confirmCancel" class="save-button">Yes</button>
                    <button @click="showCancelModal = false" class="cancel-button">No</button>
                </div>
            </div>
        </div>
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
.form-row {
  display: flex;
  justify-content: space-between;
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
.icon-button-trash {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 18px;
  color: #dc3545;
  padding: 5px;
  transition: color 0.3s ease;
}
.icon-button-trash:hover {
  color: #c82333;
}

.icon-button:hover {
  color: #0056b3;
}

/* Start */
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
  /* position: sticky; */
  top: 0;
  background-color: #007bff;
  padding: 10px;
  text-align: center;
  font-weight: bold;
  /* z-index: 11; */
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
  color: #fff;
}
.info-table thead th.col-counseled {
  width: 10%;
  border-right: 1px solid #ddd;
  color: #fff;
}
.info-table thead th.col-practiced {
  width: 30%;
  color: #fff;
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

/* ------- ------ ------- ------ */
.survey-container {
    width: 100%;
    padding: 20px;
    margin: 1% 0 15% 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-left: 10%;
}

.header {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    margin-top: 0;
    width: 90%;
}

h2 {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    color: #1c4e80;
    margin-bottom: 20px;
}

label {
    color: #555;
    display: block;
    margin-bottom: 3px;
}

.form-section {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 10px;
}

.form-group {
    flex: 1;
    width: 100%;
    margin-right: 10px;
}

.form-group:last-child {
    margin-right: 0;
}

.input, .select {
    width: 100%;
    height:42px;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #fff;
    transition: border-color 0.3s;
}

.input:focus, .select:focus {
    border-color: #007bff;
    outline: none;
}

.small-input {
    flex: 0 0 200px;
}

.small-input-age {
    flex: 0 0 100px;
}

.small-input-zone {
    flex: 0 0 100px;
}

.medium-input-education {
    flex: 0 0 200px;
}

.medium-input-occupation {
    flex: 0 0 300px;
}

.large-input-mother {
    flex: 0 0 600px;
}

.right-align {
    margin-left: auto;
}

.form-row-buttons {
    display: flex;
    justify-content: space-between;
}

.save-button, .cancel-button {
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

.save-button {
    background-color: #007bff;
}

.cancel-button {
    background-color: #dc3545;
}

.save-button:hover {
    background-color: #0056b3;
}

.cancel-button:hover {
    background-color: #c82333;
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

.modal-success {
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
.modal-error {
    background-color: rgba(0, 0, 0, 0.4); 
    color: white;
}
.modal-btn{
    display: flex;
    justify-content: center;
    gap: 10px;
}

.modal-content-success {
    background-color: #28a745;
    color: white;
    margin: auto;
    padding: 20px;
    border: 1px solid #28a745;
    width: 70%;
    max-width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(74, 220, 79, 0.1);
    text-align: center;
}
.modal-content-error {
    background-color: #dc3545;
    color: white;
    margin: auto;
    padding: 20px;
    border: 1px solid #dc3545;
    width: 70%;
    max-width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.1);
    text-align: center;
    top: 0;
}
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 70%;
    max-width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

.flash-message {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 10px 20px;
    border-radius: 5px;
    color: #fff;
    z-index: 1000;
    opacity: 0.9;
    transition: opacity 0.3s ease;
}

.flash-message.success {
    background-color: #28a745;
}

.flash-message.error {
    background-color: #dc3545;
}

</style>