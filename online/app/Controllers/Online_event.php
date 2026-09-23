<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Online_event extends BaseController
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
        echo view('website/event');
        echo view('website/layout/footer');
    }
	
	public function event()
	{
        echo view('website/layout/header');
        echo view('website/event1');
        echo view('website/layout/footer');
    }
	
    public function getEventSummary()
	{
		$year = $_POST['year'];
		$month = $_POST['month'];
		$yrmonth = $year."-".str_pad($month, 2, '0', STR_PAD_LEFT);
		$html = '<h3 style="text-align:center;margin: 10px 0px 10px 0px;font-family: inherit;font-size: 30px">
		FESTIVALS - '.$year.'</h3>';
		$get_adata = $this->db->table("events")
							->select("*")
							->where("DATE_FORMAT(events.start,'%Y-%m') >=", $yrmonth)
							->where("DATE_FORMAT(events.end,'%Y-%m') <=", $yrmonth)
							->where("events.status", 1)
							->orderBy("events.start","asc")
							->get()
							->getResultArray();
		$html .='<div id="style-2" style="height:500px;overflow-y: scroll;padding: 0 5px 0 0;">';
		$monthName = getMonthName(str_pad($month, 2, '0', STR_PAD_LEFT));
		$html .='<h4 style="margin:0px !important;color: #fff;background: #f1c152;font-weight: bold;padding: 2%;text-align: center;font-family: Roboto;text-transform: uppercase;font-size: 18px;">'.$monthName.'</h4>';
		if(!empty($get_adata))
		{
			$html .='<div class="accordion accordion-flush" id="accordionFlushExample">';
			foreach($get_adata as $row)
			{
				$html .='<div class="accordion-item">
						<h2 class="accordion-header" id="flush-heading'.strtotime($row['start']).'">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse'.strtotime($row['start']).'" aria-expanded="false" aria-controls="flush-collapse'.strtotime($row['start']).'" style="background: whitesmoke;font-size: 15px;font-family: Roboto;color: #7e4555;font-weight: bold;">
							'.date("d/m/Y", strtotime($row['start'])).'
					  		</button>
						</h2>
						<div id="flush-collapse'.strtotime($row['start']).'" class="accordion-collapse collapse show" aria-labelledby="flush-heading'.strtotime($row['start']).'" data-bs-parent="#accordionFlushExample">
						<div class="accordion-body" style="padding: 0rem 1.25rem;">';

						$get_jan_member = $this->db->table("events")
												->select("*")
												->where("DATE_FORMAT(start,'%Y-%m-%d')", $row['start'])
												->orderBy("events.start","asc")
												->get()
												->getResultArray();
						foreach($get_jan_member as $member_row)
						{
							$html .='<p style="padding-left:2%;padding:1%;">'.$member_row['remark'].'</p>';
						}
				$html .='</div>
					</div>
				</div>';
			}
			$html .='</div>';
		}
		$html .='</div>';
		
		echo $html;
	}
	public function fetch_events()
    {
        $start = date("Y-m", strtotime($_POST['start']));
        $end = date("Y-m", strtotime($_POST['end']));
        $json = array();
        $eventArray = array();
		$result = $this->db->table("events")
							->select("id,
                            title_tamil,
                            title_english,
                            tamil_date,
                            day,
							remark,
							status,
							events.start,
							DATE_ADD(events.end, INTERVAL 1 DAY) AS end")
							->where('events.status', 1)
							->where("DATE_FORMAT(events.start,'%Y-%m') >=", $start)
							->where("DATE_FORMAT(events.end,'%Y-%m') <=", $end)
							->get()
							->getResultArray();
        foreach($result as $row)
        {
            array_push($eventArray, $row);
        }
		
        echo json_encode($eventArray);
	}
	public function festival()
	{
		$data['festivals'] = $this->db->table("festival_flipbook")->where('year_range','2023-2024')->get()->getRowArray();
        echo view('website/festival_flipbook',$data);
    }


}	
