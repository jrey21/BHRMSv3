<script setup>
const model = defineModel();
defineProps({
    label: String,
    icon: String,
    placeholder: {
        type: String,
        default: " ",
    },
    type: {
        type: String,
        default: "text",
    },
});
</script>

<template>
    <div style="width: 100%;">
        <label
            :for="label"
            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2"
        >
            {{ label }}
        </label>

        <div class="relative mt-1 rounded-md">
            <div
                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                style="width: 2.5rem; margin-right: 20px;"
            >
                <span class="grid place-content-center text-sm text-slate-400">
                    <i :class="`fa-solid fa-${icon}`"></i>
                </span>
            </div>
            <input
                :type="type"
                :name="label"
                :placeholder="placeholder"
                v-model="model"
                class="block w-full rounded-md pr-3 pl-12 text-sm dark:text-slate-900 border-slate-300 outline-0 focus:ring-1 focus:ring-inset focus:ring-indigo-400 focus:border-indigo-400 placeholder:text-slate-400"
                style="padding-left: 35px;"
            />
        </div>
    </div>
</template>