// Appointment Management Logic

// HTML Elements
const appointmentForm = document.getElementById('appointmentForm');
const appointmentsList = document.getElementById('appointmentsList');

// Store appointments in an array
let appointments = [];

// Event listener for booking an appointment
appointmentForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const name = document.getElementById('name').value;
  const dateTime = document.getElementById('dateTime').value;

  const appointment = {
    id: Date.now(),
    name: name,
    dateTime: dateTime,
  };

  appointments.push(appointment);
  renderAppointments();
  appointmentForm.reset();
});

// Render appointments in the list
function renderAppointments() {
  appointmentsList.innerHTML = ''; // Clear the list
  appointments.forEach((appointment) => {
    const li = document.createElement('li');
    li.className = 'appointment-item';
    li.innerHTML = `
      <span>${appointment.name} - ${new Date(appointment.dateTime).toLocaleString()}</span>
      <div class="actions">
        <button class="edit" onclick="editAppointment(${appointment.id})">Edit</button>
        <button onclick="cancelAppointment(${appointment.id})">Cancel</button>
      </div>
    `;
    appointmentsList.appendChild(li);
  });
}

// Edit an appointment
function editAppointment(id) {
  const newDateTime = prompt('Enter new date and time (YYYY-MM-DDTHH:MM):');
  const appointment = appointments.find((app) => app.id === id);
  if (newDateTime) {
    appointment.dateTime = newDateTime;
    renderAppointments();
  }
}

// Cancel an appointment
function cancelAppointment(id) {
  appointments = appointments.filter((app) => app.id !== id);
  renderAppointments();
}

// Reminder Logic (checks every 10 seconds)
setInterval(() => {
  const now = new Date();
  appointments.forEach((appointment) => {
    const appointmentTime = new Date(appointment.dateTime);
    const timeDiff = appointmentTime - now;
    if (timeDiff > 0 && timeDiff <= 60000) { // Reminder 1 minute before
      alert(`Reminder: Your appointment with ${appointment.name} is in 1 minute!`);
    }
  });
}, 10000);
