<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const maternalCareOpen = ref(false);
const medicalRecordsOpen = ref(false);
const censusRecordsOpen = ref(false);
const sidebarOpen = ref(false);

const closeOtherDropdowns = (currentMenu) => {
    if (currentMenu !== 'maternalCare') maternalCareOpen.value = false;
    if (currentMenu !== 'medicalRecords') medicalRecordsOpen.value = false;
    if (currentMenu !== 'censusRecords') censusRecordsOpen.value = false;
};

const toggleDropdown = (menu) => {
    closeOtherDropdowns(menu);
    if (menu === 'maternalCare') {
        maternalCareOpen.value = !maternalCareOpen.value;
        if (maternalCareActive.value) maternalCareOpen.value = true;
    } else if (menu === 'medicalRecords') {
        medicalRecordsOpen.value = !medicalRecordsOpen.value;
        if (medicalRecordsActive.value) medicalRecordsOpen.value = true;
    } else if (menu === 'censusRecords') {
        censusRecordsOpen.value = !censusRecordsOpen.value;
        if (censusRecordsActive.value) censusRecordsOpen.value = true;
    }
};

const toggleForm = () => {
    forms.value = !forms.value;
};

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

const isActive = (routeName) => {
    return usePage().props.value.route === routeName;
};

// const forms = computed(() => {
//     return isActive('comprehensive-survey') || isActive('childcare-form') || isActive('pnea-enrollment');
// });
const maternalCareActive = computed(() => {
    return isActive('pnea-enrollment-view') || isActive('monitoring-form') || isActive('breastfeeding');
});

const medicalRecordsActive = computed(() => {
    return isActive('vaccination-record') || isActive('growth-monitoring') || isActive('age-grouping-view');
});

const censusRecordsActive = computed(() => {
    return isActive('comprehensive-survey-view') || isActive('pwd-view') || isActive('senior-citizen-view') || isActive('four-ps-view');
});

const activeLink = ref(null);

const setActiveLink = (link) => {
    if (activeLink.value) {
        activeLink.value.classList.remove('active');
    }
    activeLink.value = link;
    activeLink.value.classList.add('active');
};
</script>


