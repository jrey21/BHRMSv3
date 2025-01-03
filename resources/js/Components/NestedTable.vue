<template>
  <NestedTable :items="items" :columns="columns" :options="options" @add="addItem" @remove="removeItem" />
</template>

<script setup>
import NestedTable from './NestedTable.vue';

const props = defineProps({
  items: Array,
  columns: Array,
  options: Array
});

const emit = defineEmits(['add', 'remove']);

const addItem = () => {
  emit('add');
};

const removeItem = (index) => {
  emit('remove', index);
};
</script>

<style scoped>
.nested-table {
  width: 100%;
  border-collapse: collapse;
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
.nested-table td {
  border: 1px solid #ddd;
  padding: 5px;
  font-style: normal;
  text-align: center;
}
.add-date {
  width: 8%;
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
.dropdown-pre-natal {
  width: 90%;
  padding: 5px;
  border: 1px solid #ccc;
}
</style>
