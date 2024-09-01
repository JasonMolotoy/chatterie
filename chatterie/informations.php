<?php include('partials-front/menu.php'); ?>

<!-- Page d'information avec géolocalisation -->
<section class="info-geolocalisation py-5">
    <div class="container">
        <h2 class="text-center">Localisez-vous par rapport à notre chatterie</h2>
        <p class="text-center">Nous sommes situés à 7800 Flobecq, Belgique.</p>
        <div class="row">
            <div class="col-md-6">
                <div id="map" style="height: 500px;"></div>
            </div>
            <div class="col-md-6">
                <button id="getLocation" class="btn btn-primary">Obtenir ma localisation</button>
                <div id="locationResult" class="mt-3"></div>
            </div>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>

<!-- Inclure les scripts JavaScript -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>
<script>
    // Variables globales
    var map;
    var userMarker;
    var chatterieLocation = { lat: 50.7383, lng: 3.7063 }; // Coordonnées de Flobecq, Belgique

    function initMap() {
        // Crée la carte centrée sur la chatterie
        map = new google.maps.Map(document.getElementById('map'), {
            center: chatterieLocation,
            zoom: 12
        });

        // Place un marqueur pour la chatterie
        new google.maps.Marker({
            position: chatterieLocation,
            map: map,
            title: 'Chatterie - 7800 Flobecq, Belgique'
        });
    }

    // Fonction pour obtenir la géolocalisation de l'utilisateur
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            document.getElementById('locationResult').innerHTML = "La géolocalisation n'est pas supportée par ce navigateur.";
        }
    }

    function showPosition(position) {
        var userLatLng = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };

        // Affiche la localisation de l'utilisateur sur la carte
        if (userMarker) {
            userMarker.setMap(null); // Supprime l'ancien marqueur
        }

        userMarker = new google.maps.Marker({
            position: userLatLng,
            map: map,
            title: 'Vous êtes ici',
            icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png' // Icône pour l'utilisateur
        });

        map.setCenter(userLatLng); // Recentre la carte sur l'utilisateur

        var distance = calculateDistance(userLatLng, chatterieLocation);
        document.getElementById('locationResult').innerHTML = 
            `Votre position : ${userLatLng.lat.toFixed(4)}, ${userLatLng.lng.toFixed(4)}<br>` +
            `Distance de la chatterie : ${distance.toFixed(2)} km`;
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                document.getElementById('locationResult').innerHTML = "L'utilisateur a refusé la demande de géolocalisation.";
                break;
            case error.POSITION_UNAVAILABLE:
                document.getElementById('locationResult').innerHTML = "Les informations de localisation sont indisponibles.";
                break;
            case error.TIMEOUT:
                document.getElementById('locationResult').innerHTML = "La demande de géolocalisation a expiré.";
                break;
            case error.UNKNOWN_ERROR:
                document.getElementById('locationResult').innerHTML = "Une erreur inconnue est survenue.";
                break;
        }
    }

    // Fonction pour calculer la distance entre deux points en kilomètres
    function calculateDistance(latLng1, latLng2) {
        var R = 6371; // Rayon de la Terre en kilomètres
        var dLat = (latLng2.lat - latLng1.lat) * (Math.PI / 180);
        var dLng = (latLng2.lng - latLng1.lng) * (Math.PI / 180);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(latLng1.lat * (Math.PI / 180)) * Math.cos(latLng2.lat * (Math.PI / 180)) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var distance = R * c;
        return distance;
    }

    // Initialisation de la carte lorsque la page est chargée
    document.addEventListener('DOMContentLoaded', (event) => {
        initMap();
        document.getElementById('getLocation').addEventListener('click', getLocation);
    });
</script>
