<!-- Modal Info -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="infoModalLabel"><i class="bi bi-info-circle-fill"></i> Info</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-4">
          <div class="col">
            <h5 class="mb-3">Leaflet CRUD MySQL CI4</h5>
            <p class="mb-0">Stack:</p>
            <ul>
              <li>PHP Framework CodeIgniter 4 (built with version 4.4.1)</li>
              <li>MySQL Database</li>
            </ul>
            <p class="mb-0">Library:</p>
            <ul>
              <li>Leaflet JS</li>
              <li>Leaflet Draw</li>
              <li>Bootstrap 5</li>
              <li>ESRI Terraformer WKT Parser</li>
            </ul>
            <p class="mb-0">Based on:</p>
            <ul>
              <li><a href="https://github.com/anshori/leaflet-CRUD-MySQL/" target="_blank" rel="noopener noreferrer">https://github.com/anshori/leaflet-CRUD-MySQL/</a></li>
              <li><a href="https://github.com/andyprasetya/leaflet-CRUD" target="_blank" rel="noopener noreferrer">https://github.com/andyprasetya/leaflet-CRUD</a></li>
            </ul>
          </div>
        </div>

        <div class="row">
          <div class="col text-end">
            <small class="text-secondary">unsorry@2023</small>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Create Point -->
<div class="modal fade" id="createpointModal" tabindex="-1" aria-labelledby="createpointModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createpointModalLabel"><i class="bi bi-geo-alt-fill"></i> Create Point</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('create-point') ?>" method="Post">
          <?= csrf_field(); ?>
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Fill in the name" required>
          </div>
          <div class="mb-3">
            <label for="geometry-point" class="form-label">Geometry WKT</label>
            <textarea class="form-control" id="geometry-point" name="geometry-point" rows="3" readonly></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> Close</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Create Polyline -->
<div class="modal fade" id="createpolylineModal" tabindex="-1" aria-labelledby="createpolylineModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createpolylineModalLabel"><i class="bi bi-slash-lg"></i> Create Polyline</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('create-polyline') ?>" method="Post">
          <?= csrf_field(); ?>
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Fill in the name" required>
          </div>
          <div class="mb-3">
            <label for="geometry-polyline" class="form-label">Geometry WKT</label>
            <textarea class="form-control" id="geometry-polyline" name="geometry-polyline" rows="3" readonly></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> Close</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Create Polygon -->
<div class="modal fade" id="createpolygonModal" tabindex="-1" aria-labelledby="createpolygonModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createpolygonModalLabel"><i class="bi bi-pentagon-fill"></i> Create Polygon</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('create-polygon') ?>" method="Post">
          <?= csrf_field(); ?>
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Fill in the name" required>
          </div>
          <div class="mb-3">
            <label for="geometry-polygon" class="form-label">Geometry WKT</label>
            <textarea class="form-control" id="geometry-polygon" name="geometry-polygon" rows="3" readonly></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> Close</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> Save</button>
        </form>
      </div>
    </div>
  </div>
</div>