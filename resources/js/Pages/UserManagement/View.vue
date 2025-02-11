<template>
    <Head title=" | User Management"/>
    <div class="header">
        <h1 class="child-head text-slate-500">User Management</h1>
    </div>

    <div v-if="successMessage" class="success-message">{{ successMessage }}</div>

  <div class="container">
    <div class="filters">

       
    <div class="search-box">
        <i class="fas fa-search" style="margin-left: 8px;"></i>
        <input type="text" v-model="searchQuery" placeholder="Search by name ..." />
    </div>
       

      <select v-model="filterPosition" class="filter-select">
        <option value="">All Positions</option>
        <option value="Admin">Admin</option>
        <option value="Health Worker">Health Worker</option>
      </select>
    </div>

    <table class="user-table">
      <thead>
        <tr>
          <th class="center-align name-column">Name</th>
          <th class="center-align email-column">Email</th>
          <th class="center-align position-column">Position</th>
          <th class="center-align status-column">Status</th>
          <th class="center-align actions-column">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in sortedUsers" :key="user.id">
          <td class="left-align">{{ user.name }}</td>
          <td class="left-align">{{ user.email }}</td>
          <td class="center-align">
            {{ user.position }}
          </td>
          <td class="center-align">
            <span :class="{ active: user.active && user.is_approved !== 0, inactive: !user.active && user.is_approved !== 0, pending: user.is_approved === 0 }">
              {{ user.is_approved === 0 ? 'Pending' : (user.active ? 'Active' : 'Deactivated') }}
            </span>
          </td>
          <td class="center-align">
            <button @click="toggleStatus(user)" class="btn status-btn" :disabled="user.is_approved === 0" :class="{ 'disabled-btn': user.is_approved === 0 }">
              <i :class="user.active ? 'fas fa-toggle-on' : 'fas fa-toggle-off'"></i>
            </button>
            <button @click="deleteUser(user.id)" class="btn delete-btn">
              <i class="fas fa-trash-alt"></i>
            </button>
            <button @click="resetPassword(user.id)" class="btn reset-btn">
              <i class="fas fa-key"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="container">
    <h3 class="subtitle">Audit Logs</h3>
    <ul class="log-list">
      <li v-for="log in logs" :key="log.id" class="log-item">
        {{ log.action }} - {{ log.timestamp }}
      </li>
    </ul>
  </div>

  <div v-if="showDeleteModal" class="modal">
    <div class="modal-content">
      <h2>Confirm Delete</h2>
      <hr style="margin-top: 10px; margin-bottom:10px; padding: 0;">
      <p>Are you sure you want to delete this user <strong style="color:red;">{{ userToDelete.name }}</strong>?</p>
      <div class="modal-buttons">
        <button @click="confirmDelete" class="btn confirm-btn">Delete</button>
        <button @click="cancelDelete" class="btn cancel-btn">Cancel</button>
      </div>
    </div>
  </div>
  <div v-if="showResetModal" class="modal">
    <div class="modal-content">
        <h2>Reset Password</h2>
        <hr style="margin-top: 10px; margin-bottom:10px; padding: 0;">
        <p>Are you sure you want to reset the password for this email <strong style="color:red;">{{ userToReset.email }}</strong> ?</p>
        <div class="modal-buttons">
            <button @click="confirmReset" class="btn confirm-btn">Reset</button>
            <button @click="cancelReset" class="btn cancel-btn">Cancel</button>
        </div>
    </div>
  </div>

  <FlashMessage :show="showSuccessModal" :message="successMessage" />
</template>

<script setup>
import { ref, computed, onMounted, watchEffect } from 'vue';
import axios from 'axios';
import FormLayout from '../../Layouts/FormLayout.vue';
import FlashMessage from '../../Components/FlashMessage.vue';

defineOptions({ layout: FormLayout });

const users = ref([]);
const logs = ref([]);
const searchQuery = ref('');
const filterPosition = ref('');
const sortOrder = ref('asc');

const showDeleteModal = ref(false);
const userToDelete = ref(null);
const showResetModal = ref(false);
const userToReset = ref(null);
const successMessage = ref('');
const showSuccessModal = ref(false);

onMounted(async () => {
  await fetchUsers();
  await fetchLogs();
});

