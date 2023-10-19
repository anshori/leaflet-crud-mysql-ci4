<?php

namespace App\Controllers;

use App\Models\PolygonModel;

class PolygonController extends BaseController
{
  public function __construct()
  {
    $this->db = \Config\Database::connect();
    $this->polygons = new PolygonModel();
  }

  /**
   * Create a new resource object, from "posted" parameters
   *
   * @return mixed
   */
  public function create()
  {
    // timezone set to Asia/Jakarta
    date_default_timezone_set('Asia/Jakarta');

    $sqlquery = "INSERT INTO polygons (geom, name, created_at, updated_at)
            VALUES (ST_GeomFromText('" . $this->request->getPost('geometry-polygon') . "'), '" . $this->request->getPost('name') . "', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "')";

    if (!$this->db->query($sqlquery)) {
      return redirect()->to('/')->with('error', 'Failed to add polygon');
    }

    return redirect()->to('/')->with('success', 'Polygon added successfully');
  }

  /**
   * Return the editable properties of a resource object
   *
   * @return mixed
   */
  public function edit($id = null)
  {
    Session();

    $data = [
      'title' => 'Edit Polygon',
      'page' => 'edit-polygon',
      'id' => $id,
    ];
    return view('edit-polygon', $data);
  }

  /**
   * Add or update a model resource, from "posted" properties
   *
   * @return mixed
   */
  public function update($id = null)
  {
    // timezone set to Asia/Jakarta
		date_default_timezone_set('Asia/Jakarta');

		$sqlquery = "UPDATE polygons SET geom = ST_GeomFromText('" . $this->request->getPost('geometry-edit-polygon') . "'), name = '" .$this->request->getPost('name-edit-polygon') . "', updated_at = '" . date('Y-m-d H:i:s') . "' WHERE id = " . $id;

		if(!$this->db->query($sqlquery)){
			return redirect()->to('/')->with('error', 'Failed to update polygon');
		}

		return redirect()->to('/')->with('success', 'Polygon updated successfully');
  }

  /**
   * Delete the designated resource object from the model
   *
   * @return mixed
   */
  public function delete($id = null)
  {
    if (!$this->polygons->delete($id)) {
      return redirect()->to('/')->with('error', 'Failed to delete polygon');
    }

    return redirect()->to('/')->with('success', 'Polygon deleted successfully');
  }

  public function geojson()
  {
    $points = $this->polygons->getPolygons();

    $geojson = [
      'type' => 'FeatureCollection',
      'features' => [],
    ];
    foreach ($points as $row) {
      $feature = [
        'type' => 'Feature',
        'properties' => $row,
        'geometry' => json_decode($row['geom']),
      ];
      // make hidden geom
      unset($feature['properties']['geom']);

      array_push($geojson['features'], $feature);
    }

    // json numeric check
    $geojson = json_encode($geojson, JSON_NUMERIC_CHECK);

    return $this->response->setJSON($geojson);
  }

  public function geojsonpolygon($id)
  {
    $points = $this->polygons->getPolygon($id);

    $geojson = [
      'type' => 'FeatureCollection',
      'features' => [],
    ];
    foreach ($points as $row) {
      $feature = [
        'type' => 'Feature',
        'properties' => $row,
        'geometry' => json_decode($row['geom']),
      ];
      // make hidden geom
      unset($feature['properties']['geom']);

      array_push($geojson['features'], $feature);
    }

    // json numeric check
    $geojson = json_encode($geojson, JSON_NUMERIC_CHECK);

    return $this->response->setJSON($geojson);
  }
}
