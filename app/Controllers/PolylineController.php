<?php

namespace App\Controllers;

use App\Models\PolylineModel;

class PolylineController extends BaseController
{
	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->polylines = new PolylineModel();
	}
	/**
	 * Return an array of resource objects, themselves in array format
	 *
	 * @return mixed
	 */
	public function index()
	{
		//
	}

	/**
	 * Return the properties of a resource object
	 *
	 * @return mixed
	 */
	public function show($id = null)
	{
		//
	}

	/**
	 * Return a new resource object, with default properties
	 *
	 * @return mixed
	 */
	public function new()
	{
		//
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

		$sqlquery = "INSERT INTO polylines (geom, name, created_at, updated_at)
			VALUES (ST_GeomFromText('" . $this->request->getPost('geometry-polyline') . "'), '" . $this->request->getPost('name') . "', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "')";

		if(!$this->db->query($sqlquery)){
			return redirect()->to('/')->with('error', 'Failed to add polyline');
		}

		return redirect()->to('/')->with('success', 'Polyline added successfully');
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
			'title' => 'Leaflet CRUD',
			'page' => 'edit-polyline',
			'id' => $id,
		];
		return view('edit-polyline', $data);
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

		$sqlquery = "UPDATE polylines SET geom = ST_GeomFromText('" . $this->request->getPost('geometry-edit-polyline') . "'), name = '" .$this->request->getPost('name-edit-polyline') . "', updated_at = '" . date('Y-m-d H:i:s') . "' WHERE id = " . $id;

		if(!$this->db->query($sqlquery)){
			return redirect()->to('/')->with('error', 'Failed to update polyline');
		}

		return redirect()->to('/')->with('success', 'Polyline updated successfully');
	}

	/**
	 * Delete the designated resource object from the model
	 *
	 * @return mixed
	 */
	public function delete($id = null)
	{
		if(!$this->polylines->delete($id)) {
			return redirect()->to('/')->with('error', 'Failed to delete polyline');
		}

		return redirect()->to('/')->with('success', 'Polyline deleted successfully');
	}

	public function geojson()
	{
		$points = $this->polylines->getPolylines();

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

	public function geojsonpolyline($id)
	{
		$points = $this->polylines->getPolyline($id);

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