<template>
    <button id="mobile-toggle-btn" @click="toggleSidebar">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
            <path d="M120-240v-80h720v80H120Zm0-160v-80h720v80H120Zm0-160v-80h720v80H120Z"/>
        </svg>
    </button>
    <nav id="sidebar" :class="{ open: sidebarOpen }">
        <div class="sidebar-content">
            <ul>
                <!-- <div style="margin-bottom: 20%;"></div> -->
                <li>
                    <Link :href="route('userDashboard')" class="menu" :class="{ active: route().current('dashboard') }" @click="setActiveLink($event.target.closest('.menu'))">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/>
                        </svg>
                        Dashboard
                    </Link>
                </li>
                <li>
                    <Link :href="route('financial-assistance')" class="menu" :class="{ active: route().current('financial-assistance') }" @click="setActiveLink($event.target.closest('.menu'))">
                        <i class="fas fa-hand-holding-usd mr-3 ml-2"></i>
                        Financial Assistance
                    </Link>
                </li>
                <!-- Category -->
                <h3 class="categories">Forms</h3>
                <hr>
                <li>
                    <Link :href="route('comprehensive-survey')" class="menu" :class="{ active: route().current('comprehensive-survey') }" @click="setActiveLink($event.target.closest('.menu'))">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M720-240q25 0 42.5-17.5T780-300q0-25-17.5-42.5T720-360q-25 0-42.5 17.5T660-300q0 25 17.5 42.5T720-240Zm0 120q32 0 57-14t42-39q-20-16-45.5-23.5T720-204q-28 0-53.5 7.5T621-173q17 25 42 39t57 14Zm-520 0q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v268q-19-9-39-15.5t-41-9.5v-243H200v560h242q3 22 9.5 42t15.5 38H200Zm0-120v40-560 243-3 280Zm80-40h163q3-21 9.5-41t14.5-39H280v80Zm0-160h244q32-30 71.5-50t84.5-27v-3H280v80Zm0-160h400v-80H280v80ZM720-40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Z"/>
                        </svg>
                        Comprehensive Form
                    </Link>
                </li>
                <li>
                    <Link :href="route('childcare-form')" class="menu" :class="{ active: route().current('childcare-form') }" @click="setActiveLink($event.target.closest('.menu'))">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M720-240q25 0 42.5-17.5T780-300q0-25-17.5-42.5T720-360q-25 0-42.5 17.5T660-300q0 25 17.5 42.5T720-240Zm0 120q32 0 57-14t42-39q-20-16-45.5-23.5T720-204q-28 0-53.5 7.5T621-173q17 25 42 39t57 14Zm-520 0q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v268q-19-9-39-15.5t-41-9.5v-243H200v560h242q3 22 9.5 42t15.5 38H200Zm0-120v40-560 243-3 280Zm80-40h163q3-21 9.5-41t14.5-39H280v80Zm0-160h244q32-30 71.5-50t84.5-27v-3H280v80Zm0-160h400v-80H280v80ZM720-40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Z"/>
                        </svg>
                       ECCD Form
                    </Link>
                </li>
                <li>
                    <Link :href="route('pnea-enrollment')" class="menu" :class="{ active: route().current('pnea-enrollment') }" @click="setActiveLink($event.target.closest('.menu'))">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M480-880q83 0 155.5 31.5t127 86q54.5 54.5 86 127T880-480q0 82-31.5 155t-86 127.5q-54.5 54.5-127 86T480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-155.5t86-127Q252-817 325-848.5T480-880Zm0 720q133 0 226.5-93.5T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160Zm-80-520q0 33 23.5 56.5T480-600q33 0 56.5-23.5T560-680q0-33-23.5-56.5T480-760q-33 0-56.5 23.5T400-680Zm80 120q-53 0-116.5 26T300-460v160q0 44 63 74t137 24v-80q-35 2-66-5t-54-21q5-23 35-37.5t65-14.5q35 0 67.5 16t32.5 42v82q44-16 62-38.5t18-41.5v-160q0-48-63.5-74T480-560Zm0 180q-21 0-35.5-14.5T430-430q0-21 14.5-35.5T480-480q21 0 35.5 14.5T530-430q0 21-14.5 35.5T480-380Zm0-100Z"/>
                        </svg>
                        PNEA Enrollment Form
                    </Link>
                </li>
                <h3 class="categories">Care Services</h3>
                <hr>
                <li>
                    <Link :href="route('childcare-form-view')" class="menu" :class="{ active: route().current('childcare-form-view') }" @click="setActiveLink($event.target.closest('.menu'))">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M480-880q83 0 155.5 31.5t127 86q54.5 54.5 86 127T880-480q0 82-31.5 155t-86 127.5q-54.5 54.5-127 86T480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-155.5t86-127Q252-817 325-848.5T480-880Zm0 720q133 0 226.5-93.5T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160Zm-80-520q0 33 23.5 56.5T480-600q33 0 56.5-23.5T560-680q0-33-23.5-56.5T480-760q-33 0-56.5 23.5T400-680Zm80 120q-53 0-116.5 26T300-460v160q0 44 63 74t137 24v-80q-35 2-66-5t-54-21q5-23 35-37.5t65-14.5q35 0 67.5 16t32.5 42v82q44-16 62-38.5t18-41.5v-160q0-48-63.5-74T480-560Zm0 180q-21 0-35.5-14.5T430-430q0-21 14.5-35.5T480-480q21 0 35.5 14.5T530-430q0 21-14.5 35.5T480-380Zm0-100Z"/>
                        </svg>
                        Child Care Data
                    </Link>
                </li>
                <li>
                    <button class="dropdown-btn" :class="{ active: maternalCareOpen }" @click="toggleDropdown('maternalCare')">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M280-240h80v-80h80v-80h-80v-80h-80v80h-80v80h80v80Zm240-140h240v-60H520v60Zm0 120h160v-60H520v60ZM160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm280-440h80v-200h-80v200Zm40 220Z"/>
                        </svg>
                        <span>Maternal Care</span>
                        <svg class="arrow-down" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/>
                        </svg>
                    </button>
                    <ul :class="{ 'sub-menu': true, 'show': maternalCareOpen }">
                        <hr style="margin-top: 7px; margin-bottom: 5px;">
                        <li><Link :href="route('pnea-enrollment-view')" class="menu" :class="{ active: route().current('pnea-enrollment-view') }" @click="setActiveLink($event.target.closest('.menu'))">Pregnant Mothers</Link></li>
                        <li><Link :href="route('monitoring-form')" class="menu" :class="{active: route().current('monitoring-form')}" @click="setActiveLink($event.target.closest('.menu'))">Pregnant Monitoring</Link></li>
                        <li><Link :href="route('lactating-form')" class="menu" :class="{active: route().current('lactating-form')}" @click="setActiveLink($event.target.closest('.menu'))">Lactating Mothers</Link></li>
                    </ul>
                </li>

                <h3 class="categories">Records Management</h3>
                <hr>
                <li>
                    <button class="dropdown-btn" :class="{ active: medicalRecordsOpen }" @click="toggleDropdown('medicalRecords')">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M280-240h80v-80h80v-80h-80v-80h-80v80h-80v80h80v80Zm240-140h240v-60H520v60Zm0 120h160v-60H520v60ZM160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm280-440h80v-200h-80v200Zm40 220Z"/></svg>
                        <span>Medical Records</span>
                        <svg class="arrow-down2" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
                    </button>
                    <ul :class="{ 'sub-menu': true, 'show': medicalRecordsOpen }">
                        <hr style="margin-top: 7px; margin-bottom: 5px;">
                        <li> <Link :href="route('vaccination-record')" class="menu" :class="{ active: route().current('vaccination-record') }" @click="setActiveLink($event.target.closest('.menu'))">List of Vaccinated</Link></li>
                        <li> <Link :href="route('growth-monitoring')" class="menu" :class="{ active: route().current('growth-monitoring') }" @click="setActiveLink($event.target.closest('.menu'))">Growth Monitoring</Link></li>
                    </ul>
                </li>
                <li>
                    <button class="dropdown-btn" :class="{ active: censusRecordsOpen }" @click="toggleDropdown('censusRecords')">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M720-240q25 0 42.5-17.5T780-300q0-25-17.5-42.5T720-360q-25 0-42.5 17.5T660-300q0 25 17.5 42.5T720-240Zm0 120q32 0 57-14t42-39q-20-16-45.5-23.5T720-204q-28 0-53.5 7.5T621-173q17 25 42 39t57 14Zm-520 0q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v268q-19-9-39-15.5t-41-9.5v-243H200v560h242q3 22 9.5 42t15.5 38H200Zm0-120v40-560 243-3 280Zm80-40h163q3-21 9.5-41t14.5-39H280v80Zm0-160h244q32-30 71.5-50t84.5-27v-3H280v80Zm0-160h400v-80H280v80ZM720-40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Z"/></svg>
                        <span>Census Records</span>
                        <svg class="arrow-down3" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
                    </button>
                   
                    <ul :class="{ 'sub-menu': true, 'show': censusRecordsOpen }">
                        <hr style="margin-top: 7px; margin-bottom: 5px;">
                        <li> <Link :href="route('comprehensive-survey-view')" class="menu" :class="{ active: route().current('comprehensive-survey-view') }" @click="setActiveLink($event.target.closest('.menu'))">List of Residents</Link></li>
                        <li><Link :href="route('pwd-view')" class="menu" :class="{ active: route().current('pwd-view') }" @click="setActiveLink($event.target.closest('.menu'))">List of PWD's</Link></li>
                        <li> <Link :href="route('senior-citizen-view')" class="menu" :class="{ active: route().current('senior-citizen-view') }" @click="setActiveLink($event.target.closest('.menu'))">List of Senior Citizen</Link></li>
                        <li><Link :href="route('four-ps-view')" class="menu" :class="{ active: route().current('four-ps-view') }" @click="setActiveLink($event.target.closest('.menu'))">List of 4P's</Link></li>
                        <li> <Link :href="route('age-grouping-view')" class="menu" :class="{ active: route().current('age-grouping-view') }" @click="setActiveLink($event.target.closest('.menu'))">Age Grouping</Link></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

