<template>
  <div class="qr-scanner">
    <!-- <button class="scan-button" :class="{ start: !isScanning, stop: isScanning }" @click="toggleScanning">
      {{ isScanning ? 'Stop Scanning' : 'Start Scanning' }}
    </button> -->
    <!-- <button class="save-button" @click="saveScannedData">Save Scanned Data</button> -->
    <p class="error">{{ error }}</p>

    <!-- <p class="flash-message" v-if="flashMessage">{{ flashMessage }}</p> -->
    

    <div v-if="isScanning" class="qr-scanner-video">
      <p class="error" v-if="invalidQrMessage">{{ invalidQrMessage }}</p>
      <qrcode-stream
        :constraints="selectedConstraints"
        :track="trackFunctionSelected.value"
        @error="onError"
        @detect="onDetect"
        @camera-on="onCameraReady"
      />
    </div>
    <button class="scan-button" :class="{ start: !isScanning, stop: isScanning }" @click="toggleScanning">
      {{ isScanning ? 'Stop Scanning' : 'Start Scanning' }}
    </button>
  </div>
  <div v-if="isScanning" class="data-container">
    <div class="action-bar-match">
      <!-- Display current date and time -->
      <div class="date-time">
          <span class="weekday">{{ currentDateTime.weekday }}</span> | {{ currentDateTime.date }}
      </div>
      
      <!-- Search -->
      <div class="search-container-match">
          <div class="search-box-match">
              <i class="fas fa-search" style="margin-left: 8px;"></i>
              <input type="text" v-model="searchQuery" placeholder="Search by name ..." />
          </div>
      </div>
    </div>

    <!-- Matched Scanned Data Table -->
    <div class="scrollable-table-match">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>Zone</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="matchedScannedData.length === 0">
                    <td colspan="6">No senior citizens data found</td>
                </tr>
                <tr v-for="senior in matchedScannedData" :key="senior.id">
                    <td>{{ senior.id }}</td>
                    <td>{{ senior.first_name.charAt(0).toUpperCase() + senior.first_name.slice(1) + " " + senior.last_name.charAt(0).toUpperCase() + senior.last_name.slice(1) }}</td>
                    <td>{{ senior.age_display }}</td>
                    <td>{{ senior.sex.charAt(0).toUpperCase() }}</td>
                    <td>{{ senior.zone }}</td>
                    <td>{{ senior.status }}</td> 
                </tr>
            </tbody>
        </table>
    </div>
  </div>

 <!-- Senior List Table -->
  <div v-if="!isScanning" class="data-container">
    <div class="action-bar">
      <div class="search-container">
          <div class="search-box">
              <i class="fas fa-search" style="margin-left: 8px;"></i>
              <input type="text" v-model="searchQuery" placeholder="Search by name ..." />
          </div>
      </div>
      <div class="button-group">
          <select v-model="sortOption" class="sort-select">
              <option value="">Sort By</option>
              <option value="asc">Name (A-Z)</option>
              <option value="desc">Name (Z-A)</option>
              <option value="age">Age</option>
              <option value="zone">Zone</option>
          </select>
          <button @click="downloadPDF" class="download-button">
              <i class="fas fa-download"></i>
          </button>
      </div>
  </div>
        <div class="scrollable-table">
        <table class="data-table">
            <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Age</th>
                  <th>Sex</th>
                  <th>Zone</th>
                  <th>Status</th>
                </tr>
            </thead>
            <tbody>
                    <tr v-if="sortedData.length === 0">
                        <td colspan="6">No senior citizens data found</td>
                    </tr>
                    <tr v-for="senior in sortedData" :key="senior.id">
                      <td>{{ senior.id }}</td>
                      <td>{{ senior.first_name.charAt(0).toUpperCase() + senior.first_name.slice(1) + " " + senior.last_name.charAt(0).toUpperCase() + senior.last_name.slice(1) }}</td>
                      <td>{{ senior.age_display }}</td>
                      <td>{{ senior.sex.charAt(0).toUpperCase() }}</td>
                      <td>{{ senior.zone }}</td>
                      <td style="color: green; font-weight: bold;">{{ senior.status }}</td>
                    </tr>
                </tbody>
        </table>
        </div>
        <div class="pagination">
            <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1">
                <i class="fas fa-chevron-left"></i>
            </button>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

  <div v-if="showAlreadyScannedModal" class="modal-overlay">
    <div class="modal-content">
      <p>Already Scanned</p>
      <button @click="closeModal">Close</button>
    </div>
  </div>
