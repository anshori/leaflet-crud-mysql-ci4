<?php $this->extend('layouts/main-template'); ?>

<?php $this->section('content'); ?>
<div id="map"></div>
<?php $this->endSection(); ?>

<?php $this->section('css'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" integrity="sha512-gc3xjCmIy673V6MyOAZhIW93xhM9ei1I+gLbmFjUHIjocENRsLX/QUE1htk5q1XV2D/iie/VQ8DXI6Vu8bexvQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  #map {
    margin-top: 55px;
    height: calc(100vh - 55px);
    width: 100%;
  }
</style>
<?php $this->endSection(); ?>

<?php $this->section('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<?= $this->include('components/toast'); ?>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js" integrity="sha512-ozq8xQKq6urvuU6jNgkfqAmT7jKN2XumbrX1JiB3TnF7tI48DPI4Gy1GXKD/V3EExgAs1V+pRO7vwtS1LHg0Gw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/terraformer@1.0.7/terraformer.js"></script>
<script src="https://unpkg.com/terraformer-wkt-parser@1.1.2/terraformer-wkt-parser.js"></script>
<script>
  // init map
  var map = L.map('map').setView([-7.7956, 110.3695], 10);

  // init basemap
  var basemap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: 'unsorry@2023',
  });

  // add basemap to map
  basemap.addTo(map);

  // scale bar
  L.control.scale({
    position: 'bottomleft',
    metric: true,
    imperial: false,
  }).addTo(map);

  /* Digitize Function */
  var drawnItems = new L.FeatureGroup();
  map.addLayer(drawnItems);

  var drawControl = new L.Control.Draw({
    draw: {
      position: 'topleft',
      polyline: true,
      polygon: true,
      rectangle: false,
      circle: false,
      marker: true,
      circlemarker: false
    },
    edit: false
  });

  map.addControl(drawControl);

  map.on('draw:created', function(e) {
    var type = e.layerType,
      layer = e.layer;

    var drawnJSONObject = layer.toGeoJSON();
    var objectGeometry = Terraformer.WKT.convert(drawnJSONObject.geometry);

    if (type === 'polyline') {
      $('#geometry-polyline').empty();
      console.log(objectGeometry);
      $('#geometry-polyline').val(objectGeometry);
      $('#createpolylineModal').modal('show');

      // modal dismiss reload
      $('#createpolylineModal').on('hidden.bs.modal', function() {
        location.reload();
      });
    } else if (type === 'polygon') {
      $('#geometry-polygon').empty();
      console.log(objectGeometry);
      $('#geometry-polygon').val(objectGeometry);
      $('#createpolygonModal').modal('show');

      // modal dismiss reload
      $('#createpolygonModal').on('hidden.bs.modal', function() {
        location.reload();
      });
    } else if (type === 'marker') {
      $('#geometry-point').empty();
      console.log(objectGeometry);
      $('#geometry-point').val(objectGeometry);
      $('#createpointModal').modal('show');

      // modal dismiss reload
      $('#createpointModal').on('hidden.bs.modal', function() {
        location.reload();
      });
    } else {
      console.log('__undefined__');
    }

    drawnItems.addLayer(layer);
  });

  /* GeoJSON Point */
  var point = L.geoJson(null, {
    onEachFeature: function(feature, layer) {
      var popupContent = "<h5>Point</h5>" +
        "<p>" + feature.properties.name + "</p>" +
        "<div class='d-flex flex-row'>" +
        "<a href='<?= base_url('edit-point') ?>/" + feature.properties.id + "' class='btn btn-sm btn-warning text-dark me-2'><i class='bi bi-pencil-square'></i></a>" +
        "<form action='<?= base_url('delete-point') . '/' ?>" + feature.properties.id + "' method='Post'>" +
        '<?= csrf_field(); ?>' +
        "<input type='hidden' name='_method' value='DELETE'>" +
        "<button type='submit' class='btn btn-sm btn-danger text-light' onclick='return confirm(`Are you sure you want to delete point " + feature.properties.name + "?`)'><i class='bi bi-trash-fill'></i></button>" +
        "</form>" +
        "</div>";
      layer.on({
        click: function(e) {
          point.bindPopup(popupContent);
        },
        mouseover: function(e) {
          point.bindTooltip(feature.properties.name);
        },
      });
    },
  });
  $.getJSON("<?= base_url('geojson-points') ?>", function(data) {
    point.addData(data);
    map.addLayer(point);
    // fit map to geojson
    map.fitBounds(point.getBounds());
  });

  /* GeoJSON Polyline */
  var polyline = L.geoJson(null, {
    onEachFeature: function(feature, layer) {
      var popupContent = "<h5>Polyline</h5>" +
        "<p>" + feature.properties.name + "</p>" +
        "<div class='d-flex flex-row'>" +
        "<a href='<?= base_url('edit-polyline') ?>/" + feature.properties.id + "' class='btn btn-sm btn-warning text-dark me-2'><i class='bi bi-pencil-square'></i></a>" +
        "<form action='<?= base_url('delete-polyline') . '/' ?>" + feature.properties.id + "' method='Post'>" +
        '<?= csrf_field(); ?>' +
        "<input type='hidden' name='_method' value='DELETE'>" +
        "<button type='submit' class='btn btn-sm btn-danger text-light' onclick='return confirm(`Are you sure you want to delete polyline " + feature.properties.name + "?`)'><i class='bi bi-trash-fill'></i></button>" +
        "</form>" +
        "</div>";
      layer.on({
        click: function(e) {
          polyline.bindPopup(popupContent);
        },
        mouseover: function(e) {
          polyline.bindTooltip(feature.properties.name);
        },
      });
    },
  });
  $.getJSON("<?= base_url('geojson-polylines') ?>", function(data) {
    polyline.addData(data);
    map.addLayer(polyline);
  });

  /* GeoJSON Polygon */
  var polygon = L.geoJson(null, {
    onEachFeature: function(feature, layer) {
      var popupContent = "<h5>Polygon</h5>" +
        "<p>" + feature.properties.name + "</p>" +
        "<div class='d-flex flex-row'>" +
        "<a href='<?= base_url('edit-polygon') ?>/" + feature.properties.id + "' class='btn btn-sm btn-warning text-dark me-2'><i class='bi bi-pencil-square'></i></a>" +
        "<form action='<?= base_url('delete-polygon') . '/' ?>" + feature.properties.id + "' method='Post'>" +
        '<?= csrf_field(); ?>' +
        "<input type='hidden' name='_method' value='DELETE'>" +
        "<button type='submit' class='btn btn-sm btn-danger text-light' onclick='return confirm(`Are you sure you want to delete polygon " + feature.properties.name + "?`)'><i class='bi bi-trash-fill'></i></button>" +
        "</form>" +
        "</div>";
      layer.on({
        click: function(e) {
          polygon.bindPopup(popupContent);
        },
        mouseover: function(e) {
          polygon.bindTooltip(feature.properties.name);
        },
      });
    },
  });
  $.getJSON("<?= base_url('geojson-polygons') ?>", function(data) {
    polygon.addData(data);
    map.addLayer(polygon);
  });
</script>
<?php $this->endSection(); ?>