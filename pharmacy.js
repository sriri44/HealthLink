// Function to get current location
function getCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const { latitude, longitude } = position.coords;
            const googleMapsUrl = `https://www.google.com/maps/search/?api=1&query=medical+stores+near+${latitude},${longitude}`;
            window.open(googleMapsUrl, '_blank');
        }, () => {
            alert('Unable to retrieve your location. Please try again or enter it manually.');
        });
    } else {
        alert('Geolocation is not supported by this browser.');
    }
}

// Add event listener for the search button
document.getElementById('searchBtn').addEventListener('click', function() {
    const location = document.getElementById('location').value;

    if (location) {
        // Redirect to Google Maps with the search for nearby medical shops
        const googleMapsUrl = `https://www.google.com/maps/search/?api=1&query=medical+stores+near+${encodeURIComponent(location)}`;
        window.open(googleMapsUrl, '_blank');
    } else {
        alert('Please enter a location.');
    }
});

// Add an event listener for the current location button
document.getElementById('currentLocationBtn').addEventListener('click', getCurrentLocation);

// Add an event listener for the Enter key
document.getElementById('location').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        document.getElementById('searchBtn').click(); // Trigger the search button click
    }
});
