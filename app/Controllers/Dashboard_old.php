<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;
class Dashboard extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common_helper');
		$this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
    
    public function index(){
		$data['view'] = true;
		if(!$this->model->list_validate('dashboard')){
			$data['view'] = false;
		}
		//$_SESSION['language'] = 'english';
		//global $lang;
		//echo $lang->login;
		//die;
		$dt= date('Y-m-d');
        $res['data']= $this->db->table('admin_profile')->get()->getRowArray();

		// $builder = $this->db->table("ubayam as u")
		// 			->join('ubayam_setting as us', 'us.id = u.pay_for')
		// 			->join('ubayam_pay_details as upd', 'upd.ubayam_id = u.id', 'left')
		// 			->join('payment_mode as pm', 'pm.id = upd.payment_mode', 'left')
		// 			->join('ubayam_payment_gateway_datas as upgd', 'upgd.ubayam_id = u.id', 'left')
		// 			->select(" us.name as ubname, upd.amount as amount");
		// 		$ubayam_data = $builder->where("DATE_FORMAT(upd.date, '%Y-%m-%d')", $dt)
		// 			->groupStart()
		// 			->whereNotIn("u.payment_status", array(1, 3))
		// 			->Orwhere('u.payment_status IS NULL')
		// 			->groupEnd()
		// 			->groupBy('u.id')
		// 			->get()
		// 			->getResultArray();
		// $data['ubayam'] = $ubayam_data;

        $data['donation'] = $this->db->table('donation', 'donation_setting.name')
					->join('donation_setting', 'donation_setting.id = donation.pay_for')
					->select('donation_setting.name as dname, sum(donation.amount) as amount')
					->groupBy('donation.pay_for')
					->where('donation.date',$dt)
                    ->limit(0,5)
                    ->orderBy('donation.id', 'DESC')
					->get()->getResultArray();
		//$data['hall'] = $this->db->table('hall_booking')->select('hall_booking.id, hall_booking.event_name, sum(hall_booking_pay_details.amount) as amount')->join('hall_booking_pay_details', 'hall_booking_pay_details.hall_booking_id = hall_booking.id')->where('DATE_FORMAT(hall_booking.entry_date, "%Y-%m-%d")=',$dt)->whereIn('hall_booking.status',array(1,2))->groupBy('hall_booking.id') ->get()->getResultArray();
		$data['archanai'] = $this->db->query("SELECT sum(archanai_booking_details.quantity) as tQty, sum(archanai_booking_details.total_amount + archanai_booking_details.total_commision) as tAmt, archanai.id,archanai.name_eng,archanai.name_tamil FROM archanai join archanai_booking_details on archanai.id=archanai_booking_details.archanai_id join archanai_booking on archanai_booking.id=archanai_booking_details.archanai_booking_id where archanai_booking.date='". $dt ."' group by id order by id")->getResultArray();

		$data['inventory_stock'] = $this->db->query("SELECT stock_outward_list.item_name,SUM(stock_outward_list.quantity) as inventory_qty FROM stock_outward join stock_outward_list on stock_outward.id = stock_outward_list.stack_out_id where stock_outward_list.item_type = 2 and stock_outward.date = '". $dt ."' group by stock_outward_list.item_id")->getResultArray();

		$data['minimum_stock'] = $this->db->query("SELECT name, opening_stock as stock, 'Raw Material' as type FROM `raw_matrial_groups` where opening_stock <= minimum_stock UNION ALl SELECT name, opening_stock as stock, 'Product' as type FROM `product` where opening_stock <= minimum_stock")->getResultArray();
        // $query = $this->db->query("SELECT * FROM ubayam ORDER BY id DESC LIMIT 5");
        // $data['ubayam'] = $query->getResultArray();
        //$query = $this->db->query("SELECT * FROM donation ORDER BY id DESC LIMIT 5");
        //$data['donation'] = $query->getResultArray();
        //echo '<pre>'; print_r($data);die;
		$data["archanai_charts"] = archanai_charts();
		// $data["hallbooking_charts"] = hallbooking_charts();
		echo view('template/header', $res);
		echo view('template/sidebar');
		echo view('template/content', $data);
		echo view('template/footer');
    }
	public function reload_list(){
		$json_resp = array();
		$data = array();
		if(!empty($_POST['dt'])){
			$dt= date('Y-m-d',strtotime($_POST['dt']));
			// $data['ubayam'] = $this->db->table('ubayam', 'ubayam_setting.name')
			// 			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
			// 			->select('ubayam_setting.name as ubname, sum(ubayam.amount) as amount')
			// 			->where('ubayam.dt',$dt)
			// 			->groupBy('ubayam.pay_for')
			// 			->limit(0,5)
			// 			->orderBy('ubayam.id', 'DESC')
			// 			->get()->getResultArray();

			$data['donation'] = $this->db->table('donation', 'donation_setting.name')
						->join('donation_setting', 'donation_setting.id = donation.pay_for')
						->select('donation_setting.name as dname, sum(donation.amount) as amount')
						->where('donation.date',$dt)
						->groupBy('donation.pay_for')
						->limit(0,5)
						->orderBy('donation.id', 'DESC')
						->get()->getResultArray();
			//$data['hall'] = $this->db->table('hall_booking')->select('hall_booking.id, hall_booking.event_name, sum(hall_booking_pay_details.amount) as amount')->join('hall_booking_pay_details', 'hall_booking_pay_details.hall_booking_id = hall_booking.id')->where('DATE_FORMAT(hall_booking.entry_date, "%Y-%m-%d")=',$dt)->whereIn('hall_booking.status',array(1,2))->groupBy('hall_booking.id') ->get()->getResultArray();
			$data['archanai'] = $this->db->query("SELECT sum(archanai_booking_details.quantity) as tQty, sum(archanai_booking_details.total_amount + archanai_booking_details.total_commision) as tAmt, archanai.id,archanai.name_eng,archanai.name_tamil FROM archanai join archanai_booking_details on archanai.id=archanai_booking_details.archanai_id join archanai_booking on archanai_booking.id=archanai_booking_details.archanai_booking_id where archanai_booking.date='". $dt ."' group by id order by id")->getResultArray();
			$data['minimum_stock'] = $this->db->query("SELECT name, opening_stock as stock, 'Raw Material' as type FROM `raw_matrial_groups` where opening_stock <= minimum_stock UNION ALl SELECT name, opening_stock as stock, 'Product' as type FROM `product` where opening_stock <= minimum_stock")->getResultArray();
		}
		$json_resp['data'] = $data;
		$json_resp['success'] = true;
		echo json_encode($json_resp);
		exit;
	}
    // public function ubayam_rep(){
	// 	$dt= date('Y-m-d',strtotime($_POST['dt']));
	// 	$data = [];
	// 	$dat =  $this->db->table('ubayam', 'ubayam_setting.name as pname')
	// 	->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
	// 	->select('ubayam_setting.name as pname')
	// 	->select('ubayam.*')
	// 	->where('ubayam.dt=',$dt) 
	// 	->get()->getResultArray();
    //     $i=0;
	// 	foreach($dat as $row)
	// 	{
    //         $i++;
	// 		$data[] = array(
	// 			$row ['name'],
	// 			$row ['amount'],
	// 		);
	// 	}
		
	// $result = array(
	// 	"draw" => 0,
	// 	"recordsTotal" => $i-1,
	// 	"recordsFiltered" => $i-1,
	// 	"data" => $data,
	// );
	// echo json_encode($result);
	// exit();		
    // }
    public function cash_don_rep(){
		$dt= date('Y-m-d',strtotime($_POST['dt']));
		$data = [];
		$dat = $this->db->table('donation', 'donation_setting.name as pname')
		->join('donation_setting', 'donation_setting.id = donation.pay_for')
		->select('donation_setting.name as pname')
		->select('donation.*')
		->where('donation.date=',$dt) 
		->get()->getResultArray();
        // echo '<pre>';
        // print_r($dat); exit;
        $i=0;
		foreach($dat as $row)
		{
            $i++;
			$data[] = array(
				$row ['pname'],
				$row ['amount'],
			);
		}
		
	$result = array(
		"draw" => 0,
		"recordsTotal" => $i-1,
		"recordsFiltered" => $i-1,
		"data" => $data,
	);
	echo json_encode($result);
	exit();		
    }
    public function arch_rep(){
		$dt= date('Y-m-d',strtotime($_POST['dt']));
		$data = [];

        $query   = $this->db->query("SELECT sum(archanai_booking_details.quantity) as tQty, sum(archanai_booking_details.amount) as tAmt, archanai.id,archanai.name_eng,archanai.name_tamil FROM archanai join archanai_booking_details on archanai.id=archanai_booking_details.archanai_id join archanai_booking on archanai_booking.id=archanai_booking_details.archanai_booking_id where archanai_booking.date='". $dt ."' group by id order by id");
		$i=0;
		foreach($query->getResultArray() as $row)
		{
            $i++;
			$data[] = array(
				$row ['name_eng'],
				$row ['tQty'],
				$row ['tAmt'],
			);
		}
		
	$result = array(
		"draw" => 0,
		"recordsTotal" => $i-1,
		"recordsFiltered" => $i-1,
		"data" => $data,
	);
	echo json_encode($result);
	exit();		
    }
    // public function hall_rep(){
	// 	$dt= date('Y-m-d',strtotime($_POST['dt']));
	// 	$data = [];


	// 	$dat = $this->db->table('hall_booking')->where('booking_date=',$dt) ->get()->getResultArray();
    //     // echo '<pre>';
    //     // print_r($dat); exit;

    //     $i=0;
	// 	foreach($dat as $row)
	// 	{
	// 		if($row ['paid_amount'] > 0){
	// 			$i++;
	// 			$data[] = array(
	// 				$row ['event_name'],
	// 				$row ['paid_amount'],
	// 			);
	// 		}  
	// 	}
		
	// $result = array(
	// 	"draw" => 0,
	// 	"recordsTotal" => $i-1,
	// 	"recordsFiltered" => $i-1,
	// 	"data" => $data,
	// );
	// echo json_encode($result);
	// exit();		
    // }
	public function AmountInWords(){
        $amount = (float)$_POST['number'];
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
		// // return ($num).'';
		// // exit;
        // Check if there is any number after decimal
		function NumToWords($num){
			$num=floor($num);
			$amt_hundred = null;
			$count_length = strlen($num);
			$x = 0;
			$string = array();
			$change_words = array(0 => '', 1 => 'One', 2 => 'Two',
				3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
				7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
				10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
				13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
				16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
				19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
				40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
				70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
				$here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
				while( $x < $count_length ) {
					$get_divider = ($x == 2) ? 10 : 100;
					$amount = floor($num % $get_divider);
					$num = floor($num / $get_divider);
					$x += $get_divider == 10 ? 1 : 2;
					if ($amount) {
						$add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
						$amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
						$string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
					}else $string[] = null;
			}
			//$implode_to_Rupees = implode('', array_reverse($string));
			return(implode('', array_reverse($string)));
		}
        
        /*$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
        " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';*/
        //$get_paise = ($amount_after_decimal > 0) ? " and Cents ".(trim($change_words[$amount_after_decimal])): '';
        
		$get_paise = ($amount_after_decimal > 0) ? " and Cents ". trim(NumToWords($amount_after_decimal)):'';
        //return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
        return (NumToWords($amount) ? 'Ringgit '.trim(NumToWords($amount)).'' : ''). $get_paise. ' Only';
        
		//return ($implode_to_paise).'';
		//echo json_encode($amt_words);
    }
	
	public function AmountInWords2(){
		
		// after decimal if 99 is nine nine
        
        $amount = (float)$_POST['number'];
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
		
        // Check if there is any number after decimal
        $amt_hundred = null;
        $count_length = strlen($num);
        $x = 0;
        $string = array();
        $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
            $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
            while( $x < $count_length ) {
                $get_divider = ($x == 2) ? 10 : 100;
                $amount = floor($num % $get_divider);
                $num = floor($num / $get_divider);
                $x += $get_divider == 10 ? 1 : 2;
                if ($amount) {
                    $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
                    $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                    $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
                }else $string[] = null;
        }
        $implode_to_Rupees = implode('', array_reverse($string));
        /*$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
        " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';*/
        $get_paise = ($amount_after_decimal > 0) ? " and Cents ".(trim($change_words[$amount_after_decimal /10]).' '. trim($change_words[$amount_after_decimal % 10]))  : '';
        
		//$get_paise = ($amount_after_decimal > 0) ? " and Cents ".(trim($change_words[$amount_after_decimal])):'';
        //return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
        return ($implode_to_Rupees ? 'Ringgit '.trim($implode_to_Rupees).'' : ''). $get_paise. ' Only';
        
		//return ($amount_after_decimal).'';
		//echo json_encode($amt_words);
    }
    
    public function chart() {
		echo view('template/header');
		echo view('template/sidebar');
		echo view('template/chart');
		//echo view('template/footer');
    }
	
}
