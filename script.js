document.getElementById('patient-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Generate a unique 3-digit code
    const uniqueCode = generateUniqueCode();

    // Set the generated code in the hidden input field
    document.getElementById('uniqueCode').value = uniqueCode;

    // Gather form data
    const name = document.getElementById('name').value;
    const severity = document.getElementById('severity').value;

    // Send form data to the server
    fetch('server/add_patient.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `name=${name}&uniqueCode=${uniqueCode}&severity=${severity}`
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        alert(data); // Show the server response
        //loadPatientList(); // Update patient list
    })
    .catch(error => console.error('Error:', error));
});



function generateUniqueCode() {
    return Math.floor(100 + Math.random() * 900); // Generate a random 5-digit number
}


    function loadPatientList() {
        fetch('server/get_patient.php')
        .then(response => response.json())
        .then(data => {
            const patientList = document.getElementById('patient-list');
            patientList.innerHTML = '';
            data.forEach(patient => {
                const patientItem = document.createElement('div');
                patientItem.textContent = `${patient.name} (${patient.uniquecode}) - Severity: ${patient.severity} - Wait Time in queue: ${Math.floor(patient.wait_time / 60)} mins`;
                patientList.appendChild(patientItem);
            });
        })
        .catch(error => console.error('Error:', error));
    }


document.getElementById('check-wait-time-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    const patientName = document.getElementById('patient-name-check').value;
    let patientCode = document.getElementById('patient-code-check').value;
    patientCode = parseInt(patientCode, 10);


    // Send form data to the server to check wait time
    fetch('server/check_wait_time.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `name=${patientName}&uniqueCode=${patientCode}`
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('wait-time').textContent = data; // Show the wait time
    })
    .catch(error => console.error('Error:', error));
});


// Call loadPatientList periodically for real-time updates
//setInterval(loadPatientList, 5000);
