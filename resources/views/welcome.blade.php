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
        background: white;
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
    <input type="checkbox" id="mada-plot-farm" name="farm-management">
    <label for="mada-plot-farm">Farm Management</label><br>
    <input type="checkbox" id="mada-tagging" name="soil-management">
    <label for="mada-tagging">Soil Management</label><br>
    <input type="checkbox" id="mada-water-level" name="water-management">
    <label for="mada-water-level">Water Management</label><br>
    <input type="checkbox" id="mada-crop-blok" name="crop-management">
    <label for="mada-crop-blok">Crop Management</label><br>
    <input type="checkbox" id="mada-weather" name="weather-management">
    <label for="mada-weather">Weather Management</label><br>
    <input type="checkbox" id="mada-pest" name="pest-management">
    <label for="mada-pest">Pest Management</label><br>
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

    const popup = new mapboxgl.Popup({
        closeButton: true,
        closeOnClick: true
    });
    //farm management
    map.on('mouseenter', 'mada-plot-farm', (e) => {
        map.getCanvas().style.cursor = 'pointer';

        let htmlString = `<table class="table table-bordered">
            <tbody>
                <h6>Farm management</h6>
                <tr>
                    <th scope="row">Blok</th>
                    <td>${e.features[0].properties['Blok_']}</td>
                </tr>
                <tr>
                    <th scope="row">No Plot</th>
                    <td>${e.features[0].properties['No_Plot']}</td>
                </tr>
                <tr>
                    <th scope="row">Luas(ha)</th>
                    <td>${e.features[0].properties['Luas_ha']}</td>
                </tr>
                <tr>
                    <th scope="row">Luas(kp)</th>
                    <td>${e.features[0].properties['Luas_kp']}</td>
                </tr>
                <tr>
                    <th scope="row">Luas(m²)</th>
                    <td>${e.features[0].properties['Luas_m²']}</td>
                </tr>
            </tbody>
        </table>`;
        if (e.features[0].properties['link'] != undefined) {
            htmlString += `<a href="${e.features[0].properties['link']}" class="btn btn-primary btn-sm" tabindex="-1"
                role="button" aria-disabled="true">Click Here
            </a>`;
        }
        popup.setLngLat(e.lngLat).setHTML(htmlString).addTo(map);
    });

    map.on('mouseleave', 'mada-plot-farm', () => {
        map.getCanvas().style.cursor = '';
        popup.remove();
    });

    //soil management
    map.on('mouseenter', 'mada-tagging', (e) => {
        popup
            .setLngLat(e.lngLat)
            .setHTML(`<table class="table table-bordered">
                <tbody>
                    <h6>Soil Management</h6>
                    <tr>
                        <th scope="row">CEC</th>
                        <td>${e.features[0].properties['CEC (cmol(']}</td>
                    </tr>
                    <tr>
                        <th scope="row">FieldName</th>
                        <td>${e.features[0].properties['FieldName']}</td>
                    </tr>
                    <tr>
                        <th scope="row">Kalium</th>
                        <td>${e.features[0].properties['Kalium(exc']}</td>
                    </tr>
                    <tr>
                        <th scope="row">OrderID</th>
                        <td>${e.features[0].properties['OrderID']}</td>
                    </tr>
                    <tr>
                        <th scope="row">Phosphorus</th>
                        <td>${e.features[0].properties['Phosphorus']}</td>
                    </tr>
                    <tr>
                        <th scope="row">Total N (%)</th>
                        <td>${e.features[0].properties['Total N (%']}</td>
                    </tr>
                    <tr>
                        <th scope="row">WKT</th>
                        <td>${e.features[0].properties['WKT']}</td>
                    </tr>
                    <tr>
                        <th scope="row">PH</th>
                        <td>${e.features[0].properties['pH']}</td>
                    </tr>
                </tbody>
            </table>
            <a href="https://efallah-staging.teranerve.space/admin/soils" 
                class="btn btn-primary btn-sm" 
                tabindex="-1" 
                role="button" 
                aria-disabled="true">Click Here
            </a>`)
            .addTo(map);
        });
    map.on('mouseleave', 'mada-tagging', () => {
        map.getCanvas().style.cursor = '';
       
    });
    //crop management/blok
    map.on('click', 'mada-crop-blok', (e) => {
        new mapboxgl.Popup()
            .setLngLat(e.lngLat)
            .setHTML(`<table class="table table-bordered">
                <tbody>
                    <h6>Crop Management</h6>
                    <tr>
                        <th scope="row">Blok</th>
                        <td>${e.features[0].properties['Blok_']}</td>
                    </tr>
                    <tr>
                        <th scope="row">No Plot</th>
                        <td>${e.features[0].properties['No_Plot']}</td>
                    </tr>
                </tbody>
            </table>
            <a href="${e.features[0].properties['link']}" class="btn btn-primary btn-sm" tabindex="-1" role="button"
                aria-disabled="true">Click Here
            </a>`)
        .addTo(map);
    });
    //water management
    map.on('click', 'mada-water-level', (e) => {
        new mapboxgl.Popup()
            .setLngLat(e.lngLat)
            .setHTML(`<table class="table table-bordered">
                <tbody>
                    <h6>Water Management</h6>
                    <tr>
                        <th scope="row">WL</th>
                        <td>${e.features[0].properties['WL']}</td>
                    </tr>
                </tbody>
            </table>
            <a href="${e.features[0].properties['link']}" class="btn btn-primary btn-sm" tabindex="-1" role="button"
                aria-disabled="true">Click Here
            </a>`)
        .addTo(map);
    });
    //weather
    map.on('click', 'mada-weather', (e) => {
        new mapboxgl.Popup()
            .setLngLat(e.lngLat)
            .setHTML(`<table class="table table-bordered">
                <tbody>
                    <h6>Weather Management</h6>
                    <tr>
                        <td>${e.features[0].properties['name']}</td>
                    </tr>
                </tbody>
            </table>
            <a href="${e.features[0].properties['link']}" class="btn btn-primary btn-sm" tabindex="-1" role="button"
                aria-disabled="true">Click Here
            </a>`)
        .addTo(map);
    });
    //pest
    map.on('click', 'mada-pest', (e) => {
        new mapboxgl.Popup()
            .setLngLat(e.lngLat)
            .setHTML(`<table class="table table-bordered">
                <tbody>
                    <h6>Pest Management</h6>
                    <tr>
                        <th scope="row">Solar Trap</th>
                        <td>${e.features[0].properties['Solar Trap']}</td>
                    </tr>
                </tbody>
            </table>
            <a href="${e.features[0].properties['link']}" class="btn btn-primary btn-sm" tabindex="-1" role="button"
                aria-disabled="true">Click Here
            </a>`)
        .addTo(map);
    });


    

    // ni untuk hide and show layer 
    // If these two layers were not added to the map, abort
    map.on('load', () => {
        map.on('idle', () => {
            if (!map.getLayer('mada-plot-farm') || 
                !map.getLayer('technerve-9i7vu5bk') || 
                !map.getLayer('technerve-1d2ujxuf') ||
                !map.getLayer('mada-tagging') ||
                !map.getLayer('mada-water-level') ||
                !map.getLayer('mada-crop-blok') ||
                !map.getLayer('mada-weather') ||
                !map.getLayer('mada-pest')
            ) {
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
        });
    });
</script>
@endsection