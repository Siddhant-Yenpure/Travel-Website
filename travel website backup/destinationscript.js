document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const destination = params.get('dest');
    const destinationInfo = document.getElementById('destination-info');

    if (destination) {
        fetch('destinations.json')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                const destData = data[destination];
                if (destData) {
                    destinationInfo.innerHTML = `
                        <h2>${destData.name}</h2>
                        <p>${destData.description}</p>
                        <img src="${destData.image}" alt="${destData.name}">
                    `;
                } else {
                    destinationInfo.innerHTML = '<p>No information available for this destination.</p>';
                }
            })
            .catch(error => {
                console.error('Error loading destination data:', error);
                destinationInfo.innerHTML = '<p>Error loading destination data.</p>';
            });
    } else {
        destinationInfo.innerHTML = '<p>No destination selected.</p>';
    }
});


