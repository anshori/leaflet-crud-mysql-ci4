<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        Session();
        
        $data = [
            'title' => 'Leaflet CRUD',
            'page' => 'map'
        ];
        return view('map', $data);
    }
}