</template>

<script setup>
import { defineProps, ref, computed, onMounted, defineExpose, watchEffect } from 'vue'
import { QrcodeStream } from 'vue-qrcode-reader'
import SeniorList from './SeniorList.vue'
import axios from 'axios'
import jsPDF from 'jspdf';
import 'jspdf-autotable';

const seniorCitizens = ref([]);
const searchQuery = ref('');
const sortOption = ref('');
const claimedQrCodes = ref([]); 
const eventScannedData = ref([]);
const scannedCodes = ref([]);





const filteredData = computed(() => {
    if (!searchQuery.value) {
        return seniorCitizens.value;
    }
    return seniorCitizens.value.filter(data =>
        data.first_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        data.last_name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});
const calculateAge = (birthDate) => {
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDifference = today.getMonth() - birth.getMonth();

    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birth.getDate())) {
        age--;
    }

    if (age === 0) {
        const months = monthDifference + 12 * (today.getFullYear() - birth.getFullYear());
        return `${months} ${months === 1 ? 'month' : 'months'}`;
    }

    return `${age} ${age === 1 ? 'year' : 'years'}`;
};

const sortedData = computed(() => {
    let data = [...filteredData.value];
    if (sortOption.value === 'asc') {
        data.sort((a, b) => a.last_name.localeCompare(b.last_name));
    } else if (sortOption.value === 'desc') {
        data.sort((a, b) => b.last_name.localeCompare(a.last_name));
    } else if (sortOption.value === 'age') {
        data.sort((a, b) => a.age - b.age);
    } else if (sortOption.value === 'zone') {
        data.sort((a, b) => a.zone.localeCompare(b.zone));
    }
    return data.map(item => ({
        ...item,
        age_display: calculateAge(item.birth_date),
        status: eventScannedData.value.some(event => event.scanned_codes.includes(item.id.toString())) ? 'Claimed' : '-'
    }));
});



const matchedScannedData = computed(() => {
  let data = sortedData.value.filter(senior => scannedCodes.value.includes(senior.id.toString()));
  if (showMatchedScannedData.value) {
    data.sort((a, b) => scannedCodes.value.indexOf(b.id.toString()) - scannedCodes.value.indexOf(a.id.toString()));
  }
  // Update status to "Claimed" for matched scanned data
  data.forEach(senior => {
    senior.status = 'Claimed';
  });
  return data;
});

const claimedData = computed(() => {
  return seniorCitizens.value.filter(senior => senior.status === 'Claimed');
});

onMounted(async () => {
    try {
        const response = await axios.get(route('senior-citizen-data'));
        seniorCitizens.value = response.data;

        // Fetch claimed QR codes from the database
        const claimedResponse = await axios.get(`/event-scanned-data/${props.seniorEvent.id}`);
        eventScannedData.value = claimedResponse.data;

    } catch (error) {
        console.error('Error fetching senior citizens or claimed QR codes:', error);
    }
});

// Method to update the senior list table data without refreshing the page
async function updateSeniorList() {
    try {
        const response = await axios.get(route('senior-citizen-data'));
        seniorCitizens.value = response.data;
    } catch (error) {
        console.error('Error updating senior list:', error);
    }
}

// Expose the function to be used outside of the script setup
defineExpose({
    updateClaimedQrCodes(codes) {
        claimedQrCodes.value = codes;
    }
});


const props = defineProps({
    seniorEvent: { type: Object, required: true },
});


/*** detection handling ***/

