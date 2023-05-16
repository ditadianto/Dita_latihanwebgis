
<div class="content"> 
 <div id="map" style="width: 100%; height: 530px; color:black;"></div> 
</div> 
<script> 

var prov = new L.LayerGroup();
var faskes = new L.LayerGroup();


var map = L.map('map', { 
 center: [-1.7912604466772375, 116.42311966554416], 
 zoom: 5, 
 zoomControl: false,
 layers:[] 
}); 

var GoogleSatelliteHybrid= L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { 
maxZoom: 22, 
attribution: 'Latihan Web GIS' 
}).addTo(map);
var Esri_NatGeoWorldMap = 
L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/NatGeo_World_Map/MapServer/tile/{z}/{y}/{x}', {
attribution: 'Tiles &copy; Esri &mdash; National Geographic, Esri, DeLorme, NAVTEQ, UNEP-WCMC, USGS, NASA, ESA, METI, NRCAN, GEBCO, NOAA, iPC',
maxZoom: 16
})

var GoogleMaps = new 
L.TileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', { opacity: 1.0, 
attribution: 'Latihan Web GIS' 
});
var GoogleRoads = new 
L.TileLayer('https://mt1.google.com/vt/lyrs=h&x={x}&y={y}&z={z}',{ 
opacity: 1.0, 
attribution: 'Latihan Web GIS' 
});

var baseLayers = {
 'Google Satellite Hybrid': GoogleSatelliteHybrid,
 'Peta Kedua':Esri_NatGeoWorldMap,
 'Google Map': GoogleMaps,
 'Google Roads' : GoogleRoads
};

var groupedOverlays = {
"Peta Dasar":{
'Ibu Kota Provinsi' :prov},
"Peta Khusus":{
'Fasilitas Kesehatan' :faskes
} 
};


L.control.groupedLayers(baseLayers, groupedOverlays).addTo(map)

var osmUrl='https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'; 
var osmAttrib='Map data &copy; OpenStreetMap contributors'; 
var osm2 = new L.TileLayer(osmUrl, {minZoom: 0, maxZoom: 13, attribution: osmAttrib }); 
var rect1 = {color: "#ff1100", weight: 3}; 
var rect2 = {color: "#0000AA", weight: 1, opacity:0, fillOpacity:0}; 
var miniMap = new L.Control.MiniMap(osm2, {toggleDisplay: true, position : "bottomright", 
aimingRectOptions : rect1, shadowRectOptions: rect2}).addTo(map);

L.Control.geocoder({position :"topleft", collapsed:true}).addTo(map);

var locateControl = L.control.locate({ 
position: "topleft", 
drawCircle: true, 
follow: true, 
setView: true, 
keepCurrentZoomLevel: true, 
markerStyle: { 
weight: 1, 
opacity: 0.8, 
fillOpacity: 0.8 
}, 
circleStyle: { 
weight: 1, 
clickable: false 
}, 
icon: "fa fa-location-arrow", 
metric: false, 
strings: { 
title: "My location", 
popup: "You are within {distance} {unit} from this point", 
outsideMapBoundsMsg: "You seem located outside the boundaries of the map" 
}, 
locateOptions: { 
maxZoom: 18, 
watch: true, 
enableHighAccuracy: true, 
maximumAge: 10000, 
timeout: 10000 
} 
}).addTo(map);

var zoom_bar = new L.Control.ZoomBar({position: 'topleft'}).addTo(map);


L.control.coordinates({ 
position:"bottomleft", 
decimals:2, 
decimalSeperator:",", 
labelTemplateLat:"Latitude: {y}", 
labelTemplateLng:"Longitude: {x}" 
}).addTo(map);
/* scala */
L.control.scale({metric: true, position: "bottomleft"}).addTo(map);


var north = L.control({position: "bottomleft"}); 
north.onAdd = function(map) { 
        var div = L.DomUtil.create("div", "info legend"); 
        div.innerHTML = '<img src="<?=base_url()?>assets/arah-mata-angin.png"style=width:200px;>'; 
        return div; } 
        north.addTo(map);

        $.getJSON("<?=base_url()?>assets/provinsi.geojson",function(data){ 
var ratIcon = L.icon({ 
iconUrl: '<?=base_url()?>assets/Marker-1.png', 
iconSize: [12,10] 
}); 
L.geoJson(data,{ 
pointToLayer: function(feature,latlng){ 
var marker = L.marker(latlng,{icon: ratIcon}); 
marker.bindPopup(feature.properties.CITY_NAME); 
return marker; 
} 
}).addTo(prov); 
});

$.getJSON("<?=base_url()?>assets/rsu.geojson",function(data){ 
var ratIcon = L.icon({ 
iconUrl: '<?=base_url()?>assets/Marker-3.png', 
iconSize: [12,10] 
}); 
L.geoJson(data,{ 
pointToLayer: function(feature,latlng){ 
var marker = L.marker(latlng,{icon: ratIcon}); 
marker.bindPopup(feature.properties.NAMOBJ); 
return marker; 
} 
}).addTo(faskes); 
})

$.getJSON("<?=base_url()?>assets/poliklinik.geojson",function(data){ 
var ratIcon = L.icon({ 
iconUrl: '<?=base_url()?>assets/Marker-4.png', 
iconSize: [12,10] 
}); 
L.geoJson(data,{ 
pointToLayer: function(feature,latlng){ 
var marker = L.marker(latlng,{icon: ratIcon}); 
marker.bindPopup(feature.properties.NAMOBJ); 
return marker; 
} 
}).addTo(faskes); 
});

$.getJSON("<?=base_url()?>assets/puskesmas.geojson",function(data){ 
var ratIcon = L.icon({
iconUrl: '<?=base_url()?>assets/Marker-5.png', 
iconSize: [12,10] 
}); 
L.geoJson(data,{ 
pointToLayer: function(feature,latlng){ 
var marker = L.marker(latlng,{icon: ratIcon}); 
marker.bindPopup(feature.properties.NAMOBJ); 
return marker; 
} 
}).addTo(faskes); 
});


</script>

