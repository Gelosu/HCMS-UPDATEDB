<!-- Patient Records Section -->
<section id="patient-records" class="section">
    <h2>Patient Records</h2>

    <!-- Search Container -->
    <div class="search-container">
        <input type="text" id="searchPatientInput" onkeyup="searchPatients(this.value);" placeholder="Search for patients...">
    </div>

    <!-- Patient Search Results -->
    <div id="patientSearchResults">
        <!-- The search results (patient names) will appear here dynamically -->
    </div>

    <!-- Modal for viewing/editing patient's records -->
    <div id="patientRecordModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePatientRecordModal()">&times;</span>
            <h3>Patient Records for <span id="modalPatientName"></span></h3>
            
            <!-- List of patient records -->
            <div id="patientRecordList">
                <!-- Records for the selected patient will be displayed here dynamically -->
            </div>

            <!-- Button to add a new record to this patient -->
            <button onclick="openAddRecordForm(currentPatientId, currentPatientName)">Add New Record</button>

        </div>
    </div>

    <!-- Add Patient Record Modal -->
    <div id="addPatientRecordModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddPatientRecordModal()">&times;</span>
            <h3>Create Patient Record</h3>
<form id="addPatientRecordForm" onsubmit="submitAddPatientRecordForm(event)">
    <!-- Section 1: Patient Information -->
    <label for="patientName">Patient Name:</label>
    <input type="text" id="patientName" name="patientName" required readonly>
    <input type="hidden" id="patientId" name="patientId">

     <label for="patientAge">Age:</label>
    <input type="number" id="patientAge" name="patientAge" required>
    
     <label for="patientHeight">Height (cm):</label>
    <input type="number" id="patientHeight" name="patientHeight" required>

     <label for="patientAge">Weight (kg):</label>
    <input type="number" id="patientWeight" name="patientWeight" required>


    <label for="recordType">Record Type:</label>
    <select id="recordType" name="recordType" required>
        <option value="Consultation">Consultation</option>
        <option value="Lab Test">Lab Test</option>
        <option value="Diagnosis">Diagnosis</option>
    </select>

    <label for="recordDate">Date of Record:</label>
    <input type="date" id="recordDate" name="recordDate" required>

    <!-- Section 2: Medical History -->
    <h4>Medical History</h4>
    <label for="personalHistory">Kasaysayan ng mga sakit (Personal at Pamilya):</label>
    <textarea id="personalHistory" name="personalHistory" rows="3"></textarea>

    <label for="allergyHistory">Allergy History:</label>
    <textarea id="allergyHistory" name="allergyHistory" rows="2"></textarea>

    <label for="surgeriesHistory">Previous Surgeries or Hospitalizations:</label>
    <textarea id="surgeriesHistory" name="surgeriesHistory" rows="2"></textarea>

    <label for="currentMedications">Current Medications:</label>
    <textarea id="currentMedications" name="currentMedications" rows="2"></textarea>

    <label for="immunizationRecords">Immunization Records:</label>
    <textarea id="immunizationRecords" name="immunizationRecords" rows="2"></textarea>

    <!-- Section 3: Present Illness -->
    <h4>Present Illness</h4>
    <label for="currentSymptoms">Current Symptoms:</label>
    <textarea id="currentSymptoms" name="currentSymptoms" rows="3"></textarea>

    <label for="onsetDate">Date of Onset (Kailan nagsimula ang mga sintomas):</label>
    <input type="date" id="onsetDate" name="onsetDate">

    <label for="recentVisits">Any Recent Hospital Visits:</label>
    <textarea id="recentVisits" name="recentVisits" rows="2"></textarea>

    <!-- Section 4: Vital Signs -->
    <h4>Vital Signs</h4>

<label for="bp">Blood Pressure (mmHg):</label>
<input type="text" id="bp" name="bp" placeholder="e.g. 120/80">


<label for="hr">Heart Rate (bpm):</label>
<input type="text" id="hr" name="hr" placeholder="e.g. 70">


<label for="rr">Respiratory Rate (breaths/min):</label>
<input type="text" id="rr" name="rr" placeholder="e.g. 16">


<label for="temp">Temperature(°C):</label>
<input type="text" id="temp" name="temp" placeholder="e.g. 36.5">