const result = ref('')
const isScanning = ref(false)
const flashMessage = ref('')
const invalidQrMessage = ref('')
const showAlreadyScannedModal = ref(false);
const seniorList = ref(true);

const scanSound = new Audio('/build/assets/scan-sound.mp3'); 

const showMatchedScannedData = ref(false); // Initially false

function toggleScanning() {
  if (isScanning.value) {
    saveScannedData(); // Save scanned data when stopping scanning
    resetList();
    updateSeniorList(); // Update the senior list table data
  }
  isScanning.value = !isScanning.value;
  showMatchedScannedData.value = isScanning.value; // Show matched scanned data only when scanning
  seniorList.value = !isScanning.value;
}

function closeModal() {
  showAlreadyScannedModal.value = false;
}

function checkIfAlreadyClaimed(code) {
  return eventScannedData.value.some(event => event.scanned_codes.includes(code));
}

async function onDetect(detectedCodes) {
  console.log(detectedCodes)
  scanSound.play();
  const codes = detectedCodes.map((code) => code.rawValue)

  let validCodes = [];
  let invalidQR = false;

  // Update the status of senior citizens based on scanned codes
  for (const code of codes) {
    if (!scannedCodes.value.includes(code)) { // Check if the code is already scanned
      if (checkIfAlreadyClaimed(code)) {
        showAlreadyScannedModal.value = true;
      } else {
        const codeInt = parseInt(code, 10); 
        const senior = seniorCitizens.value.find(senior => senior.id === codeInt);
        if (senior) {
          senior.status = 'Claimed'; // Update status to "Claimed"
          validCodes.push(code);
        } else {
          invalidQR = true;
        }
      }
    } else {
      showAlreadyScannedModal.value = true;
    }
  }

  if (invalidQR) {
    invalidQrMessage.value = 'Invalid QR code detected!';
    setTimeout(() => {
      invalidQrMessage.value = '';
    }, 2000); 
  } else {
    invalidQrMessage.value = '';
  }

  result.value = JSON.stringify(validCodes);
  scannedCodes.value.push(...validCodes);
  SeniorList.updateClaimedQrCodes(scannedCodes.value);

  // Call the method to update the table data
  updateTableData();

  // Auto-save valid QR codes to the database
  if (validCodes.length > 0) {
    try {
      await axios.post('/save-scanned-data', {
        eventId: props.seniorEvent.id,
        scannedCodes: validCodes
      });
      console.log('Valid QR codes auto-saved successfully');
      // Update the eventScannedData and sortedData without refreshing the page
      eventScannedData.value.push(...validCodes.map(code => ({
        id: code,
        event_id: props.seniorEvent.id,
        scanned_codes: code
      })));
      updateTableData();
    } catch (error) {
      console.error('Failed to auto-save valid QR codes!', error);
    }
  }
}


// Method to update the table data
function updateTableData() {
  eventScannedData.value = [...eventScannedData.value];
  seniorCitizens.value = [...seniorCitizens.value];
}

//Save data
async function saveScannedData() {
  const uniqueCodes = [...new Set(scannedCodes.value)];
  if (uniqueCodes.length > 0) {
    try {
      const newCodes = uniqueCodes.filter(code => !claimedQrCodes.value.includes(code));
      if (newCodes.length > 0) {
        await axios.post('/save-scanned-data', {
            eventId: props.seniorEvent.id,
            scannedCodes: newCodes.join(',')
        });
        updateTableData(); // Update the table data after saving
        console.log('Unique scanned data saved successfully'); 
        // Update the eventScannedData and sortedData without refreshing the page
        eventScannedData.value.push(...newCodes.map(code => ({
          id: code,
          event_id: props.seniorEvent.id,
          scanned_codes: code
        })));
        updateTableData();
      } else {
        console.log('No new unique scanned data to save');
      }
    } catch (error) {
      console.error('Failed to save unique scanned data!', error);
    }
  } else {
    console.log('No unique scanned data to save');
  }
}

