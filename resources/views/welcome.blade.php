@extends('layouts.app')

@section('css')
<style>
    body {
        margin: 0;
        padding: 0;
    }

    #map {
        position: absolute;
        top: 0;
        width: 100%;
        height: calc(100vh - 1px);
    }

    #button {
        display: inline-block;
        position: relative;
        margin: 100px 10px 10px 30px;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        font-size: 12px;
        text-align: center;
        font-weight: bold;
        color: rgb(17, 1, 1);
        background: #fcf9f8;
        float: right;
    }

    .mapboxgl-popup-content {
        width: 350px;
        padding: 20px 15px 15px;
    }

    #menu {
        position: absolute;
        background: #efefef;
        padding: 10px;
        margin: 10px;
        font-famly: 'Open Sans', sans-serif;
    }
</style>
@endsection

@section('content')
<div id="map"></div>
<button id="button" style="display: none;">Reset Map</button>
<div id="menu">
    <input type="checkbox" id="featuretopoint-duz7lr" name="featuretopoint-duz7lr">
    <label for="featuretopoint-duz7lr">Farm Management</label><br>
    <input type="checkbox" id="mada-tagging" name="soil-management">
    <label for="mada-tagging">Soil Management</label><br>
    <input type="checkbox" id="features-mada-cjnhkn" name="features-mada-cjnhkn" disabled>
    <label for="features-mada-cjnhkn">Water Management</label><br>
    <input type="checkbox" id="crop-management" name="crop-management" disabled>
    <label for="crop-management">Crop Management</label><br>
    <input type="checkbox" id="weather-management" name="weather-management" disabled>
    <label for="weather-management">Weather Management</label><br>
    <input type="checkbox" id="pest-management" name="pest-management" disabled>
    <label for="pest-management">Pest Management</label><br>
</div>
@endsection


@section('scripts')
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoidGVjaG5lcnZlIiwiYSI6ImNrY3gzM294bTA1d3IyeW53bHFicjQ1Zm4ifQ.E-ac1XhmOysrRtvnYig8jA';
        const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/technerve/ckz2eetch006q14mdvn05ff1m?fresh=true',
        center: [100.526959, 5.979196],
        zoom: 9
    });

    var el = document.createElement('div');

    el.style.backgroundImage = 'url(marker.svg)';
    el.style.backgroundSize = '100%';
    el.style.width = 40 + 'px';
    el.style.height = 40 + 'px';
    el.style.border = 5 + 'px';
    el.style.cursor = 'pointer';
    el.addEventListener('click', function(){
        map.flyTo({
            center: [
            100.527,
            5.979
            ],
            zoom:15,
            essential: true // this animation is considered essential with respect to prefers-reduced-motion
        });
        marker1.remove();
		document.getElementById('button').style.display='inline-block';
        });
	
        document.getElementById('button').addEventListener('click', () => {
        map.flyTo({
            center: [
                100.527,
                5.979
            ],
            zoom:9,
            essential: true // this animation is considered essential with respect to prefers-reduced-motion
        });
		new mapboxgl.Marker(el).setLngLat([ 100.527, 5.979 ]).addTo(map);
		document.getElementById('button').style.display='none';
    });

    map.addControl(new mapboxgl.NavigationControl());
    
    var marker1 = new mapboxgl.Marker(el)
    .setLngLat([ 100.527, 5.979 ])
    .addTo(map);

    //demo user click data
    map.on('click', 'featuretopoint-duz7lr', (e) => {
    new mapboxgl.Popup()
        .setLngLat(e.lngLat)
        .setHTML(`<table class="table table-bordered">
            <tbody>
                <tr>
                    <th scope="row">Blok</th>
                    <td>${e.features[0].properties.Blok_}</td>
                </tr>
                <tr>
                    <th scope="row">No Plot</th>
                    <td>${e.features[0].properties.No_Plot}</td>
                </tr>
                <tr>
                    <th scope="row">Luas(ha)</th>
                    <td>${e.features[0].properties.Luas_ha}</td>
                </tr>
                <tr>
                    <th scope="row">Luas(kp)</th>
                    <td>${e.features[0].properties.Luas_kp}</td>
                </tr>
            </tbody>
            </table>`)
        .addTo(map);
    });

    map.on('click', 'mada-tagging', (e) => {
    new mapboxgl.Popup()
    .setLngLat(e.lngLat)
    .setHTML(`<table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="row">CEC</th>
                <td> - </td>
            </tr>
            <tr>
                <th scope="row">FieldName</th>
                <td>${e.features[0].properties.FieldName}</td>
            </tr>
            <tr>
                <th scope="row">Kalium</th>
                <td> - </td>
            </tr>
            <tr>
                <th scope="row">OrderID</th>
                <td>${e.features[0].properties.OrderID}</td>
            </tr>
            <tr>
                <th scope="row">Phosphorus</th>
                <td>${e.features[0].properties.Phosphorus}</td>
            </tr>
            <tr>
                <th scope="row">Total N (%)</th>
                <td> - </td>
            </tr>
            <tr>
                <th scope="row">WKT</th>
                <td>${e.features[0].properties.WKT}</td>
            </tr>
            <tr>
                <th scope="row">PH</th>
                <td>${e.features[0].properties.pH}</td>
            </tr>
        </tbody>
    </table>`)
    .addTo(map);
    });

    map.on('mouseenter', 'mada-tagging', () => {
        map.getCanvas().style.cursor = 'pointer';
    });

    map.on('mouseleave', 'mada-tagging', () => {
        map.getCanvas().style.cursor = '';
    });

    // ni untuk hide and show layer 
    // If these two layers were not added to the map, abort
    map.on('load', () => {
    if (!map.getLayer('mada-tagging') || !map.getLayer('featuretopoint-duz7lr')) {
        return;
    }

    const layerList = document.getElementById('menu');
    const inputs = layerList.getElementsByTagName('input');
    
    for (const input of inputs) {
        input.onclick = (layer) => {
            const layerId = layer.target.id;
            const checkCondition = layer.target.checked;
            if (checkCondition === true) {
                map.setLayoutProperty(layerId, 'visibility', 'visible');
            } else {
                map.setLayoutProperty(layerId, 'visibility', 'none');
            }
        };
    }
    
    // Toggle layer visibility by changing the layout object's visibility property.
    // if (visibility === 'visible') {
    //     map.setLayoutProperty(clickedLayer, 'visibility', 'none');
    //     this.className = '';
    // } else {
    //     this.className = 'active';
    //     map.setLayoutProperty(
    //         clickedLayer,
    //         'visibility',
    //         'visible'
    //         );
    //     }
    // };
    // const layers = document.getElementById('menu');
    // layers.appendChild(link);
    // }
});
</script>
@endsection