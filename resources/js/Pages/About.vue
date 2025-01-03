<script setup>
defineProps({
    user: String
})
</script>

<template>
    <Head title=" | About"/>
    <div>
        <h1 class= "min-h-screen w-full bg-gradient-to-br from-slate-50 to-sky-300 flex items-center justify-center">
            Hello About, This is about {{ user }} page
        </h1>
    </div>
</template>
