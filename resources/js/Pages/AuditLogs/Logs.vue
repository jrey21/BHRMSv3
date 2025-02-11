<template>
    <div>
      <h2>Audit Logs</h2>
      <table>
        <thead>
          <tr>
            <th>User</th>
            <th>Action</th>
            <th>Details</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="log in logs" :key="log.id">
            <td>{{ log.user.name }}</td>
            <td>{{ log.action }}</td>
            <td>{{ log.details }}</td>
            <td>{{ new Date(log.created_at).toLocaleString() }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const logs = ref([]);
  
  const fetchLogs = async () => {
    const response = await axios.get('/audit-logs');
    logs.value = response.data;
  };
  
  onMounted(fetchLogs);
  </script>
  