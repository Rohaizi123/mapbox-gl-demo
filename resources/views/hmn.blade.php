@extends('layouts.app')

@section('css')
<style>
    #map {
        position: absolute;
        top: 0;
        width: 100%;
        height: calc(100vh - 1px);
    }
</style>
@endsection

@section('content')
<div id="map"></div>
@endsection


@section('scripts')
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoidGVjaG5lcnZlIiwiYSI6ImNrY3gzM294bTA1d3IyeW53bHFicjQ1Zm4ifQ.E-ac1XhmOysrRtvnYig8jA';
        const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/outdoors-v11?fresh=true',
        center: [100.526959, 5.979196],
        zoom: 15
    });

    let hoveredStateId = null; 

    map.on('load', () => {
        map.addSource('plan_padi_demo', {
            'type': 'vector',
            'url': 'mapbox://technerve.cl1x8mw4j1ybi29p5khpow9sm-4ynyl', //Add any Mapbox-hosted tileset using its tileset URL (mapbox:// + tileset ID)
            'promoteId': {'plan_padi_demo': 'Id'} //follow the ID data from the layers
        });
        
        map.addLayer({
            'id': 'plot-fill', //name of the layers(boleh letak nama apa2)
            'type': 'fill', //type of layers i.e fill, raster , line
            'source': 'plan_padi_demo', //name of the layer(follow mapbox studio name)
            'source-layer': 'plan_padi_demo', //name of the layer(follow mapbox studio name)
            'layout': {},
            'paint': {
                'fill-color': '#627BC1',
            }
        });

        map.addLayer({
            'id': 'plot-outline', //name of the layers(boleh letak nama apa2)
            'type': 'line', //type of layers i.e fill, raster , line
            'source': 'plan_padi_demo', //name of the layer(follow mapbox studio name)
            'source-layer': 'plan_padi_demo', //name of the layer(follow mapbox studio name)
            'layout': {},
            'paint': {
                'line-color': '#000000',
                'line-width': 2
            }
        });

        map.addLayer({
            'id': 'plot-line', //name of the layers(boleh letak nama apa2)
            'type': 'line', //type of layers i.e fill, raster , line
            'source': 'plan_padi_demo', //name of the layer(follow mapbox studio name)
            'source-layer': 'plan_padi_demo', //name of the layer(follow mapbox studio name)
            'layout': {},
            'paint': {
                'line-color': '#92f02d',
                'line-width': [
                'case',
                    ['boolean', ['feature-state', 'hover'], false],
                    5,
                    0
                ]
            }
        });

        // When the user moves their mouse over the state-fill layer, we'll update the
        // feature state for the feature under the mouse.
        map.on('mousemove', 'plot-fill', (e) => {
            if (e.features.length > 0) {
                //bukan null, default adalah null
                if (hoveredStateId !== null) {
                    map.setFeatureState(
                        { source: 'plan_padi_demo', id: hoveredStateId , sourceLayer:'plan_padi_demo'},
                        { hover: false }
                    );
                }
                hoveredStateId = e.features[0].id;
                map.setFeatureState(
                    { source: 'plan_padi_demo', id: hoveredStateId , sourceLayer:'plan_padi_demo'},
                    { hover: true }
                );
            }
        });
        
        // When the mouse leaves the state-fill layer, update the feature state of the
        // previously hovered feature.
        map.on('mouseleave', 'plot-fill', () => {
            if (hoveredStateId !== null) {
                map.setFeatureState(
                    { source: 'plan_padi_demo', id: hoveredStateId, sourceLayer:'plan_padi_demo'},
                    { hover: false }
                );
            }
            hoveredStateId = null;
        });
    });
</script>
@endsection