<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\RequestModel;

class Website_home extends BaseController
{
    public function index()
	{
        $data['list'] = $this->db->table('reviews1')
								->select('reviews1.*')
								->get()->getResultArray();
        
        echo view('website/home/index',$data);
    }
}