const fetchUsers = async () => {
  const response = await axios.get('/users-data');
  users.value = response.data.map(user => ({
    ...user,
    active: Boolean(user.is_active), // Ensure active is a boolean
    status: user.is_active ? 'Active' : 'Deactivated',
    position: user.position.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '), // Capitalize first letter of each word
  }));
};

const fetchLogs = async () => {
  const response = await axios.get('/audit-logs');
  logs.value = response.data;
};

const filteredUsers = computed(() => {
  return users.value.filter(user =>
    (user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
     user.email.toLowerCase().includes(searchQuery.value.toLowerCase())) &&
    (filterPosition.value === '' || user.position === filterPosition.value)
  );
});

const sortedUsers = computed(() => {
  return filteredUsers.value.sort((a, b) => {
    if (sortOrder.value === 'asc') {
      return a.name.localeCompare(b.name);
    } else {
      return b.name.localeCompare(a.name);
    }
  });
});

const updateUser = async (user) => {
  await axios.put(`/admin/users/${user.id}`, { position: user.position });
  logs.value.push({ action: `Updated ${user.name}'s position`, timestamp: new Date().toISOString() });
};

const toggleStatus = async (user) => {
  user.active = !user.active;
  try {
    await axios.put(`/users/${user.id}/toggle-activation`, { is_active: user.active });
    logs.value.push({ action: `${user.active ? 'Activated' : 'Deactivated'} ${user.name}`, timestamp: new Date().toISOString() });
    if (!user.active) {
      await prohibitLogin(user.id);
    }
  } catch (error) {
    console.error('Error updating user status:', error);
  }
};

watchEffect(async () => {
  for (const user of users.value) {
    await axios.put(`/admin/users/${user.id}`, { is_active: user.active });
    logs.value.push({ action: `${user.active ? 'Activated' : 'Deactivated'} ${user.name}`, timestamp: new Date().toISOString() });

    if (!user.active) {
      await prohibitLogin(user.id);
    }
  }
});

const prohibitLogin = async (id) => {
  await axios.post(`/admin/users/${id}/prohibit-login`);
  logs.value.push({ action: `Prohibited login for user ID: ${id}`, timestamp: new Date().toISOString() });
};

const deleteUser = (id) => {
  userToDelete.value = users.value.find(user => user.id === id);
  showDeleteModal.value = true;
};

const confirmDelete = async () => {
  try {
    await axios.delete(`/delete-users/${userToDelete.value.id}`);
    users.value = users.value.filter(user => user.id !== userToDelete.value.id);
    logs.value.push({ action: `Deleted user ID: ${userToDelete.value.id}`, timestamp: new Date().toISOString() });
    successMessage.value = 'User successfully deleted!';
    showSuccessModal.value = true;
    setTimeout(closeSuccessModal, 3000); 
  } catch (error) {
    console.error('Error deleting user:', error);
  } finally {
    showDeleteModal.value = false;
    userToDelete.value = null;
  }
};

const cancelDelete = () => {
  showDeleteModal.value = false;
  userToDelete.value = null;
};

const resetPassword = (id) => {
  userToReset.value = users.value.find(user => user.id === id);
  showResetModal.value = true;
};

const confirmReset = async () => {
  try {
    await axios.post(`/admin/users/${userToReset.value.id}/reset-password`); 
    logs.value.push({ action: `Reset password for user ID: ${userToReset.value.id}`, timestamp: new Date().toISOString() });
    successMessage.value = 'Password successfully reset!'; 
    showSuccessModal.value = true;
    setTimeout(closeSuccessModal, 3000); 
  } catch (error) {
    console.error('Error resetting password:', error);
  } finally {
    showResetModal.value = false;
    userToReset.value = null;
  }
};

const cancelReset = () => {
  showResetModal.value = false;
  userToReset.value = null;
};

const closeSuccessModal = () => {
  showSuccessModal.value = false;
  successMessage.value = '';
};
</script>

<style scoped>
h2{
    color: #488a99;
    font-size: 18px;
    font-weight: bold;
}
.container {
  max-width: 1200px;
  margin: auto auto auto 5%;
  padding: 20px;
  background: #f8f9fa;
  border-radius: 10px;
  color: #d1d5db;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
  margin-top: 20px;
}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}
.title {
  font-size: 20px; 
  font-weight: bold;
}

