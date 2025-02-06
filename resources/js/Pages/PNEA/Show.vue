<script setup>
import { defineProps, ref, onMounted, computed } from 'vue';
import FormLayout from '../../Layouts/FormLayout.vue';
import Enrollment from './Enrollment.vue';
import PregnancyPeriod from './PregnancyPeriod.vue';
import LactatingPeriod from './LactatingPeriod.vue';
// import OPData from './OPData.vue';


defineOptions({
    layout: FormLayout,
});

const props = defineProps({
    pnea: { type: Object, required: true },
});

const showTables = ref(false);
const flashMessage = ref('');
const showFlashMessage = ref(false);

const toggleTables = () => {
    showTables.value = !showTables.value;
};

</script>

<template>
    <Head title=" | Maternal Care" />

    <div class="name-header">
        <transition name="fade">
                <h3 v-if="pnea?.fullName" class="pnea-head text-slate-500">
                Records of <strong style="color: #007bff;"> {{ pnea.fullName }}</strong> 
                </h3>
            </transition>

        <transition name="fade">
                <button class="t-btn" @click="toggleTables">
                    {{ showTables ? 'Hide' : 'View' }}
                </button>
        </transition>
    </div>

    <!-- Enrollment -->
    <transition name="fade">
        <div v-if="showTables && pnea">
            <Enrollment :pnea="pnea" />
        </div>
    </transition>
    
    <!-- Pregnancy -->
     <PregnancyPeriod :pnea="pnea"/>

    <!-- Lactating -->
    <LactatingPeriod :pnea="pnea"/>

</template>

<style scoped>
.pnea-head {
    font-size: 20px;
    margin-top: 15px;
}

.t-btn {
    margin-top: 22px;
}

.name-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    margin-left: 20px;
}
</style>
