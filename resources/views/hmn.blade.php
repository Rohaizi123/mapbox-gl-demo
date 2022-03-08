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
        style: 'mapbox://styles/technerve/ckvq288yaew9j16s5bhy627j4?fresh=true',
        center: [101.096, 3.547],
        zoom: 18
    });
</script>
@endsection