watchEffect(async () => {
  if (scannedCodes.value.length > 0) {
    const uniqueCodes = [...new Set(scannedCodes.value)];
    const newCodes = uniqueCodes.filter(code => !claimedQrCodes.value.includes(code));
    if (newCodes.length > 0) {
      try {
        await axios.post('/save-scanned-data', {
          eventId: props.seniorEvent.id,
          scannedCodes: newCodes.join(',')
        });
        updateTableData(); // Update the table data after saving
        console.log('Unique scanned data saved successfully');
      } catch (error) {
        console.error('Failed to save unique scanned data!', error);
      }
    }
  }
});

function resetList() {
  scannedCodes.value = [];
  seniorCitizens.value.forEach(senior => senior.status = '-');
  updateTableData();
}

/*** select camera ***/

const selectedConstraints = ref({ facingMode: 'environment' })
const defaultConstraintOptions = [
  { label: 'rear camera', constraints: { facingMode: 'environment' } },
  { label: 'front camera', constraints: { facingMode: 'user' } }
]
const constraintOptions = ref(defaultConstraintOptions)

async function onCameraReady() {

  const devices = await navigator.mediaDevices.enumerateDevices()
  const videoDevices = devices.filter(({ kind }) => kind === 'videoinput')

  constraintOptions.value = [
    ...defaultConstraintOptions,
    ...videoDevices.map(({ deviceId, label }) => ({
      label: `${label} (ID: ${deviceId})`,
      constraints: { deviceId }
    }))
  ]

  error.value = ''
}


function paintOutline(detectedCodes, ctx) {
  for (const detectedCode of detectedCodes) {
    const [firstPoint, ...otherPoints] = detectedCode.cornerPoints

    ctx.strokeStyle = 'red'

    ctx.beginPath()
    ctx.moveTo(firstPoint.x, firstPoint.y)
    for (const { x, y } of otherPoints) {
      ctx.lineTo(x, y)
    }
    ctx.lineTo(firstPoint.x, firstPoint.y)
    ctx.closePath()
    ctx.stroke()
  }
}
function paintBoundingBox(detectedCodes, ctx) {
  for (const detectedCode of detectedCodes) {
    const {
      boundingBox: { x, y, width, height }
    } = detectedCode

    ctx.lineWidth = 2
    ctx.strokeStyle = '#007bff'
    ctx.strokeRect(x, y, width, height)
  }
}
function paintCenterText(detectedCodes, ctx) {
  for (const detectedCode of detectedCodes) {
    const { boundingBox, rawValue } = detectedCode

    const centerX = boundingBox.x + boundingBox.width / 2
    const centerY = boundingBox.y + boundingBox.height / 2

    const fontSize = Math.max(12, (50 * boundingBox.width) / ctx.canvas.width)

    ctx.font = `bold ${fontSize}px sans-serif`
    ctx.textAlign = 'center'

    ctx.lineWidth = 3
    ctx.strokeStyle = '#35495e'
    ctx.strokeText(detectedCode.rawValue, centerX, centerY)

    ctx.fillStyle = '#5cb984'
    ctx.fillText(rawValue, centerX, centerY)
  }
}
const trackFunctionOptions = [
  { text: 'nothing (default)', value: undefined },
  { text: 'outline', value: paintOutline },
  { text: 'centered text', value: paintCenterText },
  { text: 'bounding box', value: paintBoundingBox }
]
const trackFunctionSelected = ref(trackFunctionOptions[1])

/*** barcode formats ***/

const barcodeFormats = ref({

})
const selectedBarcodeFormats = computed(() => {
  return Object.keys(barcodeFormats.value).filter((format) => barcodeFormats.value[format])
})

/*** error handling ***/

const error = ref('')

