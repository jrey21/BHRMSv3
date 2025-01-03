<template>
    <nav id="sidebar" :class="{ open: isSidebarOpen }">
        <div class="sidebar-content">
            <ul>
                <!-- <li>
                    <span class="logo">BHRMS</span>
                    <button onclick=toggleSidebar(this) id="toggle-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M440-240 200-480l240-240 56 56-183 184 183 184-56 56Zm264 0L464-480l240-240 56 56-183 184 183 184-56 56Z"/></svg>
                    </button>
                </li> -->
                <div style="margin-bottom: 20%;"></div>
                
                <li :class="{ active: isActive('dashboard') }">
                    <Link :href="route('dashboard')" @click="setActive('dashboard')">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/>
                        </svg>
                        Dashboard
                    </Link>
                </li>
                <!-- Category -->
                <h3 class="categories">Forms</h3>
                <hr>
                <li :class="{ active: isActive('comprehensive-survey') }">
                    <Link :href="route('comprehensive-survey')" @click="setActive('comprehensive-survey')">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M720-240q25 0 42.5-17.5T780-300q0-25-17.5-42.5T720-360q-25 0-42.5 17.5T660-300q0 25 17.5 42.5T720-240Zm0 120q32 0 57-14t42-39q-20-16-45.5-23.5T720-204q-28 0-53.5 7.5T621-173q17 25 42 39t57 14Zm-520 0q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v268q-19-9-39-15.5t-41-9.5v-243H200v560h242q3 22 9.5 42t15.5 38H200Zm0-120v40-560 243-3 280Zm80-40h163q3-21 9.5-41t14.5-39H280v80Zm0-160h244q32-30 71.5-50t84.5-27v-3H280v80Zm0-160h400v-80H280v80ZM720-40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Z"/>
                        </svg>
                       Comprehensive Form
                    </Link>

                </li>
                <li :class="{ active: isActive('childcare-form') }">
                    <Link :href="route('childcare-form')" @click="setActive('childcare-form')">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M720-240q25 0 42.5-17.5T780-300q0-25-17.5-42.5T720-360q-25 0-42.5 17.5T660-300q0 25 17.5 42.5T720-240Zm0 120q32 0 57-14t42-39q-20-16-45.5-23.5T720-204q-28 0-53.5 7.5T621-173q17 25 42 39t57 14Zm-520 0q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v268q-19-9-39-15.5t-41-9.5v-243H200v560h242q3 22 9.5 42t15.5 38H200Zm0-120v40-560 243-3 280Zm80-40h163q3-21 9.5-41t14.5-39H280v80Zm0-160h244q32-30 71.5-50t84.5-27v-3H280v80Zm0-160h400v-80H280v80ZM720-40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Z"/>
                        </svg>
                       ECCD Form
                    </Link>

                </li>
                <li :class="{ active: isActive('pnea-enrollment') }">
                    <Link :href="route('pnea-enrollment')" @click="setActive('pnea-enrollment')">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M720-240q25 0 42.5-17.5T780-300q0-25-17.5-42.5T720-360q-25 0-42.5 17.5T660-300q0 25 17.5 42.5T720-240Zm0 120q32 0 57-14t42-39q-20-16-45.5-23.5T720-204q-28 0-53.5 7.5T621-173q17 25 42 39t57 14Zm-520 0q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v268q-19-9-39-15.5t-41-9.5v-243H200v560h242q3 22 9.5 42t15.5 38H200Zm0-120v40-560 243-3 280Zm80-40h163q3-21 9.5-41t14.5-39H280v80Zm0-160h244q32-30 71.5-50t84.5-27v-3H280v80Zm0-160h400v-80H280v80ZM720-40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Z"/>
                        </svg>
                       PNEA Enrollment Form
                    </Link>

                </li>
                <!-- <li class="active">
                    <Link :href="route('age-grouping')">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M720-240q25 0 42.5-17.5T780-300q0-25-17.5-42.5T720-360q-25 0-42.5 17.5T660-300q0 25 17.5 42.5T720-240Zm0 120q32 0 57-14t42-39q-20-16-45.5-23.5T720-204q-28 0-53.5 7.5T621-173q17 25 42 39t57 14Zm-520 0q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v268q-19-9-39-15.5t-41-9.5v-243H200v560h242q3 22 9.5 42t15.5 38H200Zm0-120v40-560 243-3 280Zm80-40h163q3-21 9.5-41t14.5-39H280v80Zm0-160h244q32-30 71.5-50t84.5-27v-3H280v80Zm0-160h400v-80H280v80ZM720-40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Z"/>
                        </svg>
                       Age Grouping
                    </Link>

                </li> -->
                <h3 class="categories">Care Services</h3>
                <hr>
                <li class="actives">
                    <button class="dropdown-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M280-240h80v-80h80v-80h-80v-80h-80v80h-80v80h80v80Zm240-140h240v-60H520v60Zm0 120h160v-60H520v60ZM160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm280-440h80v-200h-80v200Zm40 220Z"/>
                        </svg>
                        <span>Maternal Care</span>
                        <svg class="arrow-down" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/>
                        </svg>
                    </button>
                    <ul class="sub-menu">
                        <li :class="{ active: isActiveSubLink('pnea-enrollment-view') }"><Link :href="route('pnea-enrollment-view')" @click="setActiveSubLink('pnea-enrollment-view')">Pregnant Women</Link></li>
                        <li :class="{ active: isActiveSubLink('monitoring-form') }"><a href="#" @click="setActiveSubLink('monitoring-form')">Monitoring Form</a></li>
                        <li :class="{ active: isActiveSubLink('breastfeeding') }"><a href="#" @click="setActiveSubLink('breastfeeding')">Breastfeeding</a></li>
                    </ul>
                </li>

                <li :class="{ active: isActive('childcare-form-view') }">
                    <Link :href="route('childcare-form-view')" @click="setActive('childcare-form-view')">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M480-880q83 0 155.5 31.5t127 86q54.5 54.5 86 127T880-480q0 82-31.5 155t-86 127.5q-54.5 54.5-127 86T480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-155.5t86-127Q252-817 325-848.5T480-880Zm0 720q133 0 226.5-93.5T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160Zm-80-520q0 33 23.5 56.5T480-600q33 0 56.5-23.5T560-680q0-33-23.5-56.5T480-760q-33 0-56.5 23.5T400-680Zm80 120q-53 0-116.5 26T300-460v160q0 44 63 74t137 24v-80q-35 2-66-5t-54-21q5-23 35-37.5t65-14.5q35 0 67.5 16t32.5 42v82q44-16 62-38.5t18-41.5v-160q0-48-63.5-74T480-560Zm0 180q-21 0-35.5-14.5T430-430q0-21 14.5-35.5T480-480q21 0 35.5 14.5T530-430q0 21-14.5 35.5T480-380Zm0-100Z"/>
                        </svg>
                        Child Care Data
                    </Link>

                </li>
                <h3 class="categories">Records Management</h3>
                <hr>
                <li class="actives">
                    <button class="dropdown-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M280-240h80v-80h80v-80h-80v-80h-80v80h-80v80h80v80Zm240-140h240v-60H520v60Zm0 120h160v-60H520v60ZM160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm280-440h80v-200h-80v200Zm40 220Z"/></svg>
                        <span>Medical Records</span>
                        <svg class="arrow-down2" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
                    </button>
                    <ul class="sub-menu">
                        <li :class="{ active: isActiveSubLink('vaccination-record') }"> <Link :href="route('vaccination-record')"@click="setActiveSubLink('vaccination-record')">List of Vaccinated</Link></li>
                        <li :class="{ active: isActiveSubLink('growth-monitoring') }"> <Link :href="route('growth-monitoring')"@click="setActiveSubLink('growth-monitoring')">Growth Monitoring</Link></li>
                        <li :class="{ active: isActiveSubLink('age-grouping-view') }"> <Link :href="route('age-grouping-view')"@click="setActiveSubLink('age-grouping-view')">Age Grouping</Link></li>
                    </ul>
                </li>
                <li class="actives">
                    <button class="dropdown-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M720-240q25 0 42.5-17.5T780-300q0-25-17.5-42.5T720-360q-25 0-42.5 17.5T660-300q0 25 17.5 42.5T720-240Zm0 120q32 0 57-14t42-39q-20-16-45.5-23.5T720-204q-28 0-53.5 7.5T621-173q17 25 42 39t57 14Zm-520 0q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v268q-19-9-39-15.5t-41-9.5v-243H200v560h242q3 22 9.5 42t15.5 38H200Zm0-120v40-560 243-3 280Zm80-40h163q3-21 9.5-41t14.5-39H280v80Zm0-160h244q32-30 71.5-50t84.5-27v-3H280v80Zm0-160h400v-80H280v80ZM720-40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Z"/></svg>
                        <span>Census Records</span>
                        <svg class="arrow-down3" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
                    </button>
                    <ul class="sub-menu">
                        <li :class="{ active: isActiveSubLink('comprehensive-survey-view') }"> <Link :href="route('comprehensive-survey-view')"@click="setActiveSubLink('comprehensive-survey-view')">List of Residents</Link></li>
                        <li :class="{ active: isActiveSubLink('pwd-view') }"><Link :href="route('pwd-view')"@click="setActiveSubLink('pwd-view')">List of PWD's</Link></li>
                        <li :class="{ active: isActiveSubLink('senior-citizen-view') }"> <Link :href="route('senior-citizen-view')"@click="setActiveSubLink('senior-citizen-view')">List of Senior Citizen</Link></li>
                        <li :class="{ active: isActiveSubLink('four-ps-view') }"><Link :href="route('four-ps-view')"@click="setActiveSubLink('four-ps-view')">List of 4P's</Link></li>
                    </ul>
                </li>
                <h3 class="categories">User Administration</h3>
                <hr>
                <li class="actives">
                    <a href="#" class="menu">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z"/></svg>
                        <span>Confirm Users</span>
                    </a>
                </li>
                <li class="actives">
                    <a href="#" class="menu">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z"/></svg>
                        <span>User Management</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <button id="mobile-toggle-btn" @click="toggleMobileSidebar">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
            <path d="M120-240v-80h720v80H120Zm0-160v-80h720v80H120Zm0-160v-80h720v80H120Z"/>
        </svg>
    </button>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import { watch } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link
    },
    data() {
        return {
            activeLink: '',
            activeSubLink: '',
            isSidebarOpen: false
        };
    },
    mounted() {
        this.initDropdowns();
        this.initSidebarToggle();
        this.setActiveFromRoute();
        this.$root.$on('reinitializeSidebar', this.reinitializeSidebar);
        const page = usePage();
        watch(() => page.props.auth.user, (newUser, oldUser) => {
            if (newUser && !oldUser) {
                this.refreshPage();
            }
        });
    },
    updated() {
        this.initDropdowns();
    },
    watch: {
        $route() {
            this.setActiveFromRoute();
            this.reinitializeSidebar();
        }
    },
    methods: {
        initDropdowns() {
            const dropdowns = document.querySelectorAll(".dropdown-btn");
            dropdowns.forEach((dropdown) => {
                dropdown.removeEventListener("click", this.toggleDropdown); // Remove existing event listener
                dropdown.addEventListener("click", this.toggleDropdown); // Add new event listener
            });
        },
        toggleDropdown(event) {
            const dropdown = event.currentTarget;
            const subMenu = dropdown.nextElementSibling;
            if (subMenu) {
                subMenu.classList.toggle("show");
            }
            dropdown.classList.toggle("active");

            // Close other dropdowns
            const dropdowns = document.querySelectorAll(".dropdown-btn");
            dropdowns.forEach((otherDropdown) => {
                if (otherDropdown !== dropdown) {
                    const otherSubMenu = otherDropdown.nextElementSibling;
                    if (otherSubMenu) {
                        otherSubMenu.classList.remove("show");
                    }
                    otherDropdown.classList.remove("active");
                }
            });
        },
        initSidebarToggle() {
            const toggleButton = document.getElementById("toggle-btn");
            const sidebar = document.getElementById("sidebar");
            toggleButton.addEventListener("click", () => {
                sidebar.classList.toggle("close");
                toggleButton.classList.toggle("rotate-180");
            });
        },
        navigateTo(routeName) {
            this.$emit('navigate', routeName);
        },
        setActive(routeName) {
            this.activeLink = routeName;
            this.activeSubLink = ''; 
            this.updateActiveClass();
            this.showDropdownForActiveLink(routeName);
            this.$nextTick(() => {
                this.initDropdowns(); // Ensure dropdowns are initialized after setting active link
            });
        },
        setActiveSubLink(subLinkName) {
            this.activeSubLink = subLinkName;
            this.updateActiveClass();
            this.showDropdownForActiveLink(subLinkName);
            this.$nextTick(() => {
                this.initDropdowns(); // Ensure dropdowns are initialized after setting active sublink
            });
        },
        isActive(routeName) {
            return this.activeLink === routeName;
        },
        isActiveSubLink(subLinkName) {
            return this.activeSubLink === subLinkName;
        },
        setActiveFromRoute() {
            const currentRoute = this.$route.name;
            const subRoutes = ['pnea-enrollment-view', 'monitoring-form', 'breastfeeding'];
            if (subRoutes.includes(currentRoute)) {
                this.activeLink = 'maternal-care';
                this.activeSubLink = currentRoute;
            } else {
                this.activeLink = currentRoute;
                this.activeSubLink = '';
            }
            this.updateActiveClass();
        },
        updateActiveClass() {
            const links = document.querySelectorAll('li');
            links.forEach(link => {
                link.classList.remove('active');
            });
            const activeLink = document.querySelector(`li > a[href="${this.$route.fullPath}"]`);
            if (activeLink) {
                activeLink.closest('li').classList.add('active');
            }
            const activeSubLink = document.querySelector(`.sub-menu li > a[href="${this.$route.fullPath}"]`);
            if (activeSubLink) {
                activeSubLink.closest('li').classList.add('active');
                activeSubLink.closest('.sub-menu').classList.add('show');
                activeSubLink.closest('.dropdown-btn').classList.add('active');
            }
            // Ensure dropdown buttons are clickable even when an active link is selected
            this.$nextTick(() => {
                this.initDropdowns();
            });
        },
        reinitializeSidebar() {
            this.initDropdowns();
            this.initSidebarToggle();
            this.setActiveFromRoute();
        },
        refreshPage() {
            window.location.reload();
        },
        handleBackButtonClick() {
            window.history.back();
            this.reinitializeSidebar();
        },
        toggleMobileSidebar() {
            this.isSidebarOpen = !this.isSidebarOpen;
        },
        showDropdownForActiveLink(routeName) {
            const dropdowns = document.querySelectorAll(".dropdown-btn");
            dropdowns.forEach((dropdown) => {
                const subMenu = dropdown.nextElementSibling;
                if (subMenu && subMenu.querySelector(`a[href="${this.$route.fullPath}"]`)) {
                    subMenu.classList.add("show");
                    dropdown.classList.add("active");
                }
            });
        },
    },
    beforeDestroy() {
        this.$root.$off('reinitializeSidebar', this.reinitializeSidebar);
    }
};
</script>

<style scoped>
#sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 250px;
    transition: transform 0.3s ease-in-out;
    font-size: 15px;
    color: #333;
    overflow: hidden; /* Prevent content overflow */
    /* z-index:999; Ensure it stays below the navbar */
}

.sidebar-content {
    overflow-y: auto; /* Enable vertical scrolling */
    height: 120vh; /* Full height to ensure scrolling works */
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
</style>

