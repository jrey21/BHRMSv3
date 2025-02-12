<template>
    <!-- Flash Message -->
    <div v-if="showFlashMessage" :class="['flash-message', { error: isError }]">
        {{ flashMessage }}
    </div>
    <div v-if="pnea">
        <h1 style="margin-top: 20px; margin-left:20px;">Personal Information <Space/>
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
                    <span v-if="!isEditing">{{ editablePneaattedBirthDate }}</span>
                    <input v-else type="date" v-model="editablePnea.birth_date" class="short-input" />
                </p>
                <p class="width-20">
                    <strong class="labels">Age:</strong> <Space />
                    <span>{{ calculateAge(pnea.birth_date) }} years</span>
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
                    <select v-else v-model="editablePnea.term_of_pregnancy" class="short-input">
                        <option value="1st Trimester">1st Trimester</option>
                        <option value="2nd Trimester">2nd Trimester</option>
                        <option value="3rd Trimester">3rd Trimester</option>
                    </select>
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
                    <span v-if="!isEditing">{{ editablePneaattedLastDeliveryDate }}</span>
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
                    <select v-else v-model="editablePnea.monthly_family_income" class="short-input">
                        <option value="Below 10,000">Below 10,000</option>
                        <option value="10,000-20,000">10,000 - 20,000</option>
                        <option value="20,000-30,000">20,000 - 30,000</option>
                        <option value="30,000-40,000">30,000 - 40,000</option>
                        <option value="Above 40,000">Above 40,000</option>
                    </select>
                </p>
                <p class="width-50">
                    <strong class="labels">Household Size:</strong> <Space />
                    <span v-if="!isEditing">{{ pnea.household_size }}</span>
                    <input v-else v-model="editablePnea.household_size" class="short-input" />
                </p>
            </div>
        </div>
        <div class="card">
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
                                <div>{{ pnea.prenatal_care_counseled === 1 ? 'Yes' : 'No' }}</div>
                                <div v-if="pnea.prenatal_care_counseled === 1">{{ formatDate(pnea.prenatal_care_date_counseled) }}</div>
                        </td>
                        <td class="col-practiced">
                            <div class="data-practiced">
                                <span v-if="!isEditing">{{ capitalize(pnea.prenatal_care_practiced) }}</span>
                                <select v-else v-model="editablePnea.prenatal_care_practiced" class="dropdown-pre-natals">
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
                            <div>{{ pnea.prenatal_check_up_counseled === 1 ? 'Yes' : 'No' }}</div>
                            <div v-if="pnea.prenatal_check_up_counseled === 1">{{ formatDate(pnea.prenatal_check_up_date_counseled) }}</div>
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
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.prenatal_care_date_1) }}</div>
                                    <input v-else v-model="editablePnea.prenatal_care_date_1" type="date" class="date-input add-date"/>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.prenatal_care_date_2) }}</div>
                                    <input v-else v-model="editablePnea.prenatal_care_date_2" type="date" class="date-input add-date"/>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.prenatal_care_date_3) }}</div>
                                    <input v-else v-model="editablePnea.prenatal_care_date_3" type="date" class="date-input add-date"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.prenatal_care_date_4) }}</div>
                                    <input v-else v-model="editablePnea.prenatal_care_date_4" type="date" class="date-input add-date"/>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.prenatal_care_date_5) }}</div>
                                    <input v-else v-model="editablePnea.prenatal_care_date_5" type="date" class="date-input add-date"/>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.prenatal_care_date_6) }}</div>
                                    <input v-else v-model="editablePnea.prenatal_care_date_6" type="date" class="date-input add-date"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.prenatal_care_date_7) }}</div>
                                    <input v-else v-model="editablePnea.prenatal_care_date_7" type="date" class="date-input add-date"/>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.prenatal_care_date_8) }}</div>
                                    <input v-else v-model="editablePnea.prenatal_care_date_8" type="date" class="date-input add-date"/>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.prenatal_care_date_9) }}</div>
                                    <input v-else v-model="editablePnea.prenatal_care_date_9" type="date" class="date-input add-date"/>
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
                            <div>{{ pnea.iron_folic_acid_counseled === 1 ? 'Yes' : 'No' }}</div>
                            <div v-if="iron_folic_counseled === 1">{{ formatDate(pnea.iron_folic_acid_date_counseled) }}</div>
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
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.iron_folic_acid_date_1) }}</div>
                                    <input v-else v-model="editablePnea.iron_folic_acid_date_1" type="date" class="date-input add-date"/>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.iron_folic_acid_date_2) }}</div>
                                    <input v-else v-model="editablePnea.iron_folic_acid_date_2" type="date" class="date-input add-date"/>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.iron_folic_acid_date_3) }}</div>
                                    <input v-else v-model="editablePnea.iron_folic_acid_date_3" type="date" class="date-input add-date"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.iron_folic_acid_date_4) }}</div>
                                    <input v-else v-model="editablePnea.iron_folic_acid_date_4" type="date" class="date-input add-date"/>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.iron_folic_acid_date_5) }}</div>
                                    <input v-else v-model="editablePnea.iron_folic_acid_date_5" type="date" class="date-input add-date"/>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.iron_folic_acid_date_6) }}</div>
                                    <input v-else v-model="editablePnea.iron_folic_acid_date_6" type="date" class="date-input add-date"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.iron_folic_acid_date_7) }}</div>
                                    <input v-else v-model="editablePnea.iron_folic_acid_date_7" type="date" class="date-input add-date"/>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.iron_folic_acid_date_8) }}</div>
                                    <input v-else v-model="editablePnea.iron_folic_acid_date_8" type="date" class="date-input add-date"/>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.iron_folic_acid_date_9) }}</div>
                                    <input v-else v-model="editablePnea.iron_folic_acid_date_9" type="date" class="date-input add-date"/>
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
                            <div>{{ pnea.iodized_salt_counseled === 1 ? 'Yes' : 'No' }}</div>
                            <div v-if="pnea.iodized_salt_counseled === 1" >{{formatDate( pnea.iodized_salt_date_counseled) }}</div>
                        </td>
                        <td class="col-practiced">
                            <strong class="data-practiced-delivery">Date Tested:  <Space/> <Space/> <Space/> <Space/> </strong>
                            <span v-if="!isEditing">{{ formatDate(pnea.iodized_salt_practiced) }}</span>
                            <input v-else v-model="editablePnea.iodized_salt_practiced" type="date" class="date-tested"/>
                        </td>
                    </tr>

                     <!-- Row 5 -->
                    <tr>
                        <td class="col-practices">5. With Tetanus Toxoid vaccination</td>
                        <td class="col-counseled">
                            <div>{{ pnea.tetanus_counseled === 1 ? 'Yes' : 'No' }}</div>
                            <div v-if="pnea.tetanus_counseled === 1">{{ formatDate(pnea.tetanus_date_counseled) }}</div>
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
                                   <div>1st Dose</div>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.dose_date_1) }}</div>
                                    <input v-else v-model="editablePnea.dose_date_1" type="date" class="date-input add-date"/>
                                </td>     
                            </tr>
                            <tr>
                                <td>
                                    <div>2nd Dose</div>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.dose_date_2) }}</div>
                                    <input v-else v-model="editablePnea.dose_date_2" type="date" class="date-input add-date"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>3rd Dose</div>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.dose_date_3) }}</div>
                                    <input v-else v-model="editablePnea.dose_date_3" type="date" class="date-input add-date"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>4th Dose</div>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.dose_date_4) }}</div>
                                    <input v-else v-model="editablePnea.dose_date_4" type="date" class="date-input add-date"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>5th Dose</div>
                                </td>
                                <td>
                                    <div v-if="!isEditing">{{ formatDate(pnea.dose_date_5) }}</div>
                                    <input v-else v-model="editablePnea.dose_date_5" type="date" class="date-input add-date"/>
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
                                <tr><td><input type="checkbox" :checked="pnea.initiation === 1" disabled> Initiation</td></tr>      
                                <tr><td><input type="checkbox" :checked="pnea.exclusivity === 1" disabled> Exclusivity</td></tr>
                                <tr><td><input type="checkbox" :checked="pnea.duration === 1" disabled> Duration</td></tr>
                                <tr><td><input type="checkbox" :checked="pnea.dietary_intake === 1" disabled> Dietary Intake</td></tr>
                                <tr><td><input type="checkbox" :checked="pnea.personal_willingness === 1" disabled> Personal Willingness</td></tr>
                                <tr><td><input type="checkbox" :checked="pnea.family_support === 1" disabled> Family Support</td></tr>
                            </tbody>
                        </table>
                        </td>
                        <td class="col-counseled">
                        <table class="checkbox-counseled">
                            <tbody>
                                <tr>
                                <td>
                                    <div>{{ pnea.initiation_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                                </tr>
                                <tr>
                                <td>
                                    <div>{{ pnea.exclusivity_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                                </tr>
                                <tr>
                                <td>
                                    <div>{{ pnea.duration_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                                </tr>
                                <tr>
                                <td>
                                    <div>{{ pnea.dietary_intake_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                                </tr>
                                <tr>
                                <td>
                                    <div>{{ pnea.personal_willingness_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                                </tr>
                                <tr>
                                <td>
                                    <div>{{ pnea.family_support_counseled === 1 ? 'Yes' : 'No' }}</div>
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
                                <td v-if="!isEditing" style="font-size: 11px;">{{ formatDateTime(pnea.initiation_start_date_practiced) }}</td>
                                <td v-else><input v-model="editablePnea.initiation_start_date_practiced" type="datetime-local" class="datetime-local"/></td>
                                <td v-if="!isEditing" style="font-size: 11px;">{{ formatDateTime(pnea.initiation_end_date_practiced) }}</td>
                                <td v-else><input v-model="editablePnea.initiation_end_date_practiced" type="datetime-local" class="datetime-local"/></td>
                            </tr>
                            <tr>
                                <td>Exclusivity</td>
                                <td v-if="!isEditing" style="font-size: 11px;">{{ formatDateTime(pnea.exclusivity_start_date_practiced) }}</td>
                                <td v-else><input v-model="editablePnea.exclusivity_start_date_practiced" type="datetime-local" class="datetime-local"/></td>
                                <td v-if="!isEditing" style="font-size: 11px;">{{ formatDateTime(pnea.exclusivity_end_date_practiced) }}</td>
                                <td v-else><input v-model="editablePnea.exclusivity_end_date_practiced" type="datetime-local" class="datetime-local"/></td>
                            </tr>
                            <tr>
                                <td>Duration</td>
                                <td v-if="!isEditing" style="font-size: 11px;">{{ formatDateTime(pnea.duration_start_date_practiced) }}</td>
                                <td v-else><input v-model="editablePnea.duration_start_date_practiced" type="datetime-local" class="datetime-local"/></td>
                                <td v-if="!isEditing" style="font-size: 11px;">{{ formatDateTime(pnea.duration_end_date_practiced) }}</td>
                                <td v-else><input v-model="editablePnea.duration_end_date_practiced" type="datetime-local" class="datetime-local"/></td>
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
                                <tr><td><input type="checkbox" :checked="pnea.proper_infant === 1" disabled> Proper Infant and Young Child Feeding</td></tr>
                                <tr><td><input type="checkbox" :checked="pnea.nutripak === 1" disabled> NUTRIPAK Utilization</td></tr>
                                <tr><td><input type="checkbox" :checked="pnea.health_nutrition === 1" disabled> Health,Nutrition and Food Safety</td></tr>
                                <tr><td><input type="checkbox" :checked="pnea.membership === 1" disabled> Membership in Peer Counseling Group</td></tr>
                                <tr><td><input type="checkbox" :checked="pnea.plant_malunggay === 1" disabled> Plant-Malunggay-Project</td></tr>
                                <tr><td><Space/>{{ pnea.other_interventions }}</td></tr>
                            </tbody>
                        </table>
                        </td>
                        <td class="col-counseled">
                        <table class="checkbox-counseled">
                            <tbody>
                                <tr>
                                <td>
                                    <div>{{ pnea.proper_infant_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                                </tr>
                                <tr>
                                <td>
                                    <div>{{ pnea.nutripak_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                                </tr>
                                <tr>
                                <td>
                                    <div>{{ pnea.health_nutrition_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                                </tr>
                                <tr>
                                <td>
                                    <div>{{ pnea.membership_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                                </tr>
                                <tr>
                                <td>
                                    <div>{{ pnea.plant_malunggay_counseled === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                                </tr>
                                <tr>
                                <td>
                                    <div>{{ pnea.other_interventions_counseled === 1 ? 'Yes' : 'No' }}</div>
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
                                    <div style="text-align: center;">{{ pnea.proper_infant_practiced === 1 ? 'Yes' : 'No' }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td>No. of recipes cooked with NUTRIPAK</td>
                                <td>
                                    <div style="text-align: center;" v-if="!isEditing">{{ pnea.nutripak_practiced }}</div>
                                    <input v-else v-model="editablePnea.nutripak_practiced" type="number" class="short-input" />
                                </td>
                            </tr>
                            <tr class="small-row">
                                <td>Health,Nutrition and Food Safety</td>
                                <td>
                                    <div style="text-align: center;">{{ pnea.health_nutrition_practiced === 1 ? 'Yes' : 'No'}}</div>
                                </td>
                            </tr>
                            <tr class="small-row">
                                <td>Membership in Peer Counseling Group</td>
                                <td>
                                    <div>Member: <Space/> {{ pnea.membership_member_practiced === 1 ? 'Yes' : 'No'}}</div>
                                    <div>Leader: <Space/> {{ pnea.membership_leader_practiced  === 1 ? 'Yes' : 'No' }}</div>            
                                </td>
                            </tr>
                            <tr>
                                <td>No. of Malunggay Trees Planted </td>
                                <td>
                                    <div style="text-align: center;" v-if="!isEditing">{{ pnea.plant_malunggay_number_practiced }}</div>
                                    <input v-else v-model="editablePnea.plant_malunggay_number_practiced" type="number" class="short-input" />
                                </td>
                            </tr>
                            <tr>
                                <td>Date Planted</td>
                                <td>
                                    <div style="text-align: center;" v-if="!isEditing">{{formatDate( pnea.date_planted_practiced) }}</div>
                                    <input v-else v-model="editablePnea.date_planted_practiced" type="date" class="date-input add-date"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Location</td>
                                <td> 
                                    <div style="text-align: center;" v-if="!isEditing">{{ pnea.location_practiced }}</div>
                                    <input v-else v-model="editablePnea.location_practiced" type="text" class="short-input-loc" />
                                </td>
                            </tr>
                            <tr class="small-row">
                                <td>{{pnea.other_interventions }}</td>
                                <td>
                                    <div style="text-align: center;">{{ pnea.other_interventions_practiced === 1 ? 'Yes': 'No'}}</div>
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
                            <div>{{ pnea.postnatal_checkup_counseled === 1 ? 'Yes' : 'No' }}</div>
                            <div v-if="pnea.postnatal_checkup_counseled === 1">{{ formatDate(pnea.postnatal_checkup_date_counseled) }}</div>
                        </td>
                        <td class="col-practiced">
                            <label style="text-align: left;">Date of last check up: <Space/><Space/> 
                                <span style="font-weight: normal;" v-if="!isEditing">{{ formatDate(pnea.postnatal_last_checkup_date_practiced) }}</span>
                                <input v-else v-model="editablePnea.postnatal_last_checkup_date_practiced" type="date"/>
                            </label>
                        </td>
                    </tr>
                    <!-- Row 9 -->
                    <tr>
                        <td class="col-practices">9. Iron Supplementation</td>
                        <td class="col-counseled">
                            <div>{{ pnea.iron_supplementation_counseled === 1 ? 'Yes' : 'No' }}</div>
                            <div v-if="pnea.iron_supplementation_counseled === 1">{{ formatDate(pnea.iron_supplementation_date_counseled) }}</div>
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
                                <div v-if="!isEditing">{{ pnea.iron_supplementation_amount_practiced }}</div>
                                <input v-else v-model="editablePnea.iron_supplementation_amount_practiced" type="number" class="short-input" />
                                </td>
                                <td>
                                <div v-if="!isEditing">{{ formatDate(pnea.iron_supplementation_last_date_taken_practiced )}}</div>
                                <input v-else v-model="editablePnea.iron_supplementation_last_date_taken_practiced" type="date" />
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
                            <div>{{ pnea.breastfeeding_initiation_counseled === 1 ? 'Yes' : 'No' }}</div>
                            <div v-if="pnea.breastfeeding_initiation_counseled === 1">{{ formatDate(pnea.breastfeeding_initiation_date_counseled) }}</div>
                        </td>
                        <td class="col-practiced">
                        <div class="data-practiced-delivery">
                            <label><input type="checkbox" :checked="pnea.normal_delivery === 1" disabled> Normal Delivery (within half an hour)</label>
                            <label><input type="checkbox" :checked="pnea.cs_delivery === 1" disabled> CS Delivery (within 1 hour)</label>
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
                                        <div>{{ pnea.given_colostrums === 1 ? 'Yes' : 'No' }}</div>                         
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>
                                        <div>{{ pnea.no_water_given === 1 ? 'Yes' : 'No' }}</div>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>
                                        <div>{{ pnea.no_food_given === 1 ? 'Yes' : 'No' }}</div>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>
                                        <div>{{ pnea.no_vitamins_given === 1 ? 'Yes' : 'No' }}</div>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>
                                        <div>{{ pnea.no_formula_milk_given === 1 ? 'Yes' : 'No' }}</div>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>
                                        <div>{{ pnea.no_other_liquid_given === 1 ? 'Yes' : 'No' }}</div>
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
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_colostrums_1 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_colostrums_1" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_colostrums_2 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_colostrums_2" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_colostrums_3 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_colostrums_3" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_colostrums_4 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_colostrums_4" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_colostrums_5 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_colostrums_5" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_colostrums_6 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_colostrums_6" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_water_1 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_water_1" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_water_2 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_water_2" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_water_3 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_water_3" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_water_4 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_water_4" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_water_5 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_water_5" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_water_6 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_water_6" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_food_1 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_food_1" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_food_2 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_food_2" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_food_3 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_food_3" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_food_4 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_food_4" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_food_5 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_food_5" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_food_6 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_food_6" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_vitamins_1 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_vitamins_1" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_vitamins_2 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_vitamins_2" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_vitamins_3 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_vitamins_3" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_vitamins_4 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_vitamins_4" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_vitamins_5 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_vitamins_5" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_vitamins_6 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_vitamins_6" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_formula_milk_1 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_formula_milk_1" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_formula_milk_2 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_formula_milk_2" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_formula_milk_3 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_formula_milk_3" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_formula_milk_4 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_formula_milk_4" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_formula_milk_5 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_formula_milk_5" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_formula_milk_6 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_formula_milk_6" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6.</td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_other_liquid_1 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_other_liquid_1" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_other_liquid_2 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_other_liquid_2" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_other_liquid_3 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_other_liquid_3" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_other_liquid_4 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_other_liquid_4" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_other_liquid_5 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_other_liquid_5" class="yes-no">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div v-if="!isEditing">{{ pnea.exclusive_breastfeeding_other_liquid_6 }}</div>
                                            <select v-else v-model="editablePnea.exclusive_breastfeeding_other_liquid_6" class="yes-no">
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
                                            <div>{{ pnea.child_sick_counseled === 1 ? 'Yes' : 'No' }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>{{ pnea.mother_sick_counseled === 1 ? 'Yes' : 'No' }}</div>
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
                                            <div>{{ pnea.child_sick_practiced === 1 ? 'Yes' : 'No' }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>{{ pnea.mother_sick_practiced === 1 ? 'Yes' : 'No' }}</div>
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
                                            <div>{{ pnea.continue_breastfeed_beyond_2_counseled === 1 ? 'Yes' : 'No' }}</div>
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
                                            <div style="text-align:left ;">No. of breastfeeding per day: <Space/> <Space/> 
                                                <span v-if="!isEditing">{{ pnea.continue_breastfeed_beyond_2_practiced }}</span>
                                                <input v-else v-model="editablePnea.continue_breastfeed_beyond_2_practiced" type="number" class="short-input" />
                                            </div>
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
                                            <div>{{ pnea.backyard_gardening_counseled === 1 ? 'Yes' : 'No' }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>{{ pnea.clean_environment_counseled === 1 ? 'Yes' : 'No' }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>{{ pnea.sanitary_counseled === 1 ? 'Yes' : 'No' }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>{{ pnea.potable_water_counseled === 1 ? 'Yes' : 'No' }}</div>
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
                                            <div>{{ pnea.backyard_gardening_practiced === 1 ? 'Yes' : 'No' }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>{{ pnea.clean_environment_practiced === 1 ? 'Yes' : 'No' }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>{{ pnea.sanitary_practiced === 1 ? 'Yes' : 'No' }}</div>
                                        </td>   
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>{{ pnea.potable_water_practiced === 1 ? 'Yes' : 'No' }}</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
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

const formatDate = (dateString) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
};

const formatDateTime = (dateTimeString) => {
    if (!dateTimeString) return '-';
    const date = new Date(dateTimeString);
    return date.toLocaleString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });
};

const editablePneaattedBirthDate = computed(() => formatDate(props.pnea.birth_date));
const editablePneaattedLastDeliveryDate = computed(() => formatDate(props.pnea.date_last_delivery));

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

const calculateAge = (birthDate) => {
    if (!birthDate) return '-';
    const birth = new Date(birthDate);
    const today = new Date();
    let age = today.getFullYear() - birth.getFullYear();
    const monthDifference = today.getMonth() - birth.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birth.getDate())) {
        age--;
    }
    return age;
};
</script>


<style scoped>
h2 {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
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
  margin-left:20px;
  margin-bottom: 5%;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color:red;
  /* background-color: #f9f9f9; */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  position: relative;
}
.info-table {
  width: 100%; 
  border-collapse: collapse;
  margin-bottom: 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  font-size: 14px;
  margin-left: 0; 
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
  text-transeditablePnea: none;
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
    padding: 15px 10px;
    margin-left: 20px;
    margin-bottom: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 10px;
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
