<script setup>
import { ref, computed, onMounted } from 'vue';

const currentMonth = ref(new Date().getMonth());
const currentYear = ref(new Date().getFullYear());
const weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
const monthNames = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];
const today = new Date();
const events = ref({});
const holidays = {
    '01-01': 'New Year\'s Day',
    '04-09': 'Araw ng Kagitingan',
    '05-01': 'Labor Day',
    '06-12': 'Independence Day',
    '08-21': 'Ninoy Aquino Day',
    '11-01': 'All Saints\' Day',
    '11-30': 'Bonifacio Day',
    '12-25': 'Christmas Day',
    '12-30': 'Rizal Day'
};

const daysInMonth = computed(() => {
    return new Array(new Date(currentYear.value, currentMonth.value + 1, 0).getDate()).fill(null).map((_, i) => i + 1);
});
const firstDayOfMonth = computed(() => {
    return new Date(currentYear.value, currentMonth.value, 1).getDay();
});
const blanks = computed(() => {
    return Array(firstDayOfMonth.value).fill(null);
});
const upcomingEvents = computed(() => {
    const today = new Date();
    return Object.values(events.value)
        .filter(event => new Date(event.date) >= today)
        .sort((a, b) => new Date(a.date) - new Date(b.date)); // Sort events by date
});

const allUpcomingEvents = computed(() => {
    const today = new Date();
    return Object.values(events.value).flat()
        .filter(event => new Date(event.date) >= today)
        .sort((a, b) => new Date(a.date) - new Date(b.date)); // Sort events by date
});

const pastEvents = computed(() => {
    const today = new Date();
    return Object.values(events.value).flat()
        .filter(event => new Date(event.date) < today)
        .sort((a, b) => new Date(b.date) - new Date(a.date)); // Sort events by date
});