<label for="spo2">Oxygen Saturation (%):</label>
<input type="text" id="spo2" name="spo2" placeholder="e.g. 98">



    <!-- Section 5: Physical Examination -->
    <h4>Physical Examination</h4>
    <label for="physicalFindings">Findings Based on Head-to-Toe Examination:</label>
    <textarea id="physicalFindings" name="physicalFindings" rows="4"></textarea>

    <!-- Section 6: Laboratory Results -->
    <h4>Laboratory Results</h4>
    <label for="bloodTests">Blood Tests (CBC, FBS, Creatinine, etc.):</label>
    <textarea id="bloodTests" name="labResults" rows="2"></textarea>

    <label for="imagingResults">Imaging Results (X-ray, MRI, Ultrasound, etc.):</label>
    <textarea id="imagingResults" name="labResults" rows="2"></textarea>

    <label for="urineTests">Urine or Stool Tests:</label>
    <textarea id="urineTests" name="labResults" rows="2"></textarea>

    <!-- Section 7: Diagnosis -->
    <h4>Diagnosis</h4>
    <label for="finalDiagnosis">Final Diagnosis or Working Diagnosis:</label>
    <textarea id="finalDiagnosis" name="finalDiagnosis" rows="2"></textarea>

    <!-- Section 8: Treatment Plan -->
    <h4>Treatment Plan</h4>
    <label for="medicationsPrescribed">Medications Prescribed:</label>
    <textarea id="medicationsPrescribed" name="treatmentPlan" rows="2"></textarea>

    <label for="procedures">Procedures (if any):</label>
    <textarea id="procedures" name="procedures" rows="2"></textarea>

    <label for="followUpSchedule">Follow-up Schedule:</label>
    <input type="date" id="followUpSchedule" name="followUpSchedule">

    <label for="referrals">Referrals to Specialists:</label>
    <textarea id="referrals" name="referrals" rows="2"></textarea>

    <!-- Section 9: Progress Notes -->
    <h4>Progress Notes</h4>
    <label for="progressNotes">Updates on Patient's Condition:</label>
    <textarea id="progressNotes" name="progressNotes" rows="3"></textarea>

    <input type="submit" value="Submit">
</form>

        </div>
    </div>
<!-- Modal for viewing detailed patient record -->
    <div id="viewPatientRecordModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeViewPatientRecordModal()">&times;</span>
            <h3>Patient Record Details for <span id="viewModalPatientName"></span></h3>

            <div class="record-detail">
            <p><strong>Age:</strong> <span id="viewAge"></span> years old</p>
            <p><strong>Height:</strong> <span id="viewHeight"></span> cm</p>
            <p><strong>Weight:</strong> <span id="viewWeight"></span> kg</p>
                <p><strong>Record Type:</strong> <span id="viewRecordType"></span></p>
                <p><strong>Date:</strong> <span id="viewRecordDate"></span></p>
                <p><strong>Personal History:</strong> <span id="viewPersonalHistory"></span></p>
                <p><strong>Allergy History:</strong> <span id="viewAllergyHistory"></span></p>
                <p><strong>Surgeries History:</strong> <span id="viewSurgeriesHistory"></span></p>
                <p><strong>Current Medications:</strong> <span id="viewCurrentMedications"></span></p>
                <p><strong>Immunization Records:</strong> <span id="viewImmunizationRecords"></span></p>
                <p><strong>Current Symptoms:</strong> <span id="viewCurrentSymptoms"></span></p>
                <p><strong>Date of Onset:</strong> <span id="viewOnsetDate"></span></p>
                <p><strong>Recent Visits:</strong> <span id="viewRecentVisits"></span></p>
                <p><strong>Vital Signs:</strong></p>
<ul>
    <li><strong>Blood Pressure:</strong> <span id="viewBloodPressure"></span> mmHg</li>
    <li><strong>Heart Rate:</strong> <span id="viewHeartRate"></span> bpm</li>
    <li><strong>Respiratory Rate:</strong> <span id="viewRespiratoryRate"> breaths/min</span></li>
    <li><strong>Temperature:</strong> <span id="viewTemperature"></span> °C</li>
    <li><strong>Oxygen Saturation:</strong> <span id="viewOxygenSaturation"></span> %</li>
