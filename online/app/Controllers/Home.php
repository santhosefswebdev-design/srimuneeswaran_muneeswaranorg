<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Home extends BaseController
{
	function __construct(){
        parent:: __construct();
        helper('url');
        //$this->model = new PermissionModel();
    }
	public function index()
	{
		echo view('website/layout/header');
		echo view('website/index');
		echo view('website/layout/footer');
    }
	
	
}
