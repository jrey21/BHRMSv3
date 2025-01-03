<template>
  <table class="checkbox-container">
    <tr v-for="item in items" :key="item.label">
      <td>
        <label>
          <input :type="item.type || 'checkbox'" v-model="formData[item.model]" :value="item.value || 'Yes'"> 
          {{ item.label }}
        </label>
      </td>
    </tr>
  </table>
</template>

<script setup>
const props = defineProps(['items']);
const formData = ref({});
</script>

<style scoped>
.checkbox-container tr td {
  white-space: normal;
  word-wrap: break-word;
}
</style>