</template>



<style scoped>
#sidebar{
    position:fixed;
    padding:1% 0;
    width: 250px;
    font-size: 15px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    height: 100%;
    color: #333;
    overflow: hidden; 
    background-color: hwb(206 89% 5%);
    transition: transform 0.3s ease-in-out;
    /* z-index:999; */
}

.sidebar-content {
    overflow-y: auto; 
    overflow-x: hidden; 
    height: calc(100vh - 100px);  
}

#sidebar.close {
    transform: translateX(-100%);
}

@media (max-width: 768px) {
    #sidebar {
        transform: translateX(-100%);
    }
    #sidebar.open {
        transform: translateX(0);
    }
    #mobile-toggle-btn {
        position: fixed;
        top: 10px;
        left: 10px;
        background: none;
        border: none;
        cursor: pointer;
        z-index: 1000;
    }
}

li.active {
    background-color: white;
    border-left: 4px solid #007bff;
    color: #007bff;
}

.menu.active {
    background-color: white;
    border-left: 4px solid #007bff;
    color: #007bff;
    left: 0;
    width: 110%;
    margin: 0;
    padding: 0;
}

.sub-menu li.active {
    background-color: white;
    border-left: 4px solid #007bff;
    color: #0056b3;
}

.categories {
    font-size: 15px;
    font-weight: bold;
    color: #0a407a;
    margin-top: 20px;
    margin-left: 5px;
    margin-bottom: 5px;
}

