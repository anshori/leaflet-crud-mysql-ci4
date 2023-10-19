<?php

namespace App\Controllers;

use App\Models\PointModel;

class PointController extends BaseController
{
	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->points = new PointModel();
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

		$sqlquery = "INSERT INTO points (geom, name, created_at, updated_at)
			VALUES (ST_GeomFromText('" . $this->request->getPost('geometry-point') . "'), '" . $this->request->getPost('name') . "', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "')";

		if(!$this->db->query($sqlquery)){
			return redirect()->to('/')->with('error', 'Failed to add point');
		}

		return redirect()->to('/')->with('success', 'Point added successfully');
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
			'title' => 'Edit Point',
			'page' => 'edit-point',
			'id' => $id,
		];
		return view('edit-point', $data);
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

		$sqlquery = "UPDATE points SET geom = ST_GeomFromText('" . $this->request->getPost('geometry-edit-point') . "'), name = '" .$this->request->getPost('name-edit-point') . "', updated_at = '" . date('Y-m-d H:i:s') . "' WHERE id = " . $id;

		if(!$this->db->query($sqlquery)){
			return redirect()->to('/')->with('error', 'Failed to update point');
		}

		return redirect()->to('/')->with('success', 'Point updated successfully');
	}

	/**
	 * Delete the designated resource object from the model
	 *
	 * @return mixed
	 */
	public function delete($id = null)
	{
		if(!$this->points->delete($id)) {
			return redirect()->to('/')->with('error', 'Failed to delete point');
		}

		return redirect()->to('/')->with('success', 'Point deleted successfully');
	}

	public function geojson()
	{
		$points = $this->points->getPoints();

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

	public function geojsonpoint($id)
	{
		$points = $this->points->getPoint($id);

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
