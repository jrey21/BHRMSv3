<script setup>
import FormLayout from '../../Layouts/FormLayout.vue';
import { ref, onMounted, computed, watchEffect } from 'vue';
import Space from '../../Components/Space.vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

defineOptions({
    layout: FormLayout
});
const props = defineProps({
    pnea: { type: Object, required: true },
});

const formatDate = (dateStr) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateStr).toLocaleDateString(undefined, options);
};

const sortedPneaRecords = computed(() => { 
    const records = props.pnea.optimum_practice.map(record => {
        console.log('Record:', record); 
        return {
            //Row 1
            prenatal_care_counseled: record.prenatal_care_counseled,
            prenatal_care_date_counseled: record.prenatal_care_counseled === 1 ? formatDate(record.prenatal_care_date_counseled) : '',
            prenatal_care_practiced: record.prenatal_care_practiced,
            //Row 2
            prenatal_check_up_counseled: record.prenatal_check_up_counseled,
            prenatal_check_up_date_counseled: record.prenatal_check_up_counseled === 1 ? formatDate(record.prenatal_check_up_date_counseled) : '',
            prenatal_checkup_trimester_practiced: record.prenatal_checkup_trimester_practiced,
            prenatal_checkup_date_practiced: formatDate(record.prenatal_checkup_date_practiced),
            //Row 3
            iron_folic_acid_counseled: record.iron_folic_acid_counseled,
            iron_folic_acid_date_counseled: record.iron_folic_acid_counseled === 1 ? formatDate(record.iron_folic_acid_date_counseled) : '',
            iron_folic_acid_trimester_practiced: record.iron_folic_acid_trimester_practiced,
            iron_folic_acid_date_practiced: formatDate(record.iron_folic_acid_date_practiced),
            //Row 4
            iodized_salt_counseled: record.iodized_salt_counseled,
            iodized_salt_date_counseled: record.iodized_salt_counseled === 1 ? formatDate(record.iodized_salt_date_counseled) : '',
            iodized_salt_practiced: formatDate(record.iodized_salt_practiced),
            //Row 5
            tetanus_counseled: record.tetanus_counseled,
            tetanus_date_counseled: record.tetanus_counseled === 1 ? formatDate(record.tetanus_date_counseled) : '',
            tetanus_dose_practiced: record.tetanus_dose_practiced,
            tetanus_date_practiced: formatDate(record.tetanus_date_practiced),
            //Row 6
            initiation: record.initiation,
            exclusivity: record.exclusivity,
            duration: record.duration,
            dietary_intake: record.dietary_intake,
            personal_willingness: record.personal_willingness,
            family_support: record.family_support,
            initiation_counseled: record.initiation_counseled,
            exclusivity_counseled: record.exclusivity_counseled,
            duration_counseled: record.duration_counseled,
            dietary_intake_counseled: record.dietary_intake_counseled,
            personal_willingness_counseled: record.personal_willingness_counseled,
            family_support_counseled: record.family_support_counseled,
            initiation_start_date_practiced: formatDate(record.initiation_start_date_practiced),
            initiation_end_date_practiced: formatDate(record.initiation_end_date_practiced),
            exclusivity_start_date_practiced: formatDate(record.exclusivity_start_date_practiced),
            exclusivity_end_date_practiced: formatDate(record.exclusivity_end_date_practiced),
            duration_start_date_practiced: formatDate(record.duration_start_date_practiced),
            duration_end_date_practiced: formatDate(record.duration_end_date_practiced),
            //Row 7
            proper_infant: record.proper_infant,
            nutripak: record.nutripak,
            health_nutrition: record.health_nutrition,
            membership: record.membership,
            plant_malunggay: record.plant_malunggay,
            other_interventions: record.other_interventions,
            proper_infant_counseled: record.proper_infant_counseled,
            nutripak_counseled: record.nutripak_counseled,
            health_nutrition_counseled: record.health_nutrition_counseled,
            membership_counseled: record.membership_counseled,
            plant_malunggay_counseled: record.plant_malunggay_counseled,
            other_interventions_counseled: record.other_interventions_counseled,
            proper_infant_practiced: record.proper_infant_practiced,
            nutripak_practiced: record.nutripak_practiced,
            health_nutrition_practiced: record.health_nutrition_practiced,
            membership_member_practiced: record.membership_member_practiced,
            membership_leader_practiced: record.membership_leader_practiced,
            plant_malunggay_number_practiced: record.plant_malunggay_number_practiced,
            date_planted_practiced: formatDate(record.date_planted_practiced),
            location_practiced: record.location_practiced,
            other_interventions_practiced: record.other_interventions_practiced,
            //Row 8
            postnatal_checkup_counseled: record.postnatal_checkup_counseled,
            postnatal_checkup_date_counseled: record.postnatal_checkup_counseled === 1 ? formatDate(record.postnatal_checkup_date_counseled) : '',
            postnatal_last_checkup_date_practiced: formatDate(record.postnatal_last_checkup_date_practiced),
            //Row 9
            iron_supplementation_counseled: record.iron_supplementation_counseled,
            iron_supplementation_date_counseled: record.iron_supplementation_counseled === 1 ? formatDate(record.iron_supplementation_date_counseled) : '',
            iron_supplementation_last_date_taken_practiced: formatDate(record.iron_supplementation_last_date_taken_practiced),
            //Row 10
            breastfeeding_initiation_counseled: record.breastfeeding_initiation_counseled,
            breastfeeding_initiation_date_counseled: record.breastfeeding_initiation_counseled === 1 ? formatDate(record.breastfeeding_initiation_date_counseled) : '',
            normal_delivery: record.normal_delivery,
            cs_delivery: record.cs_delivery,
            //Row 11
            exclusive_breastfeeding_colostrums_1: record.exclusive_breastfeeding_colostrums_1,
            exclusive_breastfeeding_colostrums_2: record.exclusive_breastfeeding_colostrums_2,
            exclusive_breastfeeding_colostrums_3: record.exclusive_breastfeeding_colostrums_3,
            exclusive_breastfeeding_colostrums_4: record.exclusive_breastfeeding_colostrums_4,
            exclusive_breastfeeding_colostrums_5: record.exclusive_breastfeeding_colostrums_5,
            exclusive_breastfeeding_colostrums_6: record.exclusive_breastfeeding_colostrums_6,
            exclusive_breastfeeding_water_1: record.exclusive_breastfeeding_water_1,
            exclusive_breastfeeding_water_2: record.exclusive_breastfeeding_water_2,
            exclusive_breastfeeding_water_3: record.exclusive_breastfeeding_water_3,
            exclusive_breastfeeding_water_4: record.exclusive_breastfeeding_water_4,
            exclusive_breastfeeding_water_5: record.exclusive_breastfeeding_water_5,
            exclusive_breastfeeding_water_6: record.exclusive_breastfeeding_water_6,
            exclusive_breastfeeding_food_1: record.exclusive_breastfeeding_food_1,
            exclusive_breastfeeding_food_2: record.exclusive_breastfeeding_food_2,
            exclusive_breastfeeding_food_3: record.exclusive_breastfeeding_food_3,
            exclusive_breastfeeding_food_4: record.exclusive_breastfeeding_food_4,
            exclusive_breastfeeding_food_5: record.exclusive_breastfeeding_food_5,
            exclusive_breastfeeding_food_6: record.exclusive_breastfeeding_food_6,
            exclusive_breastfeeding_vitamins_1: record.exclusive_breastfeeding_vitamins_1,
            exclusive_breastfeeding_vitamins_2: record.exclusive_breastfeeding_vitamins_2,
            exclusive_breastfeeding_vitamins_3: record.exclusive_breastfeeding_vitamins_3,
            exclusive_breastfeeding_vitamins_4: record.exclusive_breastfeeding_vitamins_4,
            exclusive_breastfeeding_vitamins_5: record.exclusive_breastfeeding_vitamins_5,
            exclusive_breastfeeding_vitamins_6: record.exclusive_breastfeeding_vitamins_6,
            exclusive_breastfeeding_formula_milk_1: record.exclusive_breastfeeding_formula_milk_1,
            exclusive_breastfeeding_formula_milk_2: record.exclusive_breastfeeding_formula_milk_2,
            exclusive_breastfeeding_formula_milk_3: record.exclusive_breastfeeding_formula_milk_3,
            exclusive_breastfeeding_formula_milk_4: record.exclusive_breastfeeding_formula_milk_4,
            exclusive_breastfeeding_formula_milk_5: record.exclusive_breastfeeding_formula_milk_5,
            exclusive_breastfeeding_formula_milk_6: record.exclusive_breastfeeding_formula_milk_6,
            exclusive_breastfeeding_other_liquid_1: record.exclusive_breastfeeding_other_liquid_1,
            exclusive_breastfeeding_other_liquid_2: record.exclusive_breastfeeding_other_liquid_2,
            exclusive_breastfeeding_other_liquid_3: record.exclusive_breastfeeding_other_liquid_3,
            exclusive_breastfeeding_other_liquid_4: record.exclusive_breastfeeding_other_liquid_4,
            exclusive_breastfeeding_other_liquid_5: record.exclusive_breastfeeding_other_liquid_5,
            exclusive_breastfeeding_other_liquid_6: record.exclusive_breastfeeding_other_liquid_6,
            given_colostrums: record.given_colostrums,
            no_water_given: record.no_water_given,
            no_food_given: record.no_food_given,
            no_vitamins_given: record.no_vitamins_given,
            no_formula_milk_given: record.no_formula_milk_given,
            no_other_liquid_given: record.no_other_liquid_given,
            //Row 12
            child_sick_counseled: record.child_sick_counseled,
            mother_sick_counseled: record.mother_sick_counseled,
            child_sick_practiced: record.child_sick_practiced,
            mother_sick_practiced: record.mother_sick_practiced,
            //Row 13
            continue_breastfeed_beyond_2_counseled: record.continue_breastfeed_beyond_2_counseled,
            continue_breastfeed_beyond_2_practiced: record.continue_breastfeed_beyond_2_practiced,
            //Row 14
            backyard_gardening_counseled: record.backyard_gardening_counseled,
            backyard_gardening_practiced: record.backyard_gardening_practiced,
            clean_environment_counseled: record.clean_environment_counseled,
            clean_environment_practiced: record.clean_environment_practiced,
            sanitary_counseled: record.sanitary_counseled,
            sanitary_practiced: record.sanitary_practiced,
            potable_water_counseled: record.potable_water_counseled,
        };
    });
    console.log(records);
    return records;
});