</ul>

                <p><strong>Physical Findings:</strong> <span id="viewPhysicalFindings"></span></p>
                <p><strong>Laboratory Results:</strong> <span id="viewLabResults"></span></p>
                <p><strong>Final Diagnosis:</strong> <span id="viewDiagnosis"></span></p>
                <p><strong>Medications Prescribed:</strong> <span id="viewTreatmentPlan"></span></p>
                <p><strong>Procedures:</strong> <span id="viewProcedures"></span></p>
                <p><strong>Follow-up Schedule:</strong> <span id="viewFollowUpSchedule"></span></p>
                <p><strong>Referrals:</strong> <span id="viewReferrals"></span></p>
                <p><strong>Progress Notes:</strong> <span id="viewProgressNotes"></span></p>
            </div>
    </div>
</div>


</section>

<script>
// Function to search for patients in the patients table
function searchPatients(query) {
    const searchResults = document.getElementById('patientSearchResults');
    searchResults.innerHTML = ''; // Clear previous results

    if (query.length === 0) {
        return;
    }

    // AJAX call to fetch patients based on the search query
    fetch(`P_RECORDS/patientscurrentrecord.php?query=${query}`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                data.forEach(patient => {
                    const patientElement = document.createElement('div');
                    patientElement.classList.add('patient-result');
                    patientElement.textContent = patient.p_name;
                    patientElement.onclick = () => openPatientRecordModal(patient.p_id, patient.p_name);
                    searchResults.appendChild(patientElement);
                });
            } else {
                searchResults.innerHTML = '<p>No matching patients found.</p>';
            }
        })
        .catch(error => console.error('Error fetching patient data:', error));
}


let currentPatientId; // Declare globally
let currentPatientName; // Declare globally

function openPatientRecordModal(patientId, patientName) {
    console.log(`Opening modal for Patient ID: ${patientId}, Name: ${patientName}`);
    document.getElementById('modalPatientName').textContent = patientName;
    document.getElementById('patientRecordModal').style.display = 'block';

    // Store the current patient ID and Name globally
    currentPatientId = patientId;
    currentPatientName = patientName; // Store patient name
    // Fetch records for this patient using their ID
    fetch(`P_RECORDS/fetchpatientrecord.php?patientId=${patientId}`)
        .then(response => response.json())
        .then(records => {
            console.log('Fetched records:', records);
            const recordList = document.getElementById('patientRecordList');
            recordList.innerHTML = ''; // Clear previous records

            if (records.length > 0) {
                records.forEach(record => {
                    const recordElement = document.createElement('div');
                    recordElement.classList.add('record-item');
                    recordElement.innerHTML = `<p><strong>Type:</strong> ${record.record_type}</p><p><strong>Date:</strong> ${record.record_date}</p>`;
                    
                    recordElement.onclick = () => openPatientDetailModal(record.record_id, patientId);

                    recordList.appendChild(recordElement);
                });
            } else {
                recordList.innerHTML = '<p>No records found for this patient.</p>';
            }
        })
        .catch(error => console.error('Error fetching patient records:', error));
}

