<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Online_aboutus extends BaseController
{
	function __construct(){
        parent:: __construct();
        helper('url');
        helper('common_helper');
        //$this->model = new PermissionModel();
    }
	public function index()
	{
        echo view('website/layout/header');
        echo view('website/aboutus');
        echo view('website/layout/footer');
    }
	
}	
