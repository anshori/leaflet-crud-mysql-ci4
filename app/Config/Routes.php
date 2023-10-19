<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Create
$routes->post('/create-point', 'PointController::create');
$routes->post('/create-polyline', 'PolylineController::create');
$routes->post('/create-polygon', 'PolygonController::create');

// Edit
$routes->get('/edit-point/(:num)', 'PointController::edit/$1');
$routes->get('/edit-polyline/(:num)', 'PolylineController::edit/$1');
$routes->get('/edit-polygon/(:num)', 'PolygonController::edit/$1');

// Update
$routes->put('/update-point/(:num)', 'PointController::update/$1');
$routes->put('/update-polyline/(:num)', 'PolylineController::update/$1');
$routes->put('/update-polygon/(:num)', 'PolygonController::update/$1');

// Delete
$routes->delete('/delete-point/(:num)', 'PointController::delete/$1');
$routes->delete('/delete-polyline/(:num)', 'PolylineController::delete/$1');
$routes->delete('/delete-polygon/(:num)', 'PolygonController::delete/$1');

// GeoJSON
$routes->get('/geojson-points', 'PointController::geojson');
$routes->get('/geojson-point/(:num)', 'PointController::geojsonpoint/$1');
$routes->get('/geojson-polylines', 'PolylineController::geojson');
$routes->get('/geojson-polyline/(:num)', 'PolylineController::geojsonpolyline/$1');
$routes->get('/geojson-polygons', 'PolygonController::geojson');
$routes->get('/geojson-polygon/(:num)', 'PolygonController::geojsonpolygon/$1');