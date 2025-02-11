<script setup>
import { App } from '@inertiajs/inertia-vue3';
import AcceptBtn from './AcceptBtn.vue';
import RejectBtn from './RejectBtn.vue';
import Space from './Space.vue';
import { computed } from 'vue';

const props = defineProps({
  users: {
    type: Array,
    required: true,
  },
  title: {
    type: String,
    required: false,
    default: ''
  }
});

const filteredUsers = computed(() => {
  return props.users.filter(user => user.status === 0);
});
const formattedUsers = computed(() => {
  return filteredUsers.value.map(user => ({
    ...user,
    name: capitalizeWords(user.name),
    position: capitalizeWords(user.position)
  }));
});

</script>

<template>
    <div v-for="user in formattedUsers" :key="user.id">
        <div class="outside-box bg-blue-400">
            <div class="inside-box" >
                <p><span class="labels">Approval ID:</span> <span class="data">{{ user.id }}</span> </p>
                <p><span class="labels">Name:</span> <span class="data">{{ user.name }}</span></p>
                <p><span class="labels">Email:</span> <span class="data">{{ user.email }}</span></p>
                <p><span class="labels">Position:</span> <span class="data">{{ user.position }}</span></p>
                <p><span class="labels">Status: </span><span class="data">{{ user.status === 0 ? 'Pending' : user.status }}</span></p>
            </div>

            <div class="buttons mt-2">
                <RejectBtn />
                <AcceptBtn/>
            </div>
        </div>
    </div>

</template>

<style scoped>
.outside-box {
    padding: 15px 15px 8px 15px;
    width: 320px;
    border-radius: 10px;
    border: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.inside-box {
    background-color: white;
    border: none;
    color: #011b76;
    width: 100%;
    height: 140px;
    border-radius: 10px;
    position: relative;
    padding: 10px;
}
.labels {
    font-size: 14px;
    color: #010b2d;
    margin: 0;
}
.data {
    font-size: 14px;
    color: #0034f0;
    margin: 0;
}
.buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 10px;
}

</style>