console.log(props.pnea.optimum_practice);

</script>

<template>
<Head title=" | Optimum Practices"/>
<div class="container">
    <h2 style="text-align: center; color: #1c4e80">Optimum Practices Form</h2>
    <form @submit.prevent="handleSubmit">
      <table class="info-table"  v-for="record in sortedPneaRecords" :key="record.date">
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
              <div>{{ record.prenatal_care_counseled === 1 ? 'Yes' : 'No' }}</div>
              <div>{{ record.prenatal_care_date_counseled }}</div>
            </td>
            <td class="col-practiced">
              <div>{{ record.prenatal_care_practiced }}</div>
            </td>
          </tr>

          <!-- Row 2 -->
          <tr>
            <td class="col-practices">2. Pre-natal check up</td>
            <td class="col-counseled">
                <div>{{ record.prenatal_check_up_counseled === 1 ? 'Yes' : 'No' }}</div>
                <div>{{ record.prenatal_check_up_date_counseled }}</div>
            </td>
            <td class="col-practiced">
              <table class="nested-table">
                <thead>
                  <tr class="data-headers">
                    <th>Trimester</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                        <div  class="trimester">{{ record.prenatal_checkup_trimester_practiced }}</div>
                    </td>
                    <td>
                        <div>{{ record.prenatal_checkup_date_practiced }}</div>
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
                <div>{{ record.iron_folic_acid_counseled === 1 ? 'Yes' : 'No' }}</div>
                <div>{{ record.iron_folic_acid_date_counseled }}</div>
            </td>
            <td class="col-practiced">
              <table class="nested-table">
                <thead>
                  <tr>
                    <th>Trimester</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="trimester">{{ record.iron_folic_acid_trimester_practiced }}</div>
                    </td>
                    <td>
                      <div>{{ record.iron_folic_acid_date_practiced }}</div>
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
                <div>{{ record.iodized_salt_counseled === 1 ? 'Yes' : 'No' }}</div>
                <div>{{ record.iodized_salt_date_counseled }}</div>
            </td>
            <td class="col-practiced">
              <label class="data-practiced-delivery">Date Tested:  <Space/> <Space/> <Space/> <Space/><span class="tested" style="font-weight:normal;"> {{ record.iodized_salt_practiced }}</span></label> 
            </td>
          </tr>

          <!-- Row 5 -->
          <tr>
            <td class="col-practices">5. With Tetanus Toxoid vaccination</td>
            <td class="col-counseled">
                <div>{{ record.tetanus_counseled === 1 ? 'Yes' : 'No' }}</div>
                <div>{{ record.tetanus_date_counseled }}</div>
            </td>
            <td class="col-practiced">
              <table class="nested-table">
                <thead>
                  <tr>
                    <th>Dose</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                        <div class="trimester">{{ record.tetanus_dose_practiced }}</div>
                    </td>
                    <td>
                        <div>{{ record.tetanus_date_practiced }}</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>

          <!-- Row 6 -->
          <tr>
            <td class="col-practices">6. Preparation for Breastfeeding
              <table class="checkbox-container">
                <tbody>
                    <tr><td><input type="checkbox" :checked="record.initiation === 1" disabled> Initiation</td></tr>
                    <tr><td><input type="checkbox" :checked="record.exclusivity === 1" disabled> Exclusivity</td></tr>
                    <tr><td><input type="checkbox" :checked="record.duration === 1" disabled> Duration</td></tr>
                    <tr><td><input type="checkbox" :checked="record.dietary_intake === 1" disabled> Dietary Intake</td></tr>
                    <tr><td><input type="checkbox" :checked="record.personal_willingness === 1" disabled> Personal Willingness</td></tr>
                    <tr><td><input type="checkbox" :checked="record.family_support === 1" disabled> Family Support</td></tr>
                </tbody>
              </table>
            </td>
            <td class="col-counseled">
              <table class="checkbox-counseled">
                <tbody>
                    <tr>
                      <td>
                        <div>{{ record.initiation_counseled === 1 ? 'Yes' : 'No' }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>{{ record.exclusivity_counseled === 1 ? 'Yes' : 'No' }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>{{ record.duration_counseled === 1 ? 'Yes' : 'No' }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>{{ record.dietary_intake_counseled === 1 ? 'Yes' : 'No' }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>{{ record.personal_willingness_counseled === 1 ? 'Yes' : 'No' }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>{{ record.family_support_counseled === 1 ? 'Yes' : 'No' }}</div>
                      </td>
                    </tr>
                </tbody>
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
                    <td>{{ record.initiation_start_date_practiced }}</td>
                    <td>{{ record.initiation_end_date_practiced }}</td>
                  </tr>
                  <tr>
                    <td>Exclusivity</td>
                    <td>{{ record.exclusivity_start_date_practiced }}</td>
                    <td>{{ record.exclusivity_end_date_practiced }}</td>
                  </tr>
                    <tr>
                        <td>Duration</td>
                        <td>{{ record.duration_start_date_practiced }}</td>
                        <td>{{ record.duration_end_date_practiced }}</td>
                    </tr>
                </tbody>
              </table>
            </td>
          </tr>

          <!-- Row 7 -->
          <tr>
            <td class="col-practices">7. Attendance to Nutrition Interventions
              <table class="checkbox-container">
                <tbody>
                    <tr><td><input type="checkbox" :checked="record.proper_infant === 1" disabled> Proper Infant and Young Child Feeding</td></tr>
                    <tr><td><input type="checkbox" :checked="record.nutripak === 1" disabled> NUTRIPAK Utilization</td></tr>
                    <tr><td><input type="checkbox" :checked="record.health_nutrition === 1" disabled> Health,Nutrition and Food Safety</td></tr>
                    <tr><td><input type="checkbox" :checked="record.membership === 1" disabled> Membership in Peer Counseling Group</td></tr>
                    <tr><td><input type="checkbox" :checked="record.plant_malunggay === 1" disabled> Plant-Malunggay-Project</td></tr>
                    <tr><td><Space/>{{ record.other_interventions }}</td></tr>
                </tbody>
              </table>
            </td>
            <td class="col-counseled">
              <table class="checkbox-counseled">
                <tbody>
                    <tr>
                      <td>
                        <div>{{ record.proper_infant_counseled === 1 ? 'Yes' : 'No' }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>{{ record.nutripak_counseled === 1 ? 'Yes' : 'No' }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>{{ record.health_nutrition_counseled === 1 ? 'Yes' : 'No' }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>{{ record.membership_counseled === 1 ? 'Yes' : 'No' }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>{{ record.plant_malunggay_counseled === 1 ? 'Yes' : 'No' }}</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div>{{ record.other_interventions_counseled === 1 ? 'Yes' : 'No' }}</div>
                      </td>
                    </tr>
                </tbody>
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
                    <td>Proper Infant and Young Child Feeding</td>
                    <td>
                        <div style="text-align: center;">{{ record.proper_infant_practiced === 1 ? 'Yes' : 'No' }}</div>
                    </td>
                  </tr>
                  <tr>
                    <td>No. of recipes cooked with NUTRIPAK</td>
                    <td>
                        <div style="text-align: center;">{{ record.nutripak_practiced }}</div>
                    </td>
                  </tr>
                  <tr class="small-row">
                    <td>Health,Nutrition and Food Safety</td>
                    <td>
                        <div style="text-align: center;">{{ record.health_nutrition_practiced === 1 ? 'Yes' : 'No'}}</div>
                    </td>
                  </tr>
                  <tr class="small-row">
                    <td>Membership in Peer Counseling Group</td>
                    <td>
                        <div>Member: <Space/> {{ record.membership_member_practiced === 1 ? 'Yes' : 'No'}}</div>
                        <div>Leader: <Space/> {{ record.membership_leader_practiced  === 1 ? 'Yes' : 'No' }}</div>            
                    </td>
                  </tr>
                  <tr>
                    <td>No. of Malunggay Trees Planted </td>
                    <td>
                        <div style="text-align: center;">{{ record.plant_malunggay_number_practiced }}</div>
                    </td>
                  </tr>
                  <tr>
                    <td>Date Planted</td>
                    <td>
                        <div style="text-align: center;">{{ record.date_planted_practiced }}</div>
                    </td>
                  </tr>
                  <tr>
                    <td>Location</td>
                    <td> 
                        <div style="text-align: center;">{{ record.location_practiced }}</div>
                    </td>
                  </tr>
                  <tr class="small-row">
                    <td>{{record.other_interventions }}</td>
                    <td>
                        <div style="text-align: center;">{{ record.other_interventions_practiced === 1 ? 'Yes': 'No'}}</div>
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
                <div>{{ record.postnatal_checkup_counseled === 1 ? 'Yes' : 'No' }}</div>
                <div>{{ record.postnatal_checkup_date_counseled }}</div>
            </td>
            <td class="col-practiced">
                <label style="text-align: left;">Date of last check up: <Space/><Space/> <span style="font-weight: normal;">{{ record.postnatal_last_checkup_date_practiced }}</span></label>
            </td>
          </tr>
        <!-- Row 9 -->
        <tr>
            <td class="col-practices">9. Iron Supplementation</td>
            <td class="col-counseled">
                <div>{{ record.iron_supplementation_counseled === 1 ? 'Yes' : 'No' }}</div>
                <div>{{ record.iron_supplementation_date_counseled }}</div>
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
                    <td>
                      <div>{{ record.iron_supplementation_amount_practiced }}</div>
                    </td>
                    <td>
                      <div>{{ record.iron_supplementation_last_date_taken_practiced }}</div>
                    </td>

                  </tr>
                </tbody>
              </table>
            </td>
          </tr>

          <!-- Row 10 -->
            <tr>
                <td class="col-practices">10. Breastfeeding Initiation</td>
                <td class="col-counseled">
                    <div>{{ record.breastfeeding_initiation_counseled === 1 ? 'Yes' : 'No' }}</div>
                    <div>{{ record.breastfeeding_initiation_date_counseled }}</div>
                </td>
                <td class="col-practiced">
                <div class="data-practiced-delivery">
                    <label><input type="checkbox" :checked="record.normal_delivery === 1" disabled> Normal Delivery (within half an hour)</label>
                    <label><input type="checkbox" :checked="record.cs_delivery === 1" disabled> CS Delivery (within 1 hour)</label>
                </div>
                </td>
            </tr>

            <!-- Row 11 -->
            <tr>
                <td class="col-practices">11. Exclusive Breastfeeding (0-6 months)
                    <table class="checkbox-container">
                        <tbody>
                            <tr><td><label>1. Given colostrums to the newborn</label></td></tr>
                            <tr><td><label>2. No water given</label></td></tr>
                            <tr><td><label>3. No food given</label></td></tr>
                            <tr><td><label>4. No vitamins given</label></td></tr>
                            <tr><td><label>5. No other formula milk given</label></td></tr>
                            <tr><td><label>6. No other liquid</label></td></tr>
                        </tbody>
                    </table>
                </td>
                <td class="col-counseled">
                    <table class="checkbox-counseled">
                        <tbody>
                            <tr>
                            <td>
                                <div>{{ record.given_colostrums === 1 ? 'Yes' : 'No' }}</div>                         
                            </td>
                            </tr>
                            <tr>
                            <td>
                                <div>{{ record.no_water_given === 1 ? 'Yes' : 'No' }}</div>
                            </td>
                            </tr>
                            <tr>
                            <td>
                                <div>{{ record.no_food_given === 1 ? 'Yes' : 'No' }}</div>
                            </td>
                            </tr>
                            <tr>
                            <td>
                                <div>{{ record.no_vitamins_given === 1 ? 'Yes' : 'No' }}</div>
                            </td>
                            </tr>
                            <tr>
                            <td>
                                <div>{{ record.no_formula_milk_given === 1 ? 'Yes' : 'No' }}</div>
                            </td>
                            </tr>
                            <tr>
                            <td>
                                <div>{{ record.no_other_liquid_given === 1 ? 'Yes' : 'No' }}</div>
                            </td>
                            </tr>
                        </tbody>
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
                                    <div >{{ record.exclusive_breastfeeding_colostrums_1 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_colostrums_2 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_colostrums_3 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_colostrums_4 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_colostrums_5 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_colostrums_6 }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_water_1 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_water_2 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_water_3 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_water_4 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_water_5 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_water_6 }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_food_1 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_food_2 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_food_3 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_food_4 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_food_5 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_food_6 }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_vitamins_1 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_vitamins_2 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_vitamins_3 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_vitamins_4 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_vitamins_5 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_vitamins_6 }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_formula_milk_1 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_formula_milk_2 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_formula_milk_3 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_formula_milk_4 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_formula_milk_5 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_formula_milk_6 }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_other_liquid_1 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_other_liquid_2 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_other_liquid_3 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_other_liquid_4 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_other_liquid_5 }}</div>
                                </td>
                                <td>
                                    <div>{{ record.exclusive_breastfeeding_other_liquid_6 }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <!-- Row 12 -->
             <tr>
                <td class="col-practices">12. Continue breastfeeding even:
                    <table class="checkbox-container">
                        <tbody>
                            <tr><td><label>1. When child is sick</label></td></tr>
                            <tr><td><label>2. When mother is sick</label></td></tr>
                        </tbody>
                    </table>
                </td>
                <td class="col-counseled">
                    <table class="checkbox-counseled">
                        <tbody>
                            <tr>
                                <td>
                                    <div>{{ record.child_sick_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>{{ record.mother_sick_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </td>
                <td class="col-practiced">
                    <table class="checkbox-counseled">
                        <tbody>
                            <tr>
                                <td>
                                    <div>{{ record.child_sick_practiced === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>{{ record.mother_sick_practiced === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <!-- Row 13 -->
            <tr>
                <td class="col-practices">13. Continue breastfeeding even beyond 2 years old:
                    <table class="checkbox-container">
                        <tbody>
                            <tr><td><label>(before and after giving complementary food)</label></td></tr>
                        </tbody>
                    </table>
                </td>
                <td class="col-counseled">
                    <table class="checkbox-counseled">
                        <tbody>
                            <tr>
                                <td>
                                    <div>{{ record.continue_breastfeed_beyond_2_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </td>
                <td class="col-practiced">
                    <table class="checkbox-counseled">
                        <tbody>
                            <tr>
                                <td>
                                    <div style="text-align:left ;">No. of breastfeeding per day: <Space/> <Space/> {{ record.continue_breastfeed_beyond_2_practiced }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <!-- Row 14 -->
            <tr>
                <td class="col-practices">14. Health Sanitation/Food Availability:
                    <table class="checkbox-container">
                        <tbody>
                            <tr><td><label> 1. Backyard Gardening</label></td></tr>
                            <tr><td><label> 2. Clean Environment</label></td></tr>
                            <tr><td><label> 3. With Sanitary Toilet</label></td></tr>
                            <tr><td><label> 4. With Potable Water</label></td></tr>                 
                        </tbody>
                    </table>
                </td>
                <td class="col-counseled">
                    <table class="checkbox-counseled">
                        <tbody>
                            <tr>
                                <td>
                                    <div>{{ record.backyard_gardening_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>{{ record.clean_environment_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>{{ record.sanitary_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>{{ record.potable_water_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </td>
                <td class="col-practiced">
                    <table class="checkbox-counseled">
                        <tbody>
                            <tr>
                                <td>
                                    <div>{{ record.backyard_gardening_practiced === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>{{ record.clean_environment_practiced === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>{{ record.sanitary_practiced === 1 ? 'Yes' : 'No' }}</div>
                                </td>   
                            </tr>
                            <tr>
                                <td>
                                    <div>{{ record.potable_water_practiced === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
      </table>
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
.row-12-table thead th:first-child,
.row-12-table tbody td:first-child {
  text-align: center;
  width: 5%;
}
.row-12-table thead th:nth-child(2),
.row-12-table tbody td:nth-child(2){
  text-align: center;
  width: 15%;
}
.row-12-table thead th:nth-child(3),
.row-12-table tbody td:nth-child(3){
  text-align: center;
  width: 15%;
}
.row-12-table thead th:nth-child(4),
.row-12-table tbody td:nth-child(4){
  text-align: center;
  width: 15%;
}
.row-12-table thead th:nth-child(5),
.row-12-table tbody td:nth-child(5){
  text-align: center;
  width: 15%;
}
.row-12-table thead th:nth-child(6),
.row-12-table tbody td:nth-child(6){
  text-align: center;
  width: 15%;
}
.row-12-table thead th:nth-child(7),
.row-12-table tbody td:nth-child(7){
  text-align: center;
  width: 15%;
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
  /* width: 10%; */
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
  text-align: center; /* Align data to the center */
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
.data-practiced-delivery{
  text-align: left;
  margin-left: 20px;
}
.trimester{
  font-weight: normal;
}
</style>