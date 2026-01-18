document.addEventListener('DOMContentLoaded', function () {
    const tiles = document.querySelectorAll('.destination-tile');

    tiles.forEach(tile => {
        tile.addEventListener('click', function () {
            const destination = this.getAttribute('data-destination');
            window.location.href = `destination.html?dest=${destination}`;
        });
    });
});