function onError(err) {
  error.value = `[${err.name}]: `

  if (err.name === 'NotAllowedError') {
    error.value += 'you need to grant camera access permission'
  } else if (err.name === 'NotFoundError') {
    error.value += 'no camera on this device'
  } else if (err.name === 'NotSupportedError') {
    error.value += 'secure context required (HTTPS, localhost)'
  } else if (err.name === 'NotReadableError') {
    error.value += 'is the camera already in use?'
  } else if (err.name === 'OverconstrainedError') {
    error.value += 'installed cameras are not suitable'
  } else if (err.name === 'StreamApiNotSupportedError') {
    error.value += 'Stream API is not supported in this browser'
  } else if (err.name === 'InsecureContextError') {
    error.value +=
      'Camera access is only permitted in secure context. Use HTTPS or localhost rather than HTTP.'
  } else {
    error.value += err.message
  }

  // Add JSON string to determine what caused the error
  error.value += ` (Details: ${JSON.stringify(err)})`
}

const currentDateTime = ref(formatDateTime(new Date()));

setInterval(() => {
  currentDateTime.value = formatDateTime(new Date());
}, 1000);

function formatDateTime(date) {
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
  const formattedDate = date.toLocaleDateString('en-US', options).replace(',', ' |');
  const [weekday, ...rest] = formattedDate.split(' | ');
  return { weekday, date: rest.join(' | ') };
}

function downloadPDF() {
    let data = [...sortedData.value];

    const doc = new jsPDF();
    doc.setFontSize(12);
    const pageWidth = doc.internal.pageSize.getWidth();

    doc.setFont('helvetica', 'normal');
    doc.text('Republic of the Philippines', pageWidth / 2, 10, { align: 'center' });
    doc.text('Province of Leyte', pageWidth / 2, 16, { align: 'center' });
    doc.text('City of Baybay', pageWidth / 2, 22, { align: 'center' });

    doc.setFontSize(14);
    doc.setFont('helvetica', 'bold');
    doc.text('Senior Citizen', pageWidth / 2, 40, { align: 'center' });

    if (props.seniorEvent?.title) {
      doc.setFont('helvetica', 'normal');
      doc.text(props.seniorEvent.title, pageWidth / 2, 50, { align: 'center' });
    } else {
        console.error("seniorEvent.name is undefined");
    }

    doc.setFontSize(11);
    doc.setFont('helvetica', 'normal');
    const eventDate = new Date(props.seniorEvent.date);
    const formattedDate = eventDate.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
    doc.text(formattedDate, pageWidth / 2, 58, { align: 'center' });

    doc.setFontSize(14);
    doc.setFont('helvetica', 'bold');
    doc.text('BHS PATAG', pageWidth / 2, 70, { align: 'center' });

    const tableStartY = 78;

    const dataWithoutQR = data.map((data, index) => [
        `${index + 1}.`,
        `${data.last_name.charAt(0).toUpperCase() + data.last_name.slice(1)}, ${data.first_name.charAt(0).toUpperCase() + data.first_name.slice(1)}`,
        `${data.age_display}`,
        data.sex.charAt(0).toUpperCase(),
        data.zone,
        data.status
    ]);

    doc.autoTable({
        head: [['', 'Name', 'Age', 'Sex', 'Zone', 'Status']],
        body: dataWithoutQR,
        startY: tableStartY,
        didDrawPage: function (data) {
            let pageCount = doc.internal.getNumberOfPages();
            doc.setFontSize(10);
            doc.setTextColor(150);
            doc.text(`Page ${pageCount}`, doc.internal.pageSize.width / 2, doc.internal.pageSize.height - 10, { align: 'center' });
        }
    });
    doc.save(props.seniorEvent.title + '.pdf');
}
</script>

<style scoped>
.action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0;
    margin-bottom: 10px;
}
.action-bar-match {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0;
    margin-bottom: 10px;
}
.data-container {
    width: 100%;
    padding: 20px;
    margin-top: 20px;
    margin-bottom: 5%;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-left: 5%;
}
.scrollable-table {
    height: 480px;
    overflow-y: auto;
    margin-top: -18px;
    scroll-snap-type: y mandatory;
}
.scrollable-table-match{
    height: 280px;
    overflow-y: auto;
    margin-top: 10px;
    scroll-snap-type: y mandatory;
}

