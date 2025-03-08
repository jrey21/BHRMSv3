<template>
    <div class="container">
      <div ref="eccdCard" class="card">
        <h2 class="title p-0 ml-2 mr-2">ALWAYS BRING THIS CARD WHEN YOU BRING YOUR CHILD TO THE HEALTH CENTER/CLINIC</h2>
        
        <div class="title-with-logo">
            <div class="logo-section">
            <img src="../Components/image/doh_logo.png" alt="DOH Logo" class="logo" />
          </div>
          <div class="title">
              <h2 class="eccd">The Early Childhood Care</h2>
              <h2 class="eccd">and Development (ECCD) Card</h2>
          </div>
          <div>
            <div class="profile"></div>
          </div>
        </div>
  
        <table class="form-table">
          <tr class="headers">
            <td class="m-0 p-0">Clinic/Health Center: RHU</td>
            <td class="m-0 p-0">Child's No.</td>
          </tr>
          <tr class="headers">
            <td class="m-0 p-0" bg-500-green>Barangay/Purok/Sitio: PATAG (Zone #)</td>
            <td class="m-0 p-0">Family No.</td>
          </tr>
   
        </table>
  
        <!-- <h3>Essential Health and Nutrition Services</h3>
        <table class="services-table">
          <tr>
            <th>Service</th>
            <th>Date Administered</th>
          </tr>
          <tr v-for="(service, index) in formData.services" :key="index">
            <td>{{ service.name }}</td>
            <td><input type="date" v-model="service.date" /></td>
          </tr>
        </table> -->
      </div>
  
      <!-- <button @click="downloadPDF">Download ECCD Card</button> -->
    </div>
  </template>
  
  <script setup>
  import { ref } from "vue";
  import html2canvas from "html2canvas";
  import jsPDF from "jspdf";
  
  const eccdCard = ref(null);
  
  const formData = ref({
    clinic: "",
    barangay: "",
    childName: "",
    motherName: "",
    fatherName: "",
    services: [
      { name: "Newborn Screening", date: "" },
      { name: "BCG Vaccine", date: "" },
      { name: "DPT Vaccine", date: "" },
      { name: "OPV Vaccine", date: "" }
    ]
  });
  
  const downloadPDF = async () => {
    if (!eccdCard.value) return;
  
    html2canvas(eccdCard.value, { scale: 2 }).then((canvas) => {
      const imgData = canvas.toDataURL("image/png");
      const pdf = new jsPDF("p", "mm", "a4");
      pdf.addImage(imgData, "PNG", 10, 10, 190, 250);
      pdf.save("ECCD_Card.pdf");
    });
  };
  </script>
  
<style scoped>
h2.title {
    text-align: center;
    font-size: 24px;
  }
  h2.eccd {
    font-size: 25px;
  }
  .headers {
    text-align: left;
    font-size: 14px;
    margin: 0 1px;
    padding:0;
  }
  .form-table tr:nth-last-child(1) td {
  border-top: none;
}
.form-table tr:nth-last-child(2) td {
  border-bottom: none;
}

  .container {
    text-align: center;
  }
  
  .card {
    width: 80%;
    margin: auto;
    padding: 20px;
    border: 1px solid #ddd;
    background: white;
  }
  
  .title-with-logo {
    display: flex;
    gap:20px;
    align-items: center;
  }
  .logo-section {
    margin-left: 7%;
    margin-top: -38px;
  }
  .logo {
    width: 110px;
    height: 110px;
  }
  .profile {
    width: 110px;
    height: 110px;
    border: 1px solid #ddd;
    margin-top: -38px;
    margin-left: 4px;
  }
  
  .form-table, .services-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }
  
  .form-table td, .services-table th, .services-table td {
    border: 1px solid #ddd;
    padding: 8px;
  }
  
  button {
    margin-top: 20px;
    padding: 10px;
    background: #28a745;
    color: white;
    border: none;
    cursor: pointer;
  }
  </style>