.filters {
  display: flex;
  gap: 10px;
  margin-bottom: 10px;
  margin-top: 10px;
  justify-content: space-between; 
}
.search-container {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #f8f9fa;
  border-radius: 50px; 
  padding: 5px 10px; 
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
}

.search-box {
  display: flex;
  align-items: center;
  width: 240px;
  padding: 2px;
  border: 2px solid #9dc0e6;
  border-radius: 50px;
  background-color: #fff;
  box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
  height: 30px; 
}

.search-box i {
  font-size: 14px;
  color: #007bff;
  margin-right: 8px;
}

.search-box input {
  font-size: 14px;
  border: none;
  outline: none;
  color: #333;
  height: 20px; 
}

.search-input:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
}
.filter-select {
  padding: 5px;
  border: 1px solid #5dacfe;
  border-radius: 5px;
  background-color: #79bbff;
  color: white;
  height: 35px; 
  font-size: 14px;
}
.sort-select {
  padding: 10px;
  border: 1px solid #5dacfe;
  border-radius: 5px;
  background-color: #79bbff;
  color: white;
}
.user-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  margin-top: 20px;
  background-color: #f8f9fa; 
  border-radius: 10px;
  overflow: hidden;
  table-layout: fixed; 
}
th, td {
  padding: 5px 16px; 
  border: 1px solid #d1d5db; 
  text-align: center;
  color: #333; 
  font-size: 14px; 
 
}
th {
  background-color: #e2e8f0;
  text-align: center;
}
tbody tr:nth-child(odd) {
  background-color: #f8f9fa; 
}
tbody tr:nth-child(even) {
  background-color: #e2e8f0; 
}
.select-box {
  padding: 5px;
  border: 1px solid #5dacfe;
  border-radius: 5px;
  background-color: #007dff;
  color: white;
  font-size: 14px;
}
.active {
  color: #4caf50;
  font-weight: bold;
}
.inactive {
  color: #e74c3c;
  font-weight: bold;
}
.pending {
  color: #f39c12;
  font-weight: bold;
}
.btn {
  padding: 4px 4px; 
  margin-right: 5px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  font-size: 12px; 
  display: inline-flex; 
  justify-content: center;
  align-items: center;
}
.btn i {
  font-size: 16px; 
}
.status-btn {
  background-color: #4caf50;
  color: white;
}

.delete-btn {
  background-color: #e74c3c;
  color: white;
}
.reset-btn {
  background-color: #3498db;
  color: white;
}
.disabled-btn {
  background-color: gray;
  cursor: not-allowed;
}
.subtitle {
  font-size: 18px; 
  font-weight: bold;
  color: #333;
}
.log-list {
  list-style: none;
  padding: 0;
}
.log-item {
  background: white;
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 5px;
  font-size: 12px; 
  color: #1152b3;
}
.center-align {
  text-align: center;
}
.left-align {
  text-align: left;
}
.avatar-img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
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

.modal-content {
  background-color: #fff;
  margin: auto;
  padding: 20px;
  border: 1px solid #ddd;
  width: 80%;
  max-width: 400px; 
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  animation: fadeIn 0.3s ease-in-out;
  z-index: 1001;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.close {
  color: #333;
  float: right;
  font-size: 24px;
  font-weight: bold;
  cursor: pointer;
  transition: color 0.3s ease;
}

.close:hover,
.close:focus {
  color: #000;
}

.modal-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 5px;
}
.name-column {
  width: 20%;
}
.email-column {
  width: 25%;
}
.position-column {
  width: 20%;
}
.status-column {
  width: 15%;
}
.actions-column {
  width: 15%;
}
.modal-content button {
    margin-top: 20px;
    padding: 8px 12px;
    /* background-color: #007bff; */
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px; 
    transition: background-color 0.3s ease;
}

.modal-content button:hover {
    /* background-color: #0056b3; */
    background-color: #c82333;
}

.modal-content button:last-child {
    /* background-color: #dc3545; */
    background-color: #007bff;
    margin-left: 10px;
}

.modal-content button:last-child:hover {
    /* background-color: #c82333; */
    background-color: #0056b3;
}

.success-message {
  display: none;
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
    z-index: 1000;
}
.flash-content {
    font-size: 16px;
    font-weight: bold;
}
</style>