.scrollable-table > .data-table {
    width: 100%;
}

.data-table {
    width: 100%;
    font-size: 14px;
    border-collapse: collapse;
}

.data-table th {
    background-color: #007bff;
    border: 1px solid #ccc;
    color: white;
    font-weight: bold;
    font-family: 'Arial';
    letter-spacing: 1px;
    height: 50px;
    position: sticky;
    top: -1px;
}

.data-table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
    color: #464545;
}

.data-table tr {
    scroll-snap-align: start;
}

.data-table th, .data-table td {
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.data-table img {
    width: 50px; 
    height: 50px;
    display: block;
    margin: 0 auto; 
}
.data-table th:nth-child(1) {
    width: 5%;
}

.data-table th:nth-child(2) {
    width: 30%;
}

.data-table th:nth-child(3) {
    width: 12%;
}

.data-table th:nth-child(4) {
    width: 12%;
}

.data-table th:nth-child(5) {
    width: 12%;
}

.data-table th:nth-child(6) {
    width: 15%;
}

.search-box {
    display: flex;
    align-items: center;
    width: 240px; 
    padding: 2px; 
    border: 2px solid #9dc0e6; 
    border-radius: 50px; 
    background-color: #fff; 
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1); 
}
.search-box-match {
    display: flex;
    align-items: center;
    width: 240px; 
    padding: 2px; 
    border: 2px solid #9dc0e6; 
    border-radius: 50px; 
    background-color: #fff; 
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1); 
    margin-bottom:-20px;
}

.search-box i {
    font-size: 14px;
    color: #007bff; 
    margin-right: 8px;
}
.search-box-match i {
    font-size: 14px;
    color: #007bff; 
    margin-right: 8px;
}

.search-box input {
    font-size: 14px;
    border: none;
    outline: none;
    color: #333;
    height: 25px; 
}
.search-box-match input {
    font-size: 14px;
    border: none;
    outline: none;
    color: #333;
    height: 25px; 
}

.button-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0;
    /* margin-bottom: 10px; */
}

.sort-select {
    padding: 5px;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}
.error {
  text-align: center;
  font-weight: bold;
  color: red;
  margin-bottom:5px;
}
.barcode-format-checkbox {
  margin-right: 10px;
  white-space: nowrap;
  display: inline-block;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
th, td {
  border: 1px solid #ddd;
  padding: 8px;
}
th {
  background-color: #f2f2f2;
  text-align: left;
}
.scan-button {
  margin-left:44%;
  padding: 8px 15px;
  border: none;
  border-radius: 5px;
  color: white;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s ease;
}

.scan-button.start {
  background-color: #28a745;
  margin-top:20px;
}

.scan-button.start:hover {
  background-color: #218838;
}

.scan-button.stop {
  background-color: #dc3545;
}

.scan-button.stop:hover {
  background-color: #c82333;
}

.save-button {
  padding: 10px 20px;
  margin: 10px;
  border: none;
  border-radius: 5px;
  color: white;
  background-color: #007bff;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

.save-button:hover {
  background-color: #0056b3;
}

.toggle-matched-button {
  padding: 10px 20px;
  margin: 10px;
  border: none;
  border-radius: 5px;
  color: white;
  background-color: #007bff;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

.toggle-matched-button:hover {
  background-color: #0056b3;
}

.flash-message {
  font-weight: bold;
  color: green;
  margin-top: 10px;
}

.qr-scanner-video {
  width: 300px;
  height: 200px;
  margin: 30px auto 7px auto;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  text-align: center;
}

.modal-content p {
  font-size: 18px;
  margin-bottom: 20px;
}

.modal-content button {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  background-color: #007bff;
  color: white;
  cursor: pointer;
  font-size: 16px;
}

.modal-content button:hover {
  background-color: #0056b3;
}

.date-time {
  padding: 0;
  margin-left: 20px;
  font-size: 15px;
  color: #333;
  margin-right: auto; 
  margin-bottom:-20px;
}

.date-time .weekday {
  font-weight: bold;
}

</style>