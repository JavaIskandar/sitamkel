@extends('layout')

@section('content')
    <link href="{{ asset('css/detail.css') }}" rel="stylesheet"/>
    <div class="page-header">
        <h1>Rute Detail ke {{  $tambal_ban->nama_tempat }}</h1>
    </div>
    <div class="clearfix" style="background: white;">
        <div id="map"></div>
        <div id="right-panel">
            <p>Total Jarak: <span id="total"></span><br/>
                Node Terdekat: <span id="terdekat"></span></p>
        </div>
    </div>
    <p class="help-block">Geser marker atau garis untuk mengubah rute.</p>
@endsection
@push('js')
    <script>
        var default_lat = {{ $def_lat }};
        var default_lng = {{ $def_lng }};
        var default_zoom = {{ $def_zoom }};
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        $(function () {
            initMap();
        })

        var markerArray = [];

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: {lat: default_lat, lng: default_lng}  // Australia.
            });

            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer({
                draggable: true,
                map: map,
                panel: document.getElementById('right-panel')
            });

            var stepDisplay = new google.maps.InfoWindow;


            directionsDisplay.addListener('directions_changed', function () {
                //calculateAndDisplayRoute()
                computeTotalDistance(directionsDisplay.getDirections());
                for (var i = 0; i < markerArray.length; i++) {
                    markerArray[i].setMap(null);
                }

                showSteps(directionsDisplay.getDirections(), markerArray, stepDisplay, map);
                //calculateAndDisplayRoute(pos, {lat: }, directionsService, directionsDisplay, stepDisplay, map);
            });

            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    //infoWindow.setPosition(pos);
                    //infoWindow.setContent('Location found.');
                    //infoWindow.open(map);
                    //map.setCenter(pos);
                    calculateAndDisplayRoute(pos, {
                        lat: {{  $tambal_ban->lat }},
                        lng: {{  $tambal_ban->lng }} }, directionsService, directionsDisplay, stepDisplay, map);
                }, function () {
                    calculateAndDisplayRoute(getCurLocation(), {
                        lat: {{  $tambal_ban->lat }},
                        lng: {{  $tambal_ban->lng }} }, directionsService, directionsDisplay, stepDisplay, map);
                });
            } else {
                // Browser doesn't support Geolocation
                calculateAndDisplayRoute(getCurLocation(), {
                    lat: {{ $tambal_ban->lat }},
                    lng: {{  $tambal_ban->lng }} }, directionsService, directionsDisplay, stepDisplay, map);
            }
        }

        function calculateAndDisplayRoute(origin, destination, directionsService, directionsDisplay, stepDisplay, map) {

            for (var i = 0; i < markerArray.length; i++) {
                markerArray[i].setMap(null);
            }

            directionsService.route({
                origin: origin,
                destination: destination,
                //waypoints: [{location: 'Adelaide, SA'}, {location: 'Broken Hill, NSW'}],
                travelMode: 'DRIVING',
                avoidTolls: true
            }, function (response, status) {
                if (status === 'OK') {
                    //console.log(response);
                    directionsDisplay.setDirections(response);
                    showSteps(response, markerArray, stepDisplay, map);
                } else {
                    alert('Could not display directions due to: ' + status);
                }
            });
        }

        function showSteps(directionResult, markerArray, stepDisplay, map) {
            // For each step, place a marker, and add the text to the marker's infowindow.
            // Also attach the marker to an array so we can keep track of it and remove it
            // when calculating new routes.
            var myRoute = directionResult.routes[0].legs[0];

            //console.log(directionResult.routes[0].legs[0]);

            for (var i = 0; i < myRoute.steps.length; i++) {
                var marker = markerArray[i] = markerArray[i] || new google.maps.Marker();
                //marker.setMap(map);
                //marker.setPosition(myRoute.steps[i].start_location);
                //marker.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png');
                attachInstructionText(
                    stepDisplay, marker, myRoute.steps[i].instructions, map);
            }
        }

        function attachInstructionText(stepDisplay, marker, text, map) {
            google.maps.event.addListener(marker, 'click', function () {
                // Open an info window when the marker is clicked on, containing the text
                // of the step.
                stepDisplay.setContent(text);
                stepDisplay.open(map, marker);
            });
        }

        function computeTotalDistance(result) {
            var total = 0;
            var myroute = result.routes[0];
            var terdekat = 0;

            terdekat = myroute.legs[0].steps[0].distance.value;

            //console.log(result);
            for (var i = 0; i < myroute.legs.length; i++) {
                total += myroute.legs[i].distance.value;
            }
            total = total / 1000;
            document.getElementById('total').innerHTML = total + ' km';
            document.getElementById('terdekat').innerHTML = (terdekat / 1000) + ' km';// + terdekat + ' m';
        }
    </script>
@endpush