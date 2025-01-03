<template>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Practice</th>
        <th>Counseled</th>
        <th>Practiced</th>
      </tr>
    </thead>
    <tbody>
      <PracticeRow 
        v-for="(practice, index) in practices" 
        :key="index" 
        :practice="practice" 
        :title="practice.title" 
        :options="options" 
        :isNested="practice.isNested" 
        :isDateTested="practice.isDateTested"
        @add="addPractice(index)" 
        @remove="removePractice(index)"
      />
    </tbody>
  </table>
</template>

<script setup>
import { ref } from 'vue';
import PracticeRow from './PracticeRow.vue';

const practices = ref([
  { title: 'Practice 1', counseled: '', counseledDate: '', practiced: '', dates: [], doses: [], isNested: false, isDateTested: false },
  { title: 'Practice 2', counseled: '', counseledDate: '', practiced: '', dates: [], doses: [], isNested: true, isDateTested: false },
  { title: 'Practice 3', counseled: '', counseledDate: '', practiced: '', dates: [], doses: [], isNested: false, isDateTested: true }
]);

const options = ['Option 1', 'Option 2', 'Option 3'];

function addPractice(index) {
  practices.value[index].dates.push({ trimester: '', date: '' });
}

function removePractice(index) {
  practices.value[index].dates.pop();
}
</script>

<style scoped>
.table {
  width: 100%;
  margin-bottom: 1rem;
  color: #212529;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}
</style>
```

<!-- PracticeRow.vue -->
<template>
  <tr>
    <td class="col-practices">{{ title }}</td>
    <td class="col-counseled">
      <RadioGroup v-model="practice.counseled" :options="['Yes', 'No']"/>
      <DateInput v-if="practice.counseled === 'Yes'" v-model="practice.counseledDate"/>
    </td>
    <td class="col-practiced">
      <div v-if="isNested">
        <NestedTable 
          :items="practice.dates || practice.doses" 
          @add="$emit('add')" 
          @remove="$emit('remove')"
          :columns="['Trimester', 'Date']"
          :options="options"
        />
      </div>
      <div v-else-if="isDateTested">
        <label>Date Tested</label>
        <DateInput v-model="practice.dateTested"/>
      </div>
      <div v-else>
        <select v-model="practice.practiced" class="dropdown-pre-natals">
          <option v-for="option in options" :key="option" :value="option">{{ option }}</option>
        </select>
      </div>
    </td>
  </tr>
</template>

<script setup>
import { defineProps } from 'vue';
import RadioGroup from './RadioGroup.vue';
import DateInput from './DateInput.vue';
import NestedTable from './NestedTable.vue';

const props = defineProps({
  practice: Object,
  title: String,
  options: Array,
  isNested: Boolean,
  isDateTested: Boolean
});
</script>

<style scoped>
/* Add any specific styles for the component here */
</style>
