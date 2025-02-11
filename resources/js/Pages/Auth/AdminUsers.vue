<template>
    <transition name="fade">
        <div v-if="successMessage" class="flash-modal">
            <div class="flash-content">{{ successMessage }}</div>
        </div>
    </transition>
    <Head title=" | Confirm Users "/>
    <div class="header">
        <h1 class="child-head text-slate-500">Pending Users for Approval</h1>
    </div>
    <div class="data-container">
        <div v-if="pendingUsers.length === 0" class="text-gray-500">
            No pending users for approval.
        </div>
        <div v-else class="grid-container">
            <div v-for="user in pendingUsers" :key="user.id" class="grid-item">
                <div 
                    :class="['outside-box', user.position === 'Admin' ? 'bg-sky-600' : 'bg-sky-400']"
                >
                    <div class="inside-box">
                        <p><span class="labels">Approval ID:</span> <span class="data">{{ user.id }}</span> </p>
                        <p><span class="labels">Name:</span> <span class="data">{{ user.name }}</span></p>
                        <p><span class="labels">Email:</span> <span class="data">{{ user.email }}</span></p>
                        <p><span class="labels">Position:</span> <span class="data">{{ user.position }}</span></p>
                        <p><span class="labels">Status: </span><span class="data">{{ user.is_approved === 0 ? 'Pending' : Approved }}</span></p>
                    </div>
                    <div class="buttons mt-2">
                        <button 
                            @click="confirmReject(user)" 
                            class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700"
                        >
                            Reject
                        </button>
                        <button 
                            @click="confirmApprove(user)" 
                            class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700"
                        >
                            Approve
                        </button>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-if="showRejectModal" class="modal">
        <div class="modal-content">
            <h2>Reject User Access?</h2>
            <hr style="margin-top: 10px; margin-bottom:10px; padding: 0;">
            <p>Once rejected, this user <strong style="color: #007bff;">{{ userToReject.name }}</strong> will not be able to log in. <normal style="font-size: 14px; color:red;">Do you want to proceed?</normal></p> 
            <div class="modal-buttons">
                <button @click="closeRejectModal">Cancel</button>
                <button @click="rejectUser(userToReject.id)">Confirm</button>
            </div>
        </div>
    </div>
    <div v-if="showApproveModal" class="modal">
        <div class="modal-content">
            <h2>Confirm User Approval</h2>
            <hr style="margin-top: 10px; margin-bottom:10px; padding: 0;">
            <p>Are you sure you want to approve <strong style="color: #007bff;">{{ userToApprove.name }}</strong>?</p>
            <div class="modal-buttons">
                <button @click="closeApproveModal">Cancel</button>
                <button @click="approveUser(userToApprove.id)">Confirm</button>
                
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import FormLayout from '../../Layouts/FormLayout.vue';

defineOptions({ layout: FormLayout });

const pendingUsers = ref([]);
const successMessage = ref("");
const showRejectModal = ref(false);
const userToReject = ref(null);
const showApproveModal = ref(false);
const userToApprove = ref(null);

const capitalizeWords = (str) => {
    return str.replace(/\b\w/g, char => char.toUpperCase());
};

const fetchPendingUsers = async () => {
    try {
        const response = await axios.get("/admin/pending-users");
        pendingUsers.value = response.data.map(user => ({
            ...user,
            name: capitalizeWords(user.name),
            position: capitalizeWords(user.position)
        }));
    } catch (error) {
        console.error("Error fetching pending users:", error);
    }
};

const approveUser = async (userId) => {
    try {
        await axios.post(`/admin/approve/${userId}`);
        successMessage.value = "User approved successfully!";
        setTimeout(() => {
            successMessage.value = "";
        }, 2000);
        fetchPendingUsers();
        closeApproveModal(); // Close the approve modal
    } catch (error) {
        console.error("Error approving user:", error);
    }
};

const confirmReject = (user) => {
    userToReject.value = user;
    showRejectModal.value = true;
};

const closeRejectModal = () => {
    showRejectModal.value = false;
    userToReject.value = null;
};

const rejectUser = async (userId) => {
    try {
        await axios.post(`/admin/reject/${userId}`);
        successMessage.value = "User rejected successfully!";
        setTimeout(() => {
            successMessage.value = "";
        }, 2000);
        fetchPendingUsers();
        closeRejectModal(); 
    } catch (error) {
        console.error("Error rejecting user:", error);
    }
};

const confirmApprove = (user) => {
    userToApprove.value = user;
    showApproveModal.value = true;
};

const closeApproveModal = () => {
    showApproveModal.value = false;
    userToApprove.value = null;
};

onMounted(() => {
    fetchPendingUsers();
});
</script>

<style scoped>
h2 {
    color: #488a99;
    font-size: 18px;
    font-weight: bold;
}
.data-container {
    margin-left: 5%;
    margin-right: auto;
    width: fit-content;
    padding: 20px;
    margin-top: 0;
    margin-bottom: 15%;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    margin-left: 5%;
    margin-top: 1%;
}
.child-head {
    font-size: 20px;
}
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
    font-size: 14px;
}
.flash-modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 1001;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
}
.flash-content {
    position: fixed;
    top: 10px;
    background-color: #28a745;
    color: #fff;
    padding: 20px;
    border: 1px solid #28a745;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    font-size: 16px;
    font-weight: bold;
    max-width: 500px;
    margin: 0 auto;
    animation: slideDown 0.5s ease-in-out;
    
}
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
.grid-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
.grid-item {
    display: flex;
    justify-content: center;
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

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 5px;
}

.modal-content button {
    margin-top: 20px;
    padding: 8px 12px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px; 
    transition: background-color 0.3s ease;
}

.modal-content button:hover {
    background-color: #c82333;
}

.modal-content button:last-child {
    background-color: #007bff;
    margin-left: 10px;
}

.modal-content button:last-child:hover {
    background-color: #0056b3;
}
</style>
