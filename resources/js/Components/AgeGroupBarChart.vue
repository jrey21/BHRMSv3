<template>
    <div>
      <BarChart v-if="chartData" :chart-data="chartData" :chart-options="chartOptions" />
    </div>
  </template>
  
  <script setup>
  import { computed, defineProps } from "vue";
  import { Bar } from "vue-chartjs";
  import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
  } from "chart.js";
  
  // Register required components
  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);
  
  // Define props
  const props = defineProps({
    ageGroups: Object, // Computed age groups data
  });
  
  // Compute chart data
  const chartData = computed(() => ({
    labels: Object.keys(props.ageGroups), 
    datasets: [
      {
        label: "Male",
        backgroundColor: "#3498db",
        data: Object.values(props.ageGroups).map(group => group.male),
      },
      {
        label: "Female",
        backgroundColor: "#e74c3c",
        data: Object.values(props.ageGroups).map(group => group.female),
      }
    ]
  }));
  
  // Chart options
  const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { position: "top" }
    },
    scales: {
      x: { title: { display: true, text: "Age Groups" } },
      y: { title: { display: true, text: "Number of People" }, beginAtZero: true }
    }
  };
  </script>
  