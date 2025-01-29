<template>
  <div>
    <h1>Pending User Approvals</h1>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>
            <button @click="approveUser(user.id)">Approve</button>
            <button @click="rejectUser(user.id)">Reject</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

export default {
  props: {
    users: Array,
  },
  methods: {
    approveUser(id) {
      if (confirm("Are you sure you want to approve this user?")) {
        Inertia.post(`/admin/approve-user/${id}`);
      }
    },
    rejectUser(id) {
      if (confirm("Are you sure you want to reject this user?")) {
        Inertia.post(`/admin/reject-user/${id}`);
      }
    },
  },
};
</script>
