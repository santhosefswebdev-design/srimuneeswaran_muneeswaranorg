<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\HallbookingModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Cron extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common_helper');
        $this->model = new PermissionModel();
    }
    public function hallbook_remainder_notification()
    {
      $email = \Config\Services::email();
      $profile_id = 1;
      $query = $this->db->table('admin_profile')->where('id', $profile_id)->get()->getRowArray();
      $days = $query['hall_remind'];
      if($days!=0 || !empty($days)) {
        $hallremind_days = $days;
      }
      else{
        $hallremind_days = 5;
      }
		  $lists = $this->db->query("SELECT *, abs(datediff(DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d'), NOW())) as interval_date FROM hall_booking WHERE DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d') >= NOW() AND DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')  < NOW() + INTERVAL $hallremind_days DAY and paid_amount < total_amount;")->getResultArray();
        foreach($lists as $row)
        {
          if(!empty($row['email']))
          {
            $interval_date = $row['interval_date'];
            $html = "Hi, ";
            $html .= "Your booking has remaining $interval_date days to schedule, You need to pay the remaining amount.";
            $to = $row['email'];
            $subject = "Hall Booking Reminder";
            $message = $html;
            $email->setTo($to);
            $email->setFrom('templetest@grasp.com.my', 'Temple Rajamariamman');
          // $email->setNewline("\r\n");
            $email->setSubject($subject);
            $email->setMessage($message);
            $email->send();
          }
       }

    }
    function testmail()
    {
      $email = \Config\Services::email();
      $html = "Hi, ";
      $html .= "this is test mail";
      $to = "rajkumar.bizsoft@gmail.com";
      $subject = "Test Mail";
      $message = $html;
      $email->setTo($to);
      $email->setFrom('templetest@grasp.com.my', 'Test Mail');
    // $email->setNewline("\r\n");
      $email->setSubject($subject);
      $email->setMessage($message);
      $email->send();
      //echo $email->print_debugger();
    }
    function daily_closing($mobile = ''){
		$tmpid = 1;
		$dailyclosing_start_date = date('Y-m-d');
		$dailyclosing_end_date = date("Y-m-d");
		$archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$archanai_diety_data_online = daily_diety_archanai_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['archanai_diety_details'] = $archanai_diety_data_online;
		$data['archanai_details'] = $archanai_data_online;
		$hallbooking_data_online = daily_hall_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['hallbooking_details'] = $hallbooking_data_online;
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['donation_details'] = $donation_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['prasadam_details'] = $prasadam_data;
		$data['temp_details'] = $temp_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
		$mobile_number = array();
		if(empty($mobile) && !empty($temp_details['daily_closing_phone'])){
			$daily_closing_phone = json_decode($temp_details['daily_closing_phone'], true);
			if(!empty($daily_closing_phone[0]['phonecode']) && !empty($daily_closing_phone[0]['phoneno'])){
				foreach($daily_closing_phone as $dcp){
					$mobile_number[] = $dcp['phonecode'] . $dcp['phoneno'];
				}
			}
		}else $mobile_number[] = $mobile;
		if(count($mobile_number) > 0){
			foreach($mobile_number as $mn){
				$html = view('daily_closing/pdf', $data);
				// echo $html;
				// die;
				$options = new Options();
				$options->set('isHtml5ParserEnabled', true);
				$options->set(array('isRemoteEnabled'=>true));
				$options->set('isPhpEnabled', true);
				$dompdf = new Dompdf($options);
				$dompdf->loadHtml($html);
				$dompdf->setPaper('A4', 'portrait');
				$dompdf->render();
				$filePath = FCPATH . 'uploads/documents/daily_closing_' . time() . '.pdf';
				file_put_contents($filePath, $dompdf->output());
				$message_params = array();
				$media['url'] = base_url() . '/uploads/documents/daily_closing_' . time() . '.pdf';
				$media['filename'] = 'daily_closing.pdf';
				// $mobile = '+919092615446';
				// print_r($mobile);
				// print_r($message_params);
				// print_r($media);
				// die; 
				echo $mn;
				$whatsapp_resp = whatsapp_aisensy($mn, $message_params, 'daily_closing_live', $media);
				print_r($whatsapp_resp);
			}
		}
	}
	function daily_closing_pl($mobile = ''){
		$tmpid = 1;
		$dailyclosing_start_date = date('Y-m-d');
		$dailyclosing_end_date = date('Y-m-d');
		$getMonthsInRange = array();
		$bd_colspan = 1;
		$from_date = $dailyclosing_start_date;
		$to_date = $dailyclosing_end_date;
		$data['temp_details'] = $temp_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
		$whr = '';
		
		// Sales //
		
		$top_sales_group = $this->db->table("groups")->where('code', 4000)->get()->getRowArray();
		$sales_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_sales_group['id'] ." and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
		$top_sales_group_total = 0;
		$table[] = '<tr><td style="font-weight: bold;font-size: medium;" align="left" class="level_0 level_groups">'.$top_sales_group['name'].'</td><td></td></tr>';
		if(count($sales_groups) > 0){
			foreach($sales_groups as $sales_group){
				$group_id = $sales_group['group_id'];
				$total = $sales_group['cr_total'] - $sales_group['dr_total'];
				$top_sales_group_total += $total;
				$ledgercode = $sales_group['left_code'] . '/' . $sales_group['right_code'];
				$ledgername = $sales_group['ledger_name'];
				if($total < 0) $total_amount = "( ".number_format(abs($total),2)." )";
				else $total_amount = number_format($total,2);
				$table[] .= '<tr>
								<td align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
				$table[] .= '<td align="right" >'.$total_amount.'</td>';
				$table[] .= '</tr>';
			}
		}
		$list_sub_groups =  $this->db->table("groups")->where('parent_id', $top_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
		if(count($list_sub_groups) > 0){
			$list_sub_groups_total = 0;
			foreach($list_sub_groups as $list_sub_group){
				$sub_group_id = $list_sub_group['id'];
				$sales_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
				if(count($sales_sub_groups) > 0){
					$table[] = '<tr><td style="font-weight: bold;font-size: medium;" align="left" class="level_1 level_groups">'.$list_sub_group['name'].'</td><td></td></tr>';
					$sales_sub_groups_total = 0;
					foreach($sales_sub_groups as $sales_sub_group){
						$total = $sales_sub_group['cr_total'] - $sales_sub_group['dr_total'];
						$sales_sub_groups_total += $total;
						$ledgercode = $sales_sub_group['left_code'] . '/' . $sales_sub_group['right_code'];
						$ledgername = $sales_sub_group['ledger_name'];
						if($total < 0) $total_amount = "( ".number_format(abs($total),2)." )";
						else $total_amount = number_format($total,2);
						$table[] .= '<tr>
										<td align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
						$table[] .= '<td align="right" >'.$total_amount.'</td>';
						$table[] .= '</tr>';
					}
					if($sales_sub_groups_total < 0) $sales_sub_groups_total_amount = "( ".number_format(abs($sales_sub_groups_total),2)." )";
					else $sales_sub_groups_total_amount = number_format($sales_sub_groups_total,2);
					$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total '.$list_sub_group['name'].'</td><td>'.$sales_sub_groups_total_amount.'</td></tr>';
					$list_sub_groups_total += $sales_sub_groups_total;
				}
				$list_sub_sub_groups =  $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
				$list_sub_sub_groups_total = 0;
				if(count($list_sub_sub_groups) > 0){
					foreach($list_sub_sub_groups as $list_sub_sub_group){
						$sub_sub_group_id = $list_sub_sub_group['id'];
						$sales_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
						if(count($sales_sub_sub_groups) > 0){
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" align="left" class="level_2 level_groups">'.$list_sub_sub_group['name'].'</td><td></td></tr>';
							$sales_sub_sub_groups_total = 0;
							foreach($sales_sub_sub_groups as $sales_sub_sub_group){
								$total = $sales_sub_sub_group['cr_total'] - $sales_sub_sub_group['dr_total'];
								$sales_sub_sub_groups_total += $total;
								$ledgercode = $sales_sub_sub_group['left_code'] . '/' . $sales_sub_sub_group['right_code'];
								$ledgername = $sales_sub_sub_group['ledger_name'];
								if($sales_sub_sub_groups_total < 0) $sales_sub_sub_groups_total_amount = "( ".number_format(abs($sales_sub_sub_groups_total),2)." )";
								else $sales_sub_sub_groups_total_amount = number_format($sales_sub_sub_groups_total,2);
								$table[] .= '<tr>
												<td class="level_ledger" align="left">(' . $ledgercode . ')' .$ledgername.'</td>';
								$table[] .= '<td align="right" >'.number_format($sales_sub_sub_groups_total_amount, "2",".",",").'</td>';
								$table[] .= '</tr>';
							}
							if($sales_sub_sub_groups_total < 0) $sales_sub_sub_groups_total_amount = "( ".number_format(abs($sales_sub_sub_groups_total),2)." )";
							else $sales_sub_sub_groups_total_amount = number_format($sales_sub_sub_groups_total,2);
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total '.$list_sub_sub_group['name'].'</td><td>'.$sales_sub_sub_groups_total_amount.'</td></tr>';
							$list_sub_sub_groups_total += $sales_sub_sub_groups_total;
						}
					}
				}
				$list_sub_groups_total += $list_sub_sub_groups_total;
			}
			$top_sales_group_total += $list_sub_groups_total;
		}
		if($total < 0) $top_sales_group_total_amount = "( ".number_format(abs($top_sales_group_total),2)." )";
		else $top_sales_group_total_amount = number_format($top_sales_group_total,2);
		$table[] .= '<tr>
						<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' .$top_sales_group['name'].'</td>';
		$table[] .= '<td align="right" >'.$top_sales_group_total_amount.'</td>';
		$table[] .= '</tr>';
		
		// Cost of Sales //
		
		$top_co_sales_group = $this->db->table("groups")->where('code', 5000)->get()->getRowArray();
		$co_sales_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_co_sales_group['id'] ." and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
		$top_co_sales_group_total = 0;
		$table[] = '<tr><td align="left" style="font-weight: bold;font-size: medium;" class="level_0 level_groups">'.$top_co_sales_group['name'].'</td><td></td></tr>';
		if(count($co_sales_groups) > 0){
			foreach($co_sales_groups as $co_sales_group){
				$group_id = $co_sales_group['group_id'];
				$total = $co_sales_group['dr_total'] - $co_sales_group['cr_total'];
				$top_co_sales_group_total += $total;
				$ledgercode = $co_sales_group['left_code'] . '/' . $co_sales_group['right_code'];
				$ledgername = $co_sales_group['ledger_name'];
				if($total < 0) $total_amount = "( ".number_format(abs($total),2)." )";
				else $total_amount = number_format($total,2);
				$table[] .= '<tr>
								<td align="left" align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
				$table[] .= '<td align="right" >'.$total_amount.'</td>';
				$table[] .= '</tr>';
			}
		}
		$list_sub_groups =  $this->db->table("groups")->where('parent_id', $top_co_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
		if(count($list_sub_groups) > 0){
			$list_sub_groups_total = 0;
			foreach($list_sub_groups as $list_sub_group){
				$sub_group_id = $list_sub_group['id'];
				$co_sales_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
				if(count($co_sales_sub_groups) > 0){
					$table[] = '<tr><td align="left" style="font-weight: bold;font-size: medium;" class="level_1 level_groups">'.$list_sub_group['name'].'</td><td></td></tr>';
					$co_sales_sub_groups_total = 0;
					foreach($co_sales_sub_groups as $co_sales_sub_group){
						$total = $co_sales_sub_group['dr_total'] - $co_sales_sub_group['cr_total'];
						$co_sales_sub_groups_total += $total;
						$ledgercode = $co_sales_sub_group['left_code'] . '/' . $co_sales_sub_group['right_code'];
						$ledgername = $co_sales_sub_group['ledger_name'];
						if($total < 0) $total_amount = "( ".number_format(abs($total),2)." )";
						else $total_amount = number_format($total,2);
						$table[] .= '<tr>
										<td align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
						$table[] .= '<td align="right" >'.$total_amount.'</td>';
						$table[] .= '</tr>';
					}
					if($co_sales_sub_groups_total < 0) $co_sales_sub_groups_total_amount = "( ".number_format(abs($co_sales_sub_groups_total),2)." )";
					else $co_sales_sub_groups_total_amount = number_format($co_sales_sub_groups_total,2);
					$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total '.$list_sub_group['name'].'</td><td>'.$co_sales_sub_groups_total_amount.'</td></tr>';
					$list_sub_groups_total += $co_sales_sub_groups_total;
				}
				$list_sub_sub_groups =  $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
				$list_sub_sub_groups_total = 0;
				if(count($list_sub_sub_groups) > 0){
					foreach($list_sub_sub_groups as $list_sub_sub_group){
						$sub_sub_group_id = $list_sub_sub_group['id'];
						$co_sales_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
						if(count($co_sales_sub_sub_groups) > 0){
							$table[] = '<tr><td align="left" style="font-weight: bold;font-size: medium;" class="level_2 level_groups">'.$list_sub_sub_group['name'].'</td><td></td></tr>';
							$co_sales_sub_sub_groups_total = 0;
							foreach($co_sales_sub_sub_groups as $co_sales_sub_sub_group){
								$total = $co_sales_sub_sub_group['dr_total'] - $co_sales_sub_sub_group['cr_total'];
								$co_sales_sub_sub_groups_total += $total;
								$ledgercode = $co_sales_sub_sub_group['left_code'] . '/' . $co_sales_sub_sub_group['right_code'];
								$ledgername = $co_sales_sub_sub_group['ledger_name'];
								if($co_sales_sub_sub_groups_total < 0) $co_sales_sub_sub_groups_total_amount = "( ".number_format(abs($co_sales_sub_sub_groups_total),2)." )";
								else $co_sales_sub_sub_groups_total_amount = number_format($co_sales_sub_sub_groups_total,2);
								$table[] .= '<tr>
												<td align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
								$table[] .= '<td align="right" >'.number_format($co_sales_sub_sub_groups_total_amount, "2",".",",").'</td>';
								$table[] .= '</tr>';
							}
							if($co_sales_sub_sub_groups_total < 0) $co_sales_sub_sub_groups_total_amount = "( ".number_format(abs($co_sales_sub_sub_groups_total),2)." )";
							else $co_sales_sub_sub_groups_total_amount = number_format($co_sales_sub_sub_groups_total,2);
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total '.$list_sub_sub_group['name'].'</td><td>'.$co_sales_sub_sub_groups_total_amount.'</td></tr>';
							$list_sub_sub_groups_total += $co_sales_sub_sub_groups_total;
						}
					}
				}
				$list_sub_groups_total += $list_sub_sub_groups_total;
			}
			$top_co_sales_group_total += $list_sub_groups_total;
		}
		if($total < 0) $top_co_sales_group_total_amount = "( ".number_format(abs($top_co_sales_group_total),2)." )";
		else $top_co_sales_group_total_amount = number_format($top_co_sales_group_total,2);
		$table[] .= '<tr>
						<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' .$top_co_sales_group['name'].'</td>';
		$table[] .= '<td align="right" >'.$top_co_sales_group_total_amount.'</td>';
		$table[] .= '</tr>';
		$gross_profit = $top_sales_group_total -$top_co_sales_group_total;
		
		if($gross_profit < 0){ 
			$gross_profit_amount = "( ".number_format(abs($gross_profit),2)." )";
			$gross_profit_txt = 'Gross Surplus';
		}else{
			$gross_profit_amount = number_format($gross_profit,2);
			$gross_profit_txt = 'Gross (Deficit)';
		}
		
		$table[] .= '<tr>
						<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">'.$gross_profit_txt.'</td>';
		$table[] .= '<td align="right" >'.$gross_profit_amount.'</td>';
		$table[] .= '</tr>';
		
		// Incomes
		
		$top_incomes_group = $this->db->table("groups")->where('code', 8000)->get()->getRowArray();
		$incomes_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_incomes_group['id'] ." and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
		$top_incomes_group_total = 0;
		$table[] = '<tr><td align="left" style="font-weight: bold;font-size: medium;" class="level_0 level_groups">'.$top_incomes_group['name'].'</td><td></td></tr>';
		if(count($incomes_groups) > 0){
			foreach($incomes_groups as $incomes_group){
				$group_id = $incomes_group['group_id'];
				$total = $incomes_group['cr_total'] - $incomes_group['dr_total'];
				$top_incomes_group_total += $total;
				$ledgercode = $incomes_group['left_code'] . '/' . $incomes_group['right_code'];
				$ledgername = $incomes_group['ledger_name'];
				if($total < 0) $total_amount = "( ".number_format(abs($total),2)." )";
				else $total_amount = number_format($total,2);
				$table[] .= '<tr>
								<td align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
				$table[] .= '<td align="right" >'.$total_amount.'</td>';
				$table[] .= '</tr>';
			}
		}
		$list_sub_groups =  $this->db->table("groups")->where('parent_id', $top_incomes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
		if(count($list_sub_groups) > 0){
			$list_sub_groups_total = 0;
			foreach($list_sub_groups as $list_sub_group){
				$sub_group_id = $list_sub_group['id'];
				$incomes_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
				if(count($incomes_sub_groups) > 0){
					$table[] = '<tr><td align="left" style="font-weight: bold;font-size: medium;" class="level_1 level_groups">'.$list_sub_group['name'].'</td><td></td></tr>';
					$incomes_sub_groups_total = 0;
					foreach($incomes_sub_groups as $incomes_sub_group){
						$total = $incomes_sub_group['cr_total'] - $incomes_sub_group['dr_total'];
						$incomes_sub_groups_total += $total;
						$ledgercode = $incomes_sub_group['left_code'] . '/' . $incomes_sub_group['right_code'];
						$ledgername = $incomes_sub_group['ledger_name'];
						if($total < 0) $total_amount = "( ".number_format(abs($total),2)." )";
						else $total_amount = number_format($total,2);
						$table[] .= '<tr>
										<td align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
						$table[] .= '<td align="right" >'.$total_amount.'</td>';
						$table[] .= '</tr>';
					}
					if($incomes_sub_groups_total < 0) $incomes_sub_groups_total_amount = "( ".number_format(abs($incomes_sub_groups_total),2)." )";
					else $incomes_sub_groups_total_amount = number_format($incomes_sub_groups_total,2);
					$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total '.$list_sub_group['name'].'</td><td>'.$incomes_sub_groups_total_amount.'</td></tr>';
					$list_sub_groups_total += $incomes_sub_groups_total;
				}
				$list_sub_sub_groups =  $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
				$list_sub_sub_groups_total = 0;
				if(count($list_sub_sub_groups) > 0){
					foreach($list_sub_sub_groups as $list_sub_sub_group){
						$sub_sub_group_id = $list_sub_sub_group['id'];
						$incomes_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
						if(count($incomes_sub_sub_groups) > 0){
							$table[] = '<tr><td align="left" style="font-weight: bold;font-size: medium;" class="level_2 level_groups">'.$list_sub_sub_group['name'].'</td><td></td></tr>';
							$incomes_sub_sub_groups_total = 0;
							foreach($incomes_sub_sub_groups as $incomes_sub_sub_group){
								$total = $incomes_sub_sub_group['cr_total'] - $incomes_sub_sub_group['dr_total'];
								$incomes_sub_sub_groups_total += $total;
								$ledgercode = $incomes_sub_sub_group['left_code'] . '/' . $incomes_sub_sub_group['right_code'];
								$ledgername = $incomes_sub_sub_group['ledger_name'];
								if($incomes_sub_sub_groups_total < 0) $incomes_sub_sub_groups_total_amount = "( ".number_format(abs($incomes_sub_sub_groups_total),2)." )";
								else $incomes_sub_sub_groups_total_amount = number_format($incomes_sub_sub_groups_total,2);
								$table[] .= '<tr>
												<td align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
								$table[] .= '<td align="right" >'.number_format($incomes_sub_sub_groups_total_amount, "2",".",",").'</td>';
								$table[] .= '</tr>';
							}
							if($incomes_sub_sub_groups_total < 0) $incomes_sub_sub_groups_total_amount = "( ".number_format(abs($incomes_sub_sub_groups_total),2)." )";
							else $incomes_sub_sub_groups_total_amount = number_format($incomes_sub_sub_groups_total,2);
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total '.$list_sub_sub_group['name'].'</td><td>'.$incomes_sub_sub_groups_total_amount.'</td></tr>';
							$list_sub_sub_groups_total += $incomes_sub_sub_groups_total;
						}
					}
				}
				$list_sub_groups_total += $list_sub_sub_groups_total;
			}
			$top_incomes_group_total += $list_sub_groups_total;
		}
		if($total < 0) $top_incomes_group_total_amount = "( ".number_format(abs($top_incomes_group_total),2)." )";
		else $top_incomes_group_total_amount = number_format($top_incomes_group_total,2);
		$table[] .= '<tr>
						<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' .$top_incomes_group['name'].'</td>';
		$table[] .= '<td align="right" >'.$top_incomes_group_total_amount.'</td>';
		$table[] .= '</tr>';
		
		// Expenses
		
		$top_expenes_group = $this->db->table("groups")->where('code', 6000)->get()->getRowArray();
		$expenes_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_expenes_group['id'] ." and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
		$top_expenes_group_total = 0;
		$table[] = '<tr><td align="left" style="font-weight: bold;font-size: medium;" class="level_0 level_groups">'.$top_expenes_group['name'].'</td><td></td></tr>';
		if(count($expenes_groups) > 0){
			foreach($expenes_groups as $expenes_group){
				$group_id = $expenes_group['group_id'];
				$total = $expenes_group['dr_total'] - $expenes_group['cr_total'];
				$top_expenes_group_total += $total;
				$ledgercode = $expenes_group['left_code'] . '/' . $expenes_group['right_code'];
				$ledgername = $expenes_group['ledger_name'];
				if($total < 0) $total_amount = "( ".number_format(abs($total),2)." )";
				else $total_amount = number_format($total,2);
				$table[] .= '<tr>
								<td align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
				$table[] .= '<td align="right" >'.$total_amount.'</td>';
				$table[] .= '</tr>';
			}
		}
		$list_sub_groups =  $this->db->table("groups")->where('parent_id', $top_expenes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
		if(count($list_sub_groups) > 0){
			$list_sub_groups_total = 0;
			foreach($list_sub_groups as $list_sub_group){
				$sub_group_id = $list_sub_group['id'];
				$expenes_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
				if(count($expenes_sub_groups) > 0){
					$table[] = '<tr><td align="left" style="font-weight: bold;font-size: medium;" class="level_1 level_groups">'.$list_sub_group['name'].'</td><td></td></tr>';
					$expenes_sub_groups_total = 0;
					foreach($expenes_sub_groups as $expenes_sub_group){
						$total = $expenes_sub_group['dr_total'] - $expenes_sub_group['cr_total'];
						$expenes_sub_groups_total += $total;
						$ledgercode = $expenes_sub_group['left_code'] . '/' . $expenes_sub_group['right_code'];
						$ledgername = $expenes_sub_group['ledger_name'];
						if($total < 0) $total_amount = "( ".number_format(abs($total),2)." )";
						else $total_amount = number_format($total,2);
						$table[] .= '<tr>
										<td align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
						$table[] .= '<td align="right" >'.$total_amount.'</td>';
						$table[] .= '</tr>';
					}
					if($expenes_sub_groups_total < 0) $expenes_sub_groups_total_amount = "( ".number_format(abs($expenes_sub_groups_total),2)." )";
					else $expenes_sub_groups_total_amount = number_format($expenes_sub_groups_total,2);
					$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total '.$list_sub_group['name'].'</td><td>'.$expenes_sub_groups_total_amount.'</td></tr>';
					$list_sub_groups_total += $expenes_sub_groups_total;
				}
				$list_sub_sub_groups =  $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
				$list_sub_sub_groups_total = 0;
				if(count($list_sub_sub_groups) > 0){
					foreach($list_sub_sub_groups as $list_sub_sub_group){
						$sub_sub_group_id = $list_sub_sub_group['id'];
						$expenes_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
						if(count($expenes_sub_sub_groups) > 0){
							$table[] = '<tr><td align="left" style="font-weight: bold;font-size: medium;" class="level_2 level_groups">'.$list_sub_sub_group['name'].'</td><td></td></tr>';
							$expenes_sub_sub_groups_total = 0;
							foreach($expenes_sub_sub_groups as $expenes_sub_sub_group){
								$total = $expenes_sub_sub_group['dr_total'] - $expenes_sub_sub_group['cr_total'];
								$expenes_sub_sub_groups_total += $total;
								$ledgercode = $expenes_sub_sub_group['left_code'] . '/' . $expenes_sub_sub_group['right_code'];
								$ledgername = $expenes_sub_sub_group['ledger_name'];
								if($expenes_sub_sub_groups_total < 0) $expenes_sub_sub_groups_total_amount = "( ".number_format(abs($expenes_sub_sub_groups_total),2)." )";
								else $expenes_sub_sub_groups_total_amount = number_format($expenes_sub_sub_groups_total,2);
								$table[] .= '<tr>
												<td align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
								$table[] .= '<td align="right" >'.number_format($expenes_sub_sub_groups_total_amount, "2",".",",").'</td>';
								$table[] .= '</tr>';
							}
							if($expenes_sub_sub_groups_total < 0) $expenes_sub_sub_groups_total_amount = "( ".number_format(abs($expenes_sub_sub_groups_total),2)." )";
							else $expenes_sub_sub_groups_total_amount = number_format($expenes_sub_sub_groups_total,2);
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total '.$list_sub_sub_group['name'].'</td><td>'.$expenes_sub_sub_groups_total_amount.'</td></tr>';
							$list_sub_sub_groups_total += $expenes_sub_sub_groups_total;
						}
					}
				}
				$list_sub_groups_total += $list_sub_sub_groups_total;
			}
			$top_expenes_group_total += $list_sub_groups_total;
		}
		if($total < 0) $top_expenes_group_total_amount = "( ".number_format(abs($top_expenes_group_total),2)." )";
		else $top_expenes_group_total_amount = number_format($top_expenes_group_total,2);
		$table[] .= '<tr>
						<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' .$top_expenes_group['name'].'</td>';
		$table[] .= '<td align="right" >'.$top_expenes_group_total_amount.'</td>';
		$table[] .= '</tr>';
		
		// Net Profit
		
		$net_profit = $gross_profit + $top_incomes_group_total - $top_expenes_group_total;
		
		if($net_profit < 0){
			$net_profit_amount = "( ".number_format(abs($net_profit),2)." )";
			$net_profit_txt = "(Deficit) Before Taxation";
		}else{
			$net_profit_amount = number_format($net_profit,2);
			$net_profit_txt = "Surplus Before Taxation";
		}
		
		$table[] .= '<tr>
						<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">' . $net_profit_txt . '</td>';
		$table[] .= '<td align="right" >'.$net_profit_amount.'</td>';
		$table[] .= '</tr>';
		
		// Taxation
		
		$top_taxes_group = $this->db->table("groups")->where('code', 9000)->get()->getRowArray();
		$taxes_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_taxes_group['id'] ." and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
		$top_taxes_group_total = 0;
		$table[] = '<tr><td align="left" style="font-weight: bold;font-size: medium;" class="level_0 level_groups">'.$top_taxes_group['name'].'</td><td></td></tr>';
		if(count($taxes_groups) > 0){
			foreach($taxes_groups as $taxes_group){
				$group_id = $taxes_group['group_id'];
				$total = $taxes_group['dr_total'] - $taxes_group['cr_total'];
				$top_taxes_group_total += $total;
				$ledgercode = $taxes_group['left_code'] . '/' . $taxes_group['right_code'];
				$ledgername = $taxes_group['ledger_name'];
				if($total < 0) $total_amount = "( ".number_format(abs($total),2)." )";
				else $total_amount = number_format($total,2);
				$table[] .= '<tr>
								<td align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
				$table[] .= '<td align="right" >'.$total_amount.'</td>';
				$table[] .= '</tr>';
			}
		}
		$list_sub_groups =  $this->db->table("groups")->where('parent_id', $top_taxes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
		if(count($list_sub_groups) > 0){
			$list_sub_groups_total = 0;
			foreach($list_sub_groups as $list_sub_group){
				$sub_group_id = $list_sub_group['id'];
				$taxes_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
				if(count($taxes_sub_groups) > 0){
					$table[] = '<tr><td align="left" style="font-weight: bold;font-size: medium;" class="level_1 level_groups">'.$list_sub_group['group_name'].'</td><td></td></tr>';
					$taxes_sub_groups_total = 0;
					foreach($taxes_sub_groups as $taxes_sub_group){
						$total = $taxes_sub_group['dr_total'] - $taxes_sub_group['cr_total'];
						$taxes_sub_groups_total += $total;
						$ledgercode = $taxes_sub_group['left_code'] . '/' . $taxes_sub_group['right_code'];
						$ledgername = $taxes_sub_group['ledger_name'];
						if($total < 0) $total_amount = "( ".number_format(abs($total),2)." )";
						else $total_amount = number_format($total,2);
						$table[] .= '<tr>
										<td align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
						$table[] .= '<td align="right" >'.$total_amount.'</td>';
						$table[] .= '</tr>';
					}
					if($taxes_sub_groups_total < 0) $taxes_sub_groups_total_amount = "( ".number_format(abs($taxes_sub_groups_total),2)." )";
					else $taxes_sub_groups_total_amount = number_format($taxes_sub_groups_total,2);
					$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total '.$list_sub_group['group_name'].'</td><td>'.$taxes_sub_groups_total_amount.'</td></tr>';
					$list_sub_groups_total += $taxes_sub_groups_total;
				}
				$list_sub_sub_groups =  $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
				$list_sub_sub_groups_total = 0;
				if(count($list_sub_sub_groups) > 0){
					foreach($list_sub_sub_groups as $list_sub_sub_group){
						$sub_sub_group_id = $list_sub_sub_group['id'];
						$taxes_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
						if(count($taxes_sub_sub_groups) > 0){
							$table[] = '<tr><td align="left" style="font-weight: bold;font-size: medium;" class="level_2 level_groups">'.$list_sub_sub_group['group_name'].'</td><td></td></tr>';
							$taxes_sub_sub_groups_total = 0;
							foreach($taxes_sub_sub_groups as $taxes_sub_sub_group){
								$total = $taxes_sub_sub_group['dr_total'] - $taxes_sub_sub_group['cr_total'];
								$taxes_sub_sub_groups_total += $total;
								$ledgercode = $taxes_sub_sub_group['left_code'] . '/' . $taxes_sub_sub_group['right_code'];
								$ledgername = $taxes_sub_sub_group['ledger_name'];
								if($taxes_sub_sub_groups_total < 0) $taxes_sub_sub_groups_total_amount = "( ".number_format(abs($taxes_sub_sub_groups_total),2)." )";
								else $taxes_sub_sub_groups_total_amount = number_format($taxes_sub_sub_groups_total,2);
								$table[] .= '<tr>
												<td align="left" class="level_ledger">(' . $ledgercode . ')' .$ledgername.'</td>';
								$table[] .= '<td align="right" >'.number_format($taxes_sub_sub_groups_total_amount, "2",".",",").'</td>';
								$table[] .= '</tr>';
							}
							if($taxes_sub_sub_groups_total < 0) $taxes_sub_sub_groups_total_amount = "( ".number_format(abs($taxes_sub_sub_groups_total),2)." )";
							else $taxes_sub_sub_groups_total_amount = number_format($taxes_sub_sub_groups_total,2);
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total '.$list_sub_sub_group['group_name'].'</td><td>'.$taxes_sub_sub_groups_total_amount.'</td></tr>';
							$list_sub_sub_groups_total += $taxes_sub_sub_groups_total;
						}
					}
				}
				$list_sub_groups_total += $list_sub_sub_groups_total;
			}
			$top_taxes_group_total += $list_sub_groups_total;
		}
		if($total < 0) $top_taxes_group_total_amount = "( ".number_format(abs($top_taxes_group_total),2)." )";
		else $top_taxes_group_total_amount = number_format($top_taxes_group_total,2);
		$table[] .= '<tr>
						<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' .$top_taxes_group['name'].'</td>';
		$table[] .= '<td align="right" >'.$top_taxes_group_total_amount.'</td>';
		$table[] .= '</tr>';
		
		// Total profit
		
		$profit = $net_profit - $top_taxes_group_total;
		if($profit < 0){
			$profit_amount = "( ".number_format(abs($profit),2)." )";
			$profit_txt = "(Deficit) After Taxation";
		}else{
			$profit_amount = number_format($profit,2);
			$profit_txt = "Surplus After Taxation";
		}
		
		$table[] .= '<tr>
						<td align="left" style="font-weight: bold;font-size: medium;" class="level_total level_groups">' . $profit_txt . '</td>';
		$table[] .= '<td align="right" >'.$profit_amount.'</td>';
		$table[] .= '</tr>';
		$mobile_number = array();
		if(empty($mobile) && !empty($temp_details['daily_closing_phone'])){
			$daily_closing_phone = json_decode($temp_details['daily_closing_phone'], true);
			if(!empty($daily_closing_phone[0]['phonecode']) && !empty($daily_closing_phone[0]['phoneno'])){
				foreach($daily_closing_phone as $dcp){
					$mobile_number[] = $dcp['phonecode'] . $dcp['phoneno'];
				}
			}
		}else $mobile_number[] = $mobile;
		if(count($mobile_number) > 0){
			$data['bd_colspan'] = $bd_colspan;
			$data['fund_id'] = $fund_id;
			if($profit >= 0) $data['profit'] = 'Total Profit Amount is '.number_format($profit, '2','.',',');
			else{ $neg = $profit * -1; $data['profit'] = 'Total Loss Amount is '.number_format($neg , '2','.',','); }
			$data['table'] = $table;
			$data['funds'] = $this->db->table("funds")->get()->getResultArray();

			$html = view('cron/profitloss', $data);
			$options = new Options();
			$options->set('isHtml5ParserEnabled', true);
			$options->set(array('isRemoteEnabled'=>true));
			$options->set('isPhpEnabled', true);
			$dompdf = new Dompdf($options);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$filePath = FCPATH . 'uploads/documents/daily_closing_pl' . time() . '.pdf';
			file_put_contents($filePath, $dompdf->output());
			$message_params = array();
			$media['url'] = base_url() . '/uploads/documents/daily_closing_pl' . time() . '.pdf';
			$media['filename'] = 'daily_closing_pl.pdf';
			foreach($mobile_number as $mn){
				// echo $html;
				// die;
				// $mobile = '+919092615446';
				// print_r($mobile);
				// print_r($message_params);
				// print_r($media);
				// die; 
				echo $mn;
				$whatsapp_resp = whatsapp_aisensy($mn, $message_params, 'daily_closing_live', $media);
				print_r($whatsapp_resp);
			}
		}
	}
    function hall_booking_remainder($mobile = ''){
		$this->hallmodal = new HallbookingModel();
		$profile_id = 1;
		$query = $this->db->table('admin_profile')->where('id', $profile_id)->get()->getRowArray();
		$days = $query['hall_remind'];
		if($days!=0 || !empty($days)) {
			$hallremind_days = $days;
		}else{
			$hallremind_days = 5;
		}
		$remainder = $this->db->query("SELECT *, abs(datediff(DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d'), NOW())) as interval_date FROM hall_booking WHERE DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d') >= NOW() AND DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')  < NOW() + INTERVAL $hallremind_days DAY and paid_amount < total_amount;")->getResultArray();
		if(count($remainder) > 0){
			foreach($remainder as $rm){
				$this->hallmodal->send_whatsapp_msg($rm['id']);
			}
		}

	}
	function rental_remainder($mobile = ''){
		$str_to_date_convert = date("Y-m");
		$datalist = $this->db->query("SELECT t.phone as phone_no, t.name as tennant_name, properties.id as property_id, properties.name as property_name,properties.rental_value as amount, if(properties.due_date, properties.due_date, 7) as due_date FROM properties JOIN tennant_property tp ON tp.property_id = properties.id left join tennant t on t.id = tp.tennant_id WHERE '$str_to_date_convert' BETWEEN DATE_FORMAT(tp.start_date,'%Y-%m') AND DATE_FORMAT(tp.end_date,'%Y-%m') AND t.status = 1  AND tp.status = 1")->getResultArray();
		$data['pay_details'] = $this->db->table("rental_pay_details")->where("rental_id", $id)->get()->getResultArray();
		$tmpid = 1;
		$data['temp_details'] = $temp_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		if(count($datalist) > 0){
			foreach ($datalist as $roww) {
				/* $paid_rental = $this->db->table("rental")->join('rental_pay_details', 'rental_pay_details.rental_id = rental.id')->select('SUM(rental_pay_details.amount) as paidamt')->where("rental.property_id", $roww['property_id'])->where("rental.month_year", $rental_monthyear)->groupBy('rental_pay_details.rental_id')->get()->getRowArray(); */
				$paid_rental = $this->db->table("rental")->select('SUM(amount) as paidamt')->where("property_id", $roww['property_id'])->where("month_year", $str_to_date_convert)->get()->getRowArray();
				if (floatval($paid_rental['paidamt']) == floatval($roww['amount']) || floatval($paid_rental['paidamt']) > floatval($roww['amount'])) {
					//echo "Full Paid";
				} else {
					//echo "Half Paid";
					if(!empty($temp_details['daily_closing_phone'])){
						$daily_closing_phone = json_decode($temp_details['daily_closing_phone'], true);
						if(!empty($daily_closing_phone[0]['phonecode']) && !empty($daily_closing_phone[0]['phoneno'])){
							foreach($daily_closing_phone as $dcp){
								$mobile_number[] = $dcp['phonecode'] . $dcp['phoneno'];
							}
						}
					}
					if(empty($roww['phonecode'])) $roww['phonecode'] = '+60';
					$mobile_number[] = $roww['phonecode'] . $roww['phone_no'];
					$pending_amt = $roww['amount'] - $paid_rental['paidamt'];
					$due_date = $str_to_date_convert . "-01";
					$converted_month = date("M", strtotime($due_date));
					$retn_array[] = array("phone_no" => $roww['phone_no'], "tennant_name" => $roww['tennant_name'], "property_id" => $roww['property_id'], "property_name" => $roww['property_name'], "amount" => $roww['amount'], "pending_amount" => $pending_amt, "due_month" => $converted_month);
					$due_date = !empty($roww['due_date']) ? str_pad($roww['due_date'], 2, "0", STR_PAD_LEFT) . '/' . date("m/Y") : '';
					if(!empty($due_date)){
						if(date("Y-m") . '-' . str_pad($roww['due_date'], 2, "0", STR_PAD_LEFT) <= date("Y-m-d")){
							$message_params = array();
							$message_params[] = $roww['tennant_name'];
							$message_params[] = date("M, Y");
							$message_params[] = ' ' . $due_date;
							$message_params[] = (string) $pending_amt;
							$mobile_number = $roww['phone_no'];
							//$mobile_number = '+60146488869';
							$mobile_number = '+919092615446';
							//$mobile_number = '+918012288811';
							/* print_r($mobile_number);
							print_r($message_params);
							die;  */
							//$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'rental_live');
							/* print_r($whatsapp_resp);
							die; */
						}
					}else{
						$message_params = array();
						$message_params[] = $roww['tennant_name'];
						$message_params[] = date("M, Y");
						$message_params[] = $due_date;
						$message_params[] = (string) $pending_amt;
						$mobile_number = $roww['phone_no'];
						//$mobile_number = '+60146488869';
						$mobile_number = '+919092615446';
						/* print_r($mobile_number);
						print_r($message_params);
						die;  */
						//$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'rental_live');
						/* print_r($whatsapp_resp);
						die; */
					}
				}
			}
		}
	}
	function rental_first_remainder($mobile = ''){
		if(date("d") == '21' || date("d") == '8'){
			$str_to_date_convert = date("Y-m");
			$datalist = $this->db->query("SELECT t.phone as phone_no, t.name as tennant_name, properties.id as property_id, properties.lot_no, properties.name as property_name,properties.rental_value as amount, if(properties.due_date, properties.due_date, 7) as due_date FROM properties JOIN tennant_property tp ON tp.property_id = properties.id left join tennant t on t.id = tp.tennant_id WHERE '$str_to_date_convert' BETWEEN DATE_FORMAT(tp.start_date,'%Y-%m') AND DATE_FORMAT(tp.end_date,'%Y-%m') AND t.status = 1  AND tp.status = 1")->getResultArray();
			$data['pay_details'] = $this->db->table("rental_pay_details")->where("rental_id", $id)->get()->getResultArray();
			$tmpid = 1;
			$data['temp_details'] = $temp_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
			if(count($datalist) > 0){
				foreach ($datalist as $roww) {
					/* $paid_rental = $this->db->table("rental")->join('rental_pay_details', 'rental_pay_details.rental_id = rental.id')->select('SUM(rental_pay_details.amount) as paidamt')->where("rental.property_id", $roww['property_id'])->where("rental.month_year", $rental_monthyear)->groupBy('rental_pay_details.rental_id')->get()->getRowArray(); */
					$paid_rental = $this->db->table("rental")->select('SUM(amount) as paidamt')->where("property_id", $roww['property_id'])->where("month_year", $str_to_date_convert)->get()->getRowArray();
					//print_r($paid_rental);
					if (floatval($paid_rental['paidamt']) == floatval($roww['amount']) || floatval($paid_rental['paidamt']) > floatval($roww['amount'])) {
						//echo "Full Paid";
					} else {
						//echo "Half Paid";
						$mobile_number = array();
						if(!empty($temp_details['daily_closing_phone'])){
							$daily_closing_phone = json_decode($temp_details['daily_closing_phone'], true);
							if(!empty($daily_closing_phone[0]['phonecode']) && !empty($daily_closing_phone[0]['phoneno'])){
								foreach($daily_closing_phone as $dcp){
									$mobile_number[] = $dcp['phonecode'] . $dcp['phoneno'];
								}
							}
						}
						if(empty($roww['phonecode'])) $roww['phonecode'] = '+60';
						// $mobile_number[] = $roww['phonecode'] . $roww['phone_no'];
						$pending_amt = $roww['amount'] - $paid_rental['paidamt'];
						$due_date = $str_to_date_convert . "-01";
						$converted_month = date("M", strtotime($due_date));
						$retn_array[] = array("phone_no" => $roww['phone_no'], "tennant_name" => $roww['tennant_name'], "property_id" => $roww['property_id'], "property_name" => $roww['property_name'], "amount" => $roww['amount'], "pending_amount" => $pending_amt, "due_month" => $converted_month);
						$due_date = !empty($roww['due_date']) ? str_pad($roww['due_date'], 2, "0", STR_PAD_LEFT) . '/' . date("m/Y") : '';
						if(!empty($due_date)){
							// print_r($roww['property_id']);
							// echo '<br>';
							// print_r($mobile_number);
							// echo '<br>';
							if(date("Y-m") . '-' . str_pad($roww['due_date'], 2, "0", STR_PAD_LEFT) <= date("Y-m-d")){
								$data = array();
								$roww['month_year'] = $str_to_date_convert;
								$data['temp_details'] = $temp_details;
								$data['rental'] = $roww;
								$html = view('rental/notice_print', $data);
								$options = new Options();
								$options->set('isHtml5ParserEnabled', true);
								$options->set(array('isRemoteEnabled'=>true));
								$options->set('isPhpEnabled', true);
								$dompdf = new Dompdf($options);
								$dompdf->loadHtml($html);
								$dompdf->setPaper('A4', 'portrait');
								$dompdf->render();
								$filePath = FCPATH . 'uploads/documents/rental_remainder_' . $roww['property_id'] . '_' . time() . '.pdf';
								file_put_contents($filePath, $dompdf->output());
								$media['url'] = base_url() . '/uploads/documents/rental_remainder_' . $roww['property_id'] . '_' . time() . '.pdf';
								$media['filename'] = 'rental_remainder.pdf';
								$message_params = array();
								if(count($mobile_number) > 0){
									foreach($mobile_number as $mn){
										// $mn = '+919092615446';
										// $mn = '+60123343059';
										// print_r($mobile_number);
										// print_r($message_params);
										// print_r($media);
										// die; 
										$whatsapp_resp = whatsapp_aisensy($mn, $message_params, 'rental_due_remainder2', $media);
										// print_r($whatsapp_resp);
										// die;
									}
								}
							}
						}else{
							if(count($mobile_number) > 0){
								foreach($mobile_number as $mn){
									$media['filename'] = 'rental_invoice.pdf';
									//$mn = '+918012288811';
									// print_r($mobile_number);
									// print_r($message_params);
									// print_r($media);
									// die; 
									$whatsapp_resp = whatsapp_aisensy($mn, $message_params, 'rental_receipt_live', $media);
									//print_r($whatsapp_resp);
								}
							}
						}
					}
				}
			}
		}
	}
	function birthday_wishes($mobile = ''){
		// print_r($mobile);
		// print_r($message_params);
		// print_r($media);
		// die; 
		//echo $mn;
		//$whatsapp_resp = whatsapp_aisensy($mn, $message_params, 'birthday_wishes_image_live', $media);
		//print_r($whatsapp_resp);
		// $html = view('cron/birthday_wishes');
		// echo $html;
		$current_date = date('m-d', strtotime(date('Y-m-d')));
		$num_rows = $this->db->table("member")->where('DATE_FORMAT(dob, "%m-%d")', $current_date)->get()->getNumRows();
		if($num_rows > 0){
			$member_list = $this->db->table("member")->where('DATE_FORMAT(dob, "%m-%d")', $current_date)->get()->getResultArray();
			$tmpid = 1;
			$temp_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
			foreach($member_list as $ml){
				$mobile_number = array();
				if(!empty($ml['mobile'])){
					$mobile_number[] = $ml['mobile'];
					if(!empty($temp_details['daily_closing_phone'])){
						$daily_closing_phone = json_decode($temp_details['daily_closing_phone'], true);
						if(!empty($daily_closing_phone[0]['phonecode']) && !empty($daily_closing_phone[0]['phoneno'])){
							foreach($daily_closing_phone as $dcp){
								$mobile_number[] = $dcp['phonecode'] . $dcp['phoneno'];
							}
						}
					}
					foreach($mobile_number as $mn){
						$message_params = array();
						$image_name = !empty($ml['image']) ? $ml['image'] : 'strandard_birthday_wish.jpeg';
						$media['url'] = base_url() . '/uploads/birthday/' . $image_name;
						$media['filename'] = 'birthday_wishes.jpg';
						// $mn = $ml['mobile'];
						// $mn = '+919092615446';
						echo $mn;
						echo '<br>';
						$whatsapp_resp = whatsapp_aisensy($mn, $message_params, 'birthday_wishes_image_live', $media);
					}
					/* $mn = '+60146488869';
					$whatsapp_resp = whatsapp_aisensy($mn, $message_params, 'birthday_wishes_image_live', $media); */
				}
			}
		}
		/* echo $current_date;
		echo '<br>';
		echo $num_rows; */
		
	}
	function ubayam_oneday_before_remainder(){
		$datalist = $this->db->query("SELECT * FROM ubayam WHERE ubayam_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY)")->getResultArray();
		echo '<pre>';
		print_r($datalist);
		exit;
	}
}