hr {
    border: 1px solid; 
    opacity: 10%;
}

#sidebar ul {
    list-style-type: none;
    padding: 0;
}

#sidebar ul li{
    align-items: center;
    padding: 10px;
    /* margin-left: 3px; */
}

#sidebar ul li a {
    text-decoration: none;
    display: flex;
    align-items: center;
    padding: 1px 0;
    /* margin-left: 1px; */
}

#sidebar ul li a svg {
    margin-right: 10px;
}

#sidebar ul li a:hover {
    @apply  bg-blue-400 text-white;
}

#sidebar a.menu:hover svg {
    fill: white;
    @apply bg-blue-400 text-white;
}

#sidebar ul li .dropdown-btn svg{
    margin-right: 10px;
}

.menu{
    padding:0;
    margin:0;
    display:flex;
    align-items:center;
}

.dropdown-btn {
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    white-space: nowrap; 
}

.dropdown-btn svg:first-child {
    order: 1;
}

.dropdown-btn span {
    order: 2;
    flex-grow: 1;
    text-align: left;
}
.dropdown-btn:hover,
.dropdown-btn:hover svg {
    fill: white;
    @apply bg-blue-400 text-white;
}
/* .dropdown-btn.active,
.dropdown-btn.active svg {
    @apply bg-blue-400 text-white;
    fill: white;
} */

.dropdown-btn svg:last-child {
    order: 3;
    transform: rotate(0);
}

.dropdown-btn.active svg:last-child {
    transform: rotate(180deg);
    background-color: none;
}

/* .sub-menu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
    opacity: 0;
} */

.sub-menu.show {
    max-height: 500px; 
    opacity: 1;
}

.arrow-down {
    margin-left:50px;
    margin-right: 0;
    padding: 0;
}
.arrow-down2 {
    margin-left:35px;
    margin-right: 0;
    padding: 0;
}
.arrow-down3 {
    margin-left:39px;
}

@media (max-width: 768px) {
    #sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 250px;
        transform: translateX(-100%);
    }
    #sidebar.open {
        transform: translateX(0);
    }
}

.sub-menu{
    margin-left: 11%;
}

#mobile-toggle-btn {
    position: fixed;
    top: 10px;
    left: 10px;
    background: none;
    border: none;
    cursor: pointer;
    z-index: 1000;
}

</style>

