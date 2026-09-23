<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\HallbookingModel;
use Pdfcrowd\HtmlToImageClient;
use Dompdf\Dompdf;
use Dompdf\Options;

class Birthday extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common_helper');
        $this->model = new PermissionModel();
    }
	function birthday_wishes($mobile = ''){
		$message_params = array();
		$media['url'] = base_url() . '/uploads/birthday/e5dbe49f690a0220d902502d69a3f54a.jpg';
		$media['filename'] = 'birthday_wishes.jpg';
		$mn = '+919092615446';
		// print_r($mobile);
		// print_r($message_params);
		// print_r($media);
		// die; 
		//echo $mn;
		//$whatsapp_resp = whatsapp_aisensy($mn, $message_params, 'birthday_wishes_image_live', $media);
		//print_r($whatsapp_resp);
		$html = view('birthday/birthday_wishes');
		echo $html;
	}
	function design(){
		/* try
		{
			// create the API client instance
			$client = new \Pdfcrowd\HtmlToImageClient("demo", "ce544b6ea52a5621fb9d55f8b542d14d");

			// configure the conversion
			$client->setOutputFormat("png");

			// run the conversion and write the result to a file
			$client->convertUrlToFile("http://www.example.com", "example.png");
		}
		catch(\Pdfcrowd\Error $why)
		{
			error_log("Pdfcrowd Error: {$why}\n");
			throw $why;
		} */
		$html = view('birthday/design');
		echo $html;
	}
}
