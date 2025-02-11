<template>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td :class="{'active': user.is_active, 'inactive': !user.is_active}">
            {{ user.is_active ? 'Active' : 'Inactive' }}
          </td>
          <td>
            <button @click="toggleActivation(user.id)">
              {{ user.is_active ? 'Deactivate' : 'Activate' }}
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const users = ref([]);
  
  const fetchUsers = async () => {
    const response = await axios.get('/users-data');
    users.value = response.data;
  };
  
  const toggleActivation = async (id) => {
    try {
      const response = await axios.post(`/users/${id}/toggle-activation`);
      const updatedUser = users.value.find(user => user.id === id);
      updatedUser.is_active = response.data.is_active;
    } catch (error) {
      console.error('Error toggling user activation:', error);
    }
  };
  
  onMounted(fetchUsers);
  </script>
  
  <style scoped>
  .active {
    color: green;
  }
  .inactive {
    color: red;
  }
  </style>
  