function openPatientDetailModal(recordId, patientId) {
    console.log(`Opening detail modal for record ID: ${recordId}, Patient ID: ${patientId}`);

    // Fetch detailed record information using the record ID
    fetch(`P_RECORDS/fetchidpatients.php?recordId=${recordId}`)
        .then(response => {
            console.log('Response status:', response.status);
            return response.text(); // Read the response text
        })
        .then(text => {
            try {
                console.log(text);
                const record = JSON.parse(text);
                console.log('Parsed record data:', record);

                // Ensure the patient name element exists before setting its text content
                const modalPatientName = document.getElementById('viewModalPatientName');
                if (modalPatientName) {
                    modalPatientName.textContent = record.p_name ; // Adjust if you want to show patient name
                } else {
                    console.error('Element with ID "viewModalPatientName" not found.');
                }

                // Prepare fields to be populated in the modal
                const fields = {
                    'viewAge': record.p_age,
                    'viewHeight': record.p_height,
                    'viewWeight': record.p_weight,
                    'viewRecordType': record.record_type,
                    'viewRecordDate': record.record_date,
                    'viewPersonalHistory': record.personal_history,
                    'viewAllergyHistory': record.allergy_history,
                    'viewSurgeriesHistory': record.surgeries_history,
                    'viewCurrentMedications': record.current_medications,
                    'viewImmunizationRecords': record.immunization_records,
                    'viewCurrentSymptoms': record.current_symptoms,
                    'viewOnsetDate': record.onset_date,
                    'viewRecentVisits': record.recent_visits,
                    'viewPhysicalFindings': record.physical_findings,
                    'viewLabResults': record.lab_results,
                    'viewDiagnosis': record.diagnosis,
                    'viewTreatmentPlan': record.treatment_plan,
                    'viewProcedures': record.procedures,
                    'viewFollowUpSchedule': record.follow_up_schedule,
                    'viewReferrals': record.referrals,
                    'viewProgressNotes': record.progress_notes,
                };

                // Populate the fields in the modal
                for (const [key, value] of Object.entries(fields)) {
                    const element = document.getElementById(key);
                    if (element) {
                        element.textContent = value || 'N/A'; // Set text content or 'N/A' if undefined
                    } else {
                        console.error(`Element with ID "${key}" not found.`);
                    }
                }

                // Parse and display vital signs individually if they exist
                if (record.vital_signs) {
                    const vitalSigns = JSON.parse(record.vital_signs);
                    document.getElementById('viewBloodPressure').textContent = vitalSigns.bp || 'N/A';
                    document.getElementById('viewHeartRate').textContent = vitalSigns.hr || 'N/A';
                    document.getElementById('viewRespiratoryRate').textContent = vitalSigns.rr || 'N/A';
                    document.getElementById('viewTemperature').textContent = vitalSigns.temp || 'N/A';
                    document.getElementById('viewOxygenSaturation').textContent = vitalSigns.spo2 || 'N/A';
                } else {
                    console.error('Vital signs data is missing or invalid.');
                }

                // Show the modal
                document.getElementById('viewPatientRecordModal').style.display = 'block';
                console.log('Patient detail modal displayed.');
            } catch (error) {
                console.error('Error parsing JSON:', error);
            }
        })
        .catch(error => console.error('Error fetching patient record details:', error));
}





function closeViewPatientRecordModal() {
    // Hide the modal by setting its display to 'none'
    document.getElementById('viewPatientRecordModal').style.display = 'none';

}

function closePatientRecordModal() {
    // Hide the modal by setting its display to 'none'
    document.getElementById('patientRecordModal').style.display = 'none';

}
   

function openAddRecordForm(patientId, patientName) {
    // Display Patient ID and Name for debugging
    console.log(`Opening modal for Patient ID: ${patientId}, Name: ${patientName}`);
    
    // Set the values in the modal
    document.getElementById('patientId').value = patientId;
    document.getElementById('patientName').value = patientName;

    // Open the modal
    document.getElementById('addPatientRecordModal').style.display = 'block';
}

function closeAddPatientRecordModal() {
    document.getElementById('addPatientRecordModal').style.display = 'none';
}

function submitAddPatientRecordForm(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    // Collect data from the form
    const formData = new FormData(event.target);

    // Combine the vital signs into a JSON object
    const vitalSigns = {
        bp: formData.get('bp'),
        hr: formData.get('hr'),
        rr: formData.get('rr'),
        temp: formData.get('temp'),
        spo2: formData.get('spo2')
    };

    // Add the vital signs JSON object to the form data as a string
    formData.append('vitalSigns', JSON.stringify(vitalSigns));

    // AJAX call to submit the new patient record
    fetch('P_RECORDS/addpatientrecord.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // Parse the response as plain text
    .then(text => {
        try {
            console.log("response check: ", text);
            const data = JSON.parse(text);
            
            if (data.success) {
                alert('Record added successfully!');
                closeAddPatientRecordModal(); // Close the modal after submission

                // Fetch the updated records for the patient
                openPatientRecordModal(data.record.patient_id, data.record.p_name);

            } else {
                alert(data.error || 'An error occurred. Please try again.');
            }
        } catch (e) {
            // If parsing fails, treat the response as plain text
            console.error('Error parsing JSON:', e);
            alert(`Unexpected response: ${text}`);
        }
    })
    .catch(error => console.error('Error adding patient record:', error));
}



</script>
