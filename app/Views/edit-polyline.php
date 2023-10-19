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
  var map = L.map('map').setView([-7.7911905,110.3708839], 14);

  // init basemap
  var basemap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '<a href="https://unsorry.net" target="_blank">unsorry@2023</a>',
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

  /* GeoJSON Polyline */
  var point = L.geoJson(null, {
    onEachFeature: function(feature, layer) {
      drawnItems.addLayer(layer);
      // fit to bounds
      map.fitBounds(layer.getBounds());
      layer.on({
        mouseover: function(e) {
          point.bindTooltip(feature.properties.name);
        },
      });
    },
  });
  $.getJSON("<?= base_url('geojson-polyline') . '/' . $id ?>", function(data) {
    point.addData(data);
  });

  var drawControl = new L.Control.Draw({
    draw: {
      position: 'topleft',
      polyline: false,
      polygon: false,
      rectangle: false,
      circle: false,
      marker: false,
      circlemarker: false
    },
    edit: {
      featureGroup: drawnItems,
      edit: true,
      remove: false
    }
  });

  map.addControl(drawControl);

  map.on('draw:edited', function(e) {
    var layers = e.layers;

    layers.eachLayer(function(layer) {
      var drawnJSONObject = layer.toGeoJSON();
      var objectGeometry = Terraformer.WKT.convert(drawnJSONObject.geometry);
      console.log(objectGeometry);
      $('#name-edit-polyline').val(layer.feature.properties.name);
      $('#geometry-edit-polyline').val(objectGeometry);
      // action form-update-polyline
      $('#form-update-polyline').attr('action', '<?= base_url('update-polyline') . '/' . $id ?>');
      $('#editpolylineModal').modal('show');
      // modal dismiss reload
      $('#editpolylineModal').on('hidden.bs.modal', function() {
        location.reload();
      });
    });
  });
</script>
<?php $this->endSection(); ?>