const prevMonth = () => {
    if (currentMonth.value === 0) {
        currentMonth.value = 11;
        currentYear.value--;
    } else {
        currentMonth.value--;
    }
};
const nextMonth = () => {
    if (currentMonth.value === 11) {
        currentMonth.value = 0;
        currentYear.value++;
    } else {
        currentMonth.value++;
    }
};
const isToday = (day) => {
    return currentYear.value === today.getFullYear() &&
           currentMonth.value === today.getMonth() &&
           day === today.getDate();
};
const isHoliday = (day) => {
    const dateKey = `${String(currentMonth.value + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    return holidays.hasOwnProperty(dateKey);
};
const getHolidayName = (day) => {
    const dateKey = `${String(currentMonth.value + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    return holidays[dateKey] || '';
};

const isRightSidebarOpen = ref(false);
const toggleRightSidebar = () => {
    isRightSidebarOpen.value = !isRightSidebarOpen.value;
};

const newEvent = ref({ date: '', title: '' });

const loadEvents = () => {
    const savedEvents = localStorage.getItem('events');
    if (savedEvents) {
        events.value = JSON.parse(savedEvents);
        // Remove events on January 2 and 9
        const feb30Key = `${currentYear.value}-02-30`;
        const jan9Key = `${currentYear.value}-01-09`;
        if (events.value[feb30Key]) {
            delete events.value[feb30Key];
        }
        if (events.value[jan9Key]) {
            delete events.value[jan9Key];
        }
        saveEvents(); // Save updated events to local storage
    }
};

const saveEvents = () => {
    localStorage.setItem('events', JSON.stringify(events.value));
};

const addEvent = () => {
    if (newEvent.value.date && newEvent.value.title) {
        if (!events.value[newEvent.value.date]) {
            events.value[newEvent.value.date] = [];
        }
        events.value[newEvent.value.date].push({ date: newEvent.value.date, title: newEvent.value.title });
        newEvent.value = { date: '', title: '' };
        isModalOpen.value = false; 
        saveEvents(); // Save events to local storage
    }
};

const isDeleteModalOpen = ref(false);
const confirmedDeleteDate = ref('');

const confirmDelete = (date) => {
    confirmedDeleteDate.value = date;
    isDeleteModalOpen.value = true;
};

const deleteEvent = (date) => {
    const eventIndex = events.value[date].findIndex(event => event.date === date);
    if (eventIndex !== -1) {
        events.value[date].splice(eventIndex, 1);
        if (events.value[date].length === 0) {
            delete events.value[date];
        }
        saveEvents(); // Save events to local storage
    }
    isDeleteModalOpen.value = false;
};

const deletePastEvent = (date) => {
    const eventIndex = events.value[date].findIndex(event => event.date === date);
    if (eventIndex !== -1) {
        events.value[date].splice(eventIndex, 1);
        if (events.value[date].length === 0) {
            delete events.value[date];
        }
        saveEvents(); // Save events to local storage
    }
};

const isModalOpen = ref(false);

const openModal = (day) => {
    newEvent.value.date = `${currentYear.value}-${String(currentMonth.value + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    isModalOpen.value = true;
};

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const hoveredEvents = ref([]);

const showEvents = (day) => {
    const dateKey = `${currentYear.value}-${String(currentMonth.value + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    hoveredEvents.value = events.value[dateKey] || [];
};

const hideEvents = () => {
    hoveredEvents.value = [];
};

const showPastEvents = ref(false);

const togglePastEvents = () => {
    showPastEvents.value = !showPastEvents.value;
};

onMounted(() => {
    loadEvents(); // Load events from local storage on page load
});

</script>


<template>
    <div :class="['rside-bar', 'bg-slate-100', { open: isRightSidebarOpen }]">
        <div class="calendar">
            <div class="calendar-header">
                <button @click="prevMonth" class="nav-button"><i class="fas fa-chevron-left"></i></button>
                <span class="month-year">{{ monthNames[currentMonth] }} {{ currentYear }}</span>
                <button @click="nextMonth" class="nav-button"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="calendar-body">
                <div class="calendar-weekdays">
                    <div v-for="day in weekDays" :key="day">{{ day }}</div>
                </div>
                <div class="calendar-days">
                    <div v-for="blank in blanks" :key="blank" class="calendar-day empty"></div>
                    <div v-for="day in daysInMonth" 
                         :key="day" 
                         :class="{ 'calendar-day': true, 'today': isToday(day), 'holiday': isHoliday(day) }"
                         :title="getHolidayName(day)"
                         @click="openModal(day)">
                        {{ day }}
                        <div v-if="events[`${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`]"
                             class="event-marker"
                             @mouseover="showEvents(day)"
                             @mouseleave="hideEvents">
                            <span class="event-dot" v-for="(event, index) in events[`${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`]" :key="index"></span>
                        </div>
                    </div>
                    <div v-if="hoveredEvents.length" class="hovered-events">
                        <div v-for="(event, index) in hoveredEvents" :key="index">
                            <p>{{ event.title }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="events-section">
            <div class="event-header"> Upcoming Events
            <button @click="togglePastEvents" :class="['toggle-past-events-btn', { active: showPastEvents }]">
                <i :class="showPastEvents ? 'fas fa-calendar-minus' : 'fas fa-calendar-alt'"></i>
            </button>
                </div>
                 
            <div v-for="(event, index) in allUpcomingEvents" :key="index" @click="confirmDelete(event.date)" class="event-item">
                <p class="event-date">{{ formatDate(event.date) }}</p>
                <p class="event-title">{{ event.title }}</p>
            </div>
            <div style="margin-top:25%;"></div>
        </div>
        <div v-if="showPastEvents">
            <div class="past-event-header">Past Events</div>
            <div v-for="(event, index) in pastEvents" :key="index" class="past-event-item">
                <p class="past-event-date">{{ formatDate(event.date) }}</p>
                <p class="past-event-title">{{ event.title }}</p>
                <button @click="deletePastEvent(event.date)">Delete</button>
            </div>
            <div style="margin-top:35%;"></div>
        </div>
    </div>
    <button class="right-sidebar-toggle-btn" @click="toggleRightSidebar">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
            <path d="M120-240v-80h720v80H120Zm0-160v-80h720v80H120Zm0-160v-80h720v80H120Z"/>
        </svg>
    </button>
    <div class="modal" v-if="isModalOpen">
        <div class="modal-content">
            <span class="close" @click="isModalOpen = false">&times;</span>
            <h2>Add Event</h2>
            <form @submit.prevent="addEvent">
                <input type="date" v-model="newEvent.date" required />
                <input type="text" v-model="newEvent.title" placeholder="Event Title" required />
                <button type="submit">Add Event</button>
            </form>
        </div>
    </div>
    <div class="modal" v-if="isDeleteModalOpen">
        <div class="modal-content delete-modal">
            <!-- <span class="close" @click="isDeleteModalOpen = false">&times;</span> -->
            <h2>Confirm Delete</h2>
            <p>Are you sure you want to delete this event?</p>
            <div class="modal-actions">
                <button class="confirm-btn" @click="deleteEvent(confirmedDeleteDate)">Yes</button>
                <button class="cancel-btn" @click="isDeleteModalOpen = false">No</button>
            </div>
        </div>
    </div>
</template>



<style scoped>
.calendar {
    margin: 0 auto;
    text-align: center;
    width: 100%;
    display: flex;
    flex-direction: column;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}
.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #4a90e2;
    color: white;
    font-weight: bold;
}
.nav-button {
    background: none;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
}
.nav-button:hover {
    background-color: #357ab8;
}
.month-year {
    flex-grow: 1;
    text-align: center;
    font-size: 16px;
}
.calendar-body {
    display: flex;
    flex-direction: column;
    background-color: white;
    width: 100%;
    padding: 10px;
}
.calendar-weekdays {
    font-size: 14px;
    color: #4a90e2;
    display: flex;
    flex-wrap: wrap;
    border-bottom: 1px solid #e6e6e6;
    padding-bottom: 5px;
}
.calendar-days {
    font-size: 14px;
    color: #333;
    display: flex;
    flex-wrap: wrap;
}
.calendar-day, .calendar-weekdays div {
    width: 14.28%;
    padding: 5px;
    box-sizing: border-box;
    display: flex;
    justify-content: center;
    align-items: center;
}
.calendar-weekdays div {
    border-right: none;
}
.calendar-day {
    border-right: none;
    cursor: pointer;
}
.calendar-day.today {
    background-color: #4a90e2;
    border-radius: 50%;
    color: white;
    font-weight: bold;
}
.calendar-day.empty {
    background-color: #f9f9f9;
}
.calendar-day.holiday {
    color: #f54949;
    font-weight: bold;
    cursor: pointer;
}
.event-marker {
    display: flex;
    justify-content: center;
    align-items: center;
}
.event-dot {
    width: 5px;
    height: 5px;
    background-color: orange;
    border-radius: 50%;
}
.rside-bar {
    width: 100%;
    max-width: 260px;
    position: fixed; 
    right: 0; 
    top: 7%; 
    z-index: 1;
    padding: 12px 10px;
    box-sizing: border-box;
    border-radius: 10px;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s, transform 0.3s ease-in-out;
    height: 100%; 
    overflow-y: auto; 
    scrollbar-width: none; 
}
.rside-bar.modal-open {
    box-shadow: 0 1px 16px rgba(0, 0, 0, 0.2);
}
.rside-bar.open {
    transform: translateX(0);
}
.rside-bar::-webkit-scrollbar {
    display: none;
}
@media (max-width: 768px) {
    .rside-bar {
        transform: translateX(100%);
    }
    .rside-bar.open {
        transform: translateX(0);
    }
}

.events-section {
    margin-top: 20px;
    text-align: center;
    background-color: #ffffff;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.event-header {
    background-color: #4a90e2;
    padding: 5px;
    color: white;
    font-weight: bold;
    border-radius: 5px;
    text-align: right;
}
.past-event-header {
    background-color: #164d8b;
    padding: 5px;
    color: white;
    font-weight: bold;
    border-radius: 5px;
    text-align: center;
    margin-top: 15px;
}
.event-marker {
    width: 5px;
    height: 5px;
    background-color:orange;
    border-radius: 50%;
    margin-top: 5px;
}
.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
}
.modal-content {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    position: relative;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    max-width: 400px;
    width: 100%;
}
.modal-content.delete-modal {
    max-width: 300px;
    padding: 20px;
}
.modal-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}
.modal-content .confirm-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}
.modal-content .confirm-btn:hover {
    background-color: #c0392b;
}
.modal-content .cancel-btn {
    background-color: #ccc;
    color: #333;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}
.modal-content .cancel-btn:hover {
    background-color: #999;
}
.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
    color: #333;
}
.modal-content h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #4a90e2;
}
.modal-content form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.modal-content input[type="text"],
.modal-content input[type="date"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    width: 100%;
    box-sizing: border-box;
}
.modal-content button {
    padding: 10px;
    background-color: #4a90e2;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}
.modal-content button:hover {
    background-color: #357ab8;
}
@media (max-width: 768px) {
    .rside-bar {
        position: relative;
        right: 0;
        top: 0;
        margin: 0 auto;
    }
}

.right-sidebar-toggle-btn {
    display: none;
    position: fixed;
    top: 10px;
    right: 10px;
    z-index: 1000;
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
}

@media (max-width: 768px) {
    .right-sidebar-toggle-btn {
        display: block;
    }
}
.event-date {
    font-weight: bold;
    margin-top: 5px;
    color:rgb(190, 35, 35);
    font-size:14px;
}

.event-title {
    color: #333; 
    font-size:14px;
}
.past-event-date {
    font-weight: bold;
    margin-top: 5px;
    color:rgb(31, 53, 112);
    font-size:14px;
    text-align: center;
}

.past-event-title {
    color: #333; 
    font-size:14px;
    text-align: center;
}

button {
    margin-top: 5px;
    padding: 5px 10px;
    background-color: #e74c3c;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}
button:hover {
    background-color: #c0392b;
}
.event-item {
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}
.event-item:hover {
    background-color: #f0f0f0;
}
.hovered-events {
    position: absolute;
    background-color: white;
    border: 1px solid #ccc;
    padding: 5px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}
.hovered-events p {
    margin: 0;
    padding: 5px 0;
}
.toggle-past-events-btn {
    margin: 0;
    margin-left: 15px;
    margin-right: 5px;
    padding: 0;
    background-color: #4a90e2;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}
.toggle-past-events-btn:hover {
    background-color: #357ab8;
}
.past-event-item {
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}
/* .past-event-item:hover {
    background-color: #f0f0f0;
} */
.past-event-item button {
    margin-top: 5px;
    padding: 5px 10px;
    background-color: #e74c3c;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}
.past-event-item button:hover {
    background-color: #c0392b;
}
</style>
