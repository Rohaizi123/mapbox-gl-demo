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
        margin: 30px 10px 10px 30px;
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
</style>
@endsection

@section('content')
<div id="map"></div>
<button id="button" style="display: none;">Reset Map</button>
@endsection


@section('scripts')
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoidGVjaG5lcnZlIiwiYSI6ImNrY3gzM294bTA1d3IyeW53bHFicjQ1Zm4ifQ.E-ac1XhmOysrRtvnYig8jA';
        const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/technerve/cky2m67br74cg14o6hnd9o7b3?fresh=true',
        center: [100.526959, 5.979196],
        zoom: 9
    });

    map.addControl(new mapboxgl.NavigationControl());

    var el = document.createElement('div');
    var resetMap = null;

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

    var marker1 = new mapboxgl.Marker(el)
    .setLngLat([ 100.527, 5.979 ])
    .addTo(map);

    //demo hover polygon

    let hoveredStateId = null;

    // map.on('load', () => {
	// 	map.addSource('states', {
	// 		'type': 'geojson',
	// 		'data': 'mapbox://cky3qc94u1x7n29mvhkbp70d9'
	// 	});	
	// 	// The feature-state dependent fill-opacity expression will render the hover effect
	// 	// when a feature's hover state is set to true.
	// 	map.addLayer({
	// 		'id': 'technerve.88bzz2l3',
	// 		'type': 'line',
	// 		'source': 'pelan_infrastruktur_padi',
	// 		'layout': {},
	// 		'paint': {
	// 			'fill-color': '#627BC1',
	// 			'fill-opacity': [
	// 			'case',
	// 				['boolean', ['feature-state', 'hover'], false],
	// 			1,
	// 			0.5
	// 			]
	// 		}
	// 	});
		
	// 	// When the user moves their mouse over the state-fill layer, we'll update the
	// 	// feature state for the feature under the mouse.
	// 	map.on('mousemove', 'state-fills', (e) => {
	// 	if (e.features.length > 0) {
	// 		if (hoveredStateId !== null) {
	// 			map.setFeatureState(
	// 				{ source: 'states', id: hoveredStateId },
	// 				{ hover: false }
	// 			);
	// 		}

	// 		hoveredStateId = e.features[0].id;

	// 		map.setFeatureState(
	// 				{ source: 'states', id: hoveredStateId },
	// 				{ hover: true }
	// 			);
	// 		}
	// 	});1
		
	// 	// When the mouse leaves the state-fill layer, update the feature state of the
	// 	// previously hovered feature.
	// 	map.on('mouseleave', 'state-fills', () => {
	// 		if (hoveredStateId !== null) {
	// 			map.setFeatureState(
	// 				{ source: 'states', id: hoveredStateId },
	// 				{ hover: false }
	// 				);
	// 			}
	// 		hoveredStateId = null;
	// 	});
	// });
       
    //demo guna hover click

    // map.on('click', 'pelan-infrastruktur-padi', (e) => {
    // new mapboxgl.Popup()
    //     .setLngLat(e.lngLat)
    //     .setHTML(e.features[0].properties.Description)
    //     .addTo(map);
    // })

    //demo moouse hover data

    // const popup = new mapboxgl.Popup({
    //     closeButton: false,
    //     closeOnClick: false
    // });
    
    // map.on('mouseenter', 'mada-plot', (e) => {
    // map.getCanvas().style.cursor = 'pointer';
    //   popup.setLngLat(e.lngLat)
    // .setHTML(`<table class="table">
    //     <thead class="thead-dark">
    //     <tr>
    //         <th>FID</th>
    //         <th>Luas Hektar</th>
    //         <th>Blok</th>
    //         <th>No Plot</th>
    //     </tr>
    //     </thead>
    //     <tbody>
    //     <tr>
    //         <td>${e.features[0].properties.FID}</td>
    //         <td>${e.features[0].properties.Luas_Hektar}</td>
    //         <td>${e.features[0].properties.Blok_}</td>
    //         <td>${e.features[0].properties.No_Plot}</td>
    //     </tr>
    //     </tbody>
    // </table>`)
    // .addTo(map);
    // });
    
    // map.on('mouseleave', 'mada-plot', () => {
    //     map.getCanvas().style.cursor = '';
    //     popup.remove();
    // });
    
    //demo user click data
    map.on('click', 'featuretopoint-duz7lr', (e) => {
    new mapboxgl.Popup()
        .setLngLat(e.lngLat)
        .setHTML(`<table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Blok</th>
                    <th>No_Plot</th>
                    <th>Luas_ha</th>
                    <th>Luas_kp</th>
                    </tr>
                </thead>
            <tbody>
                <tr>
                    <td>${e.features[0].properties.Blok_}</td>
                    <td>${e.features[0].properties.No_Plot}</td>
                    <td>${e.features[0].properties.Luas_ha}</td>
                    <td>${e.features[0].properties.Luas_kp}</td>
                </tr>
            </tbody>
            </table>`)
        .addTo(map);
    });

    map.on('mouseenter', 'featuretopoint-duz7lr', () => {
        map.getCanvas().style.cursor = 'pointer';
    });

    map.on('mouseleave', 'mada-plot', () => {
        map.getCanvas().style.cursor = '';
    });

    //ni untuk hide and show layer 
    map.on('idle', () => {
        // If these two layers were not added to the map, abort
        if (!map.getLayer('featuretopoint-duz7lr')) {
            return;
        }
        map.setLayoutProperty('featuretopoint-duz7lr','visibility', 'none');
    });

</script>
@endsection