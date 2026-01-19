@extends('layouts.app')

@section('title', 'Track Your Order - Cinnamon Bakery')

@section('content')
<div class="tracking-container">
    <div class="tracking-header">
        <h1>Track Order #{{ $order->id }}</h1>
        <div class="order-badge {{ $order->status }}">
            {{ strtoupper(str_replace('_', ' ', $order->status)) }}
        </div>
    </div>

    <div class="tracking-main">
        <!-- Live Map -->
        <div id="map" style="height: 500px; width: 100%; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);"></div>

        <!-- Tracking Info Sidebar -->
        <div class="tracking-info">
            <div class="info-card">
                <h3>Delivery Status</h3>
                <div id="status-text" class="status-loading">Initializing tracking...</div>
                
                <div class="eta-box" id="eta-container" style="display: none;">
                    <div class="eta-item">
                        <span class="label">Distance</span>
                        <span id="eta-distance" class="value">--</span>
                    </div>
                    <div class="eta-item">
                        <span class="label">Time Remaining</span>
                        <span id="eta-time" class="value">--</span>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <h3>Order Summary</h3>
                <p>Items: <strong>{{ $order->items->count() }} items</strong></p>
                <p>Delivery Address: <strong>{{ $order->delivery_street }}, {{ $order->delivery_area }}</strong></p>
            </div>
        </div>
    </div>
</div>

<style>
    .tracking-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
    .tracking-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .tracking-main { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; }
    
    .info-card { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 20px; }
    .info-card h3 { margin-top: 0; color: #2C1810; font-size: 18px; margin-bottom: 15px; }
    
    .order-badge { padding: 8px 20px; border-radius: 30px; font-weight: 600; font-size: 14px; }
    .order-badge.pending { background: #fff3cd; color: #856404; }
    .order-badge.confirmed { background: #d1ecf1; color: #0c5460; }
    .order-badge.out_for_delivery { background: #d4edda; color: #155724; }
    
    .status-loading { color: #888; font-style: italic; }
    .eta-box { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; }
    .eta-item .label { display: block; font-size: 12px; color: #888; text-transform: uppercase; }
    .eta-item .value { display: block; font-size: 18px; font-weight: 700; color: #D4A76A; }

    @media (max-width: 900px) {
        .tracking-main { grid-template-columns: 1fr; }
    }
</style>
@endsection

@push('scripts')
<!-- Load Google Maps API (API Key needs to be passed dynamically) -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=geometry,drawing"></script>

<script>
    let map, riderMarker, restaurantMarker, customerMarker, routeLine;
    const orderId = {{ $order->id }};
    const restaurantPos = { lat: {{ $restaurant['latitude'] }}, lng: {{ $restaurant['longitude'] }} };
    const customerPos = { lat: {{ $order->latitude ?? 0 }}, lng: {{ $order->longitude ?? 0 }} };

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: restaurantPos,
            styles: [
                { "featureType": "poi", "stylers": [{ "visibility": "off" }] }
            ]
        });

        // Restaurant Marker
        restaurantMarker = new google.maps.Marker({
            position: restaurantPos,
            map: map,
            title: "Cinnamon Bakery",
            icon: {
                url: 'https://cdn-icons-png.flaticon.com/512/3063/3063822.png',
                scaledSize: new google.maps.Size(40, 40)
            }
        });

        // Customer Marker
        if (customerPos.lat !== 0) {
            customerMarker = new google.maps.Marker({
                position: customerPos,
                map: map,
                title: "Your Home",
                icon: {
                    url: 'https://cdn-icons-png.flaticon.com/512/1239/1239525.png',
                    scaledSize: new google.maps.Size(40, 40)
                }
            });
        }

        // Rider Marker (Initially hidden)
        riderMarker = new google.maps.Marker({
            map: map,
            title: "Delivery Rider",
            visible: false,
            icon: {
                url: 'https://cdn-icons-png.flaticon.com/512/2830/2830305.png',
                scaledSize: new google.maps.Size(50, 50)
            }
        });

        // Start Polling
        startTracking();
    }

    function startTracking() {
        setInterval(fetchStatus, 5000); // Poll every 5 seconds
        fetchStatus();
    }

    function fetchStatus() {
        fetch(`/api/order-status/${orderId}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'waiting') {
                    document.getElementById('status-text').innerText = "Rider assignment pending...";
                    return;
                }

                updateUI(data);
            });
    }

    function updateUI(data) {
        const docStatus = document.getElementById('status-text');
        const etaCont = document.getElementById('eta-container');

        if (data.delivery_status === 'out_for_delivery') {
            docStatus.innerText = "Rider is on the way!";
            docStatus.className = "status-active";
            etaCont.style.display = "grid";

            if (data.eta) {
                document.getElementById('eta-distance').innerText = data.eta.distance;
                document.getElementById('eta-time').innerText = data.eta.remaining_time;
            }

            // Update Rider Marker
            const newPos = { lat: data.rider_location.lat, lng: data.rider_location.lng };
            riderMarker.setPosition(newPos);
            riderMarker.setVisible(true);

            // Auto-pan map if rider moves far
            // map.panTo(newPos);
            
            // Draw route between rider and customer
            updateRoute(newPos, customerPos);

        } else if (data.delivery_status === 'delivered') {
            docStatus.innerText = "Order Delivered! Enjoy your treats.";
            docStatus.style.color = "#2ecc71";
            etaCont.style.display = "none";
            riderMarker.setVisible(false);
        }
    }

    let directionsService, directionsRenderer;
    function updateRoute(origin, dest) {
        if (!directionsService) {
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true,
                preserveViewport: true,
                polylineOptions: {
                    strokeColor: '#D4A76A',
                    strokeWeight: 5,
                    strokeOpacity: 0.8
                }
            });
        }

        directionsService.route({
            origin: origin,
            destination: dest,
            travelMode: 'DRIVING'
        }, (result, status) => {
            if (status === 'OK') {
                directionsRenderer.setDirections(result);
            }
        });
    }

    window.onload = initMap;
</script>
@endpush
