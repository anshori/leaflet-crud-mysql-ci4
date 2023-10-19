<?php

namespace App\Models;

use CodeIgniter\Model;

class PolylineModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'polylines';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'geom',
        'name',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getPolylines()
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT id, name, ST_AsGeoJSON(geom) as geom FROM polylines');
        $results = $query->getResultArray();
        return $results;
    }

    public function getPolyline($id)
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT id, name, ST_AsGeoJSON(geom) as geom FROM polylines WHERE id = ' . $id);
        $results = $query->getResultArray();
        return $results;
    }
}
