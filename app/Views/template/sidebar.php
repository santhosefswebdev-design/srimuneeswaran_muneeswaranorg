<?php
global $lang;
function permission_validate($name, $access)
{
  $permission = $_SESSION['permission'];
  $dkey = array_search($name, array_column($permission, 'name'));
  if ($permission[$dkey]['name'] == $name) {
    $val = $permission[$dkey][$access];
    if ($val == 1)
      $res = true;
    else
      $res = false;
  } else {
    $res = false;
  }
  return $res;
}
function list_validate($name)
{
  $permission = $_SESSION['permission'];
  $dkey = array_search($name, array_column($permission, 'name'));
  if ($permission[$dkey]['name'] == $name) {
    //echo $name;
    $view = $permission[$dkey]['view'];
    $create = $permission[$dkey]['create_p'];
    $edit = $permission[$dkey]['edit'];
    $delete = $permission[$dkey]['delete_p'];
    $print = $permission[$dkey]['print'];

    if ($view == 1 || $create == 1 || $edit == 1 || $delete == 1 || $print == 1)
      $res = true;
    else
      $res = false;
  } else {
    $res = false;
  }
  return $res;
}

$dashboard = list_validate('dashboard');

//Profile
$temple_setting = list_validate('temple_setting');
$view_per = permission_validate('temple_setting', 'view');
$edit_per = permission_validate('temple_setting', 'edit');
$member = list_validate('member');
$terms_setting = list_validate('terms_setting');
$message_setting = list_validate('message_setting');
$whatsappmessage_setting = list_validate('whatsappmessage_setting');
$paymentmodesetting = list_validate('paymentmodesetting');
$document = list_validate('document');
$youtube = list_validate('youtube');
$booking_notification = list_validate('booking_notification');

//Master
$user_setting = list_validate('user_setting');
$member_setting = list_validate('member');
$staff_setting = list_validate('staff_setting');
$archanai_setting = list_validate('archanai_setting');
$hall_setting = list_validate('hall_setting');
$service_setting = list_validate('service_setting');
$checklist_setting = list_validate('checklist_setting');
$donation_setting = list_validate('donation_setting');
$ubayam_setting = list_validate('ubayam_setting');
$prasadam_setting = list_validate('prasadam_setting');
$uom = list_validate('uom');
$timing = list_validate('timing');
$stock_group = list_validate('stock_group');
$product = list_validate('product');
$cemetery_setting = list_validate('cemetery_setting'); //cemetry
$prasadam_master = list_validate('prasadam_master');

// Transaction
$archanai_ticket = list_validate('archanai_ticket');
$hall_booking = list_validate('hall_booking');
$cash_donation = list_validate('cash_donation');
$ubayam = list_validate('ubayam');
$prasadam = list_validate('prasadam');
$product_donation = list_validate('product_donation');
$kumbamdonation = ('kumbamdonation');
$donation_category = ('donation_category');
$funds = ('funds');
$stock_in = list_validate('stock_in');
$stock_out = list_validate('stock_out');
$pay_slip = list_validate('pay_slip');
$cemetery_reg = list_validate('cemetery_reg'); //cemetry
$member_reg = list_validate('member_reg');

//Report
$archanai_report = list_validate('archanai_report');
$hall_report = list_validate('hall_report');
$cash_report = list_validate('cash_report');
$ubayam_report = list_validate('ubayam_report');
$prasadam_report = list_validate('prasadam_report');
$prasadam_collection_report = list_validate('prasadam_collection_report');
$product_donation_report = list_validate('product_donation_report');
$stock_report = list_validate('stock_report');
$bom_report = list_validate('bom_report');
$commission_report = list_validate('commission_report');
$payslip_report = list_validate('payslip_report');
$cemetery_report = list_validate('cemetery_report'); // cemetry
$member_report = list_validate('member_report');
$agent_registration = list_validate('agent_registration'); // cemetry 
$agent_specialtime_registration = list_validate('cemetery_specialtime_register_pending');
$cemetery_specialtime_approved = list_validate('cemetery_specialtime_register_approved');

//Accounts
$ac_creation_accounts = list_validate('ac_creation_accounts');
$entries_accounts = list_validate('entries_accounts');

$ledger_report_accounts = list_validate('ledger_report_accounts');
$trial_balance_accounts = list_validate('trial_balance_accounts');
$balance_sheet_accounts = list_validate('balance_sheet_accounts');
$profit_and_loss_accounts = list_validate('profit_and_loss_accounts');
$ledgers_name_list_accounts = list_validate('ledgers_name_list_accounts');
$account_group_list_accounts = list_validate('account_group_list_accounts');
$account_setting = list_validate('account_setting');

// INVENTORY
$inventory_rawmaterial = list_validate('inventory_rawmaterial');
$inventory_supplier = list_validate('inventory_supplier');
//BOM
$bom_archanai = list_validate('bom_archanai');
$bom_prasadam = list_validate('bom_prasadam');
$bom_archanai_report = list_validate('bom_archanai_report');
$bom_prasadam_report = list_validate('bom_prasadam_report');
// PROPERTY MANAGEMENT
$properties = list_validate('properties');
$rental = list_validate('rental');
$tennant = list_validate('tennant');
// DAILY CLOSING
$daily_closing = list_validate('daily_closing');
$sales_report = list_validate('sales_report');
// ANNATHNAM
$annathanam = list_validate('annathanam');
$commission = list_validate('commission');
?>
<link href="<?php echo base_url(); ?>/assets/css/menustyle.css" rel="stylesheet">


<section class="top_content hidden-xs  hidden-sm">

  <div class="navbar1">
    <div class="nav-links">

      <ul class="links">
        <li><a href="<?php echo base_url(); ?>/dashboard"><img src="<?php echo base_url(); ?>/assets/images/dash.png"
              style="width:50px; display:block;"><span>
              <?php echo $lang->dashboard; ?>
            </span></a></li>

        <?php if ($archanai_setting || $archanai_ticket || $archanai_report) { ?>
          <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/archanai.png"
                style="width:50px; display:block;"><span>
                <?php echo $lang->archanai; ?>
                <?php echo $lang->sales; ?><i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
              </span></a>
            <ul class="js-sub-menu sub-menu">
              <li><a href="<?php echo base_url(); ?>/archanai/group_list">
                  <?php echo $lang->group; ?>
                </a></li>
              <li><a href="<?php echo base_url(); ?>/archanai/diety_list">Deity</a></li>
              <?php if ($archanai_setting) { ?>
                <li><a href="<?php echo base_url(); ?>/archanai">
                    <?php echo $lang->setting; ?>
                  </a></li>
                <?php /*  <li><a href="<?php echo base_url(); ?>/archanai/rasi">Rasi</a></li>
<li><a href="<?php echo base_url(); ?>/archanai/natchathiram">Natchathiram</a></li> */ ?>
              <?php }
              if ($archanai_ticket) { ?>
                <!--li><a href="<?php echo base_url(); ?>/archanaibooking"><?php echo $lang->entry; ?></a></li-->
              <?php }
              if ($archanai_report) { ?>
                <li><a href="<?php echo base_url(); ?>/archanaibooking/ticket_print">
                    <?php echo $lang->ticket; ?>
                    <?php echo $lang->report; ?>
                  </a></li>
                <li><a href="<?php echo base_url(); ?>/report/arch_book_rep_view">
                    <?php echo $lang->report; ?>
                  </a></li>
				  <li><a href="<?php echo base_url(); ?>/report/denomination_rep_view">
                    <?php echo $lang->denomination_report; ?>
                  </a></li>
                <li><a href="<?php echo base_url(); ?>/report/arc_counter">Counter Report</a></li>
                <li><a href="<?php echo base_url(); ?>/report/deity_rep_view">
                    Deity Report
                  </a></li>
              <?php } ?>
            </ul>
          </li>
        <?php } ?>

        <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/archanai.png" style="width:50px; display:block;">
                <span> Kattalai <?php echo $lang->archanai; ?><i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
            </span></a>
            <ul class="js-sub-menu sub-menu">
              <li><a href="<?php echo base_url(); ?>/kattalai_archanai/setting">
                  <?php echo $lang->archanai; ?> <?php echo $lang->setting; ?>
                </a></li>
                <!-- <li><a href="<?php echo base_url(); ?>/kattalai_archanai/booking">
                  <?php echo $lang->archanai; ?> <?php echo $lang->entry; ?>
                </a></li> -->
                <li><a href="<?php echo base_url(); ?>/kattalai_archanai/kattalai_archanai_report">
                  <?php echo $lang->report; ?>
                </a></li>
            </ul>
          </li>

          <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/product_offering.png" style="width:50px; height:50px; display:block;">
                <span> Offering<i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
            </span></a>
            <ul class="js-sub-menu sub-menu">
              <li><a href="<?php echo base_url(); ?>/offering/offering_category">
                  Offering Category
                </a></li>
                <li><a href="<?php echo base_url(); ?>/offering/product_category">
                  Product Category
                </a></li>
                <li><a href="<?php echo base_url(); ?>/offering/product_offering">
                  Product Offering
                </a></li>
                <li><a href="<?php echo base_url(); ?>/offering/report">
                  Report
                </a></li>
            </ul>
          </li>

        <?php /*if ($hall_setting || $service_setting || $checklist_setting || $hall_booking || $hall_report) { ?>
          <li>
            <a href="#"><img src="<?php echo base_url(); ?>/assets/images/booking.png"
                style="width:50px; display:block;"><span>
                <?php echo $lang->temple; ?>
                <?php echo $lang->booking; ?> <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
              </span></a>
            <ul class="htmlCss-sub-menu sub-menu">
              <?php if ($service_setting) { ?>
                <li><a href="<?php echo base_url(); ?>/master/service">
                    <?php echo $lang->service; ?>
                    <?php echo $lang->setting; ?>
                  </a></li>
              <?php }
              if ($checklist_setting) { ?>
                <li><a href="<?php echo base_url(); ?>/master/checklist">
                    <?php echo $lang->vendor; ?>
                    <?php echo $lang->checklist; ?>
                  </a></li>
              <?php }
              if ($hall_setting) { ?>
                <li><a href="<?php echo base_url(); ?>/master/hall">
                    <?php echo $lang->temple; ?>
                    <?php echo $lang->package; ?>
                    <?php echo $lang->setting; ?>
                  </a></li>
                <li><a href="<?php echo base_url(); ?>/master/hall_block">
                    <?php echo $lang->temple; ?>
                    <?php echo $lang->block; ?>
                    <?php echo $lang->setting; ?>
                  </a></li>
              <?php }
              if ($hall_booking) { ?>
                <li><a href="<?php echo base_url(); ?>/hallbooking">
                    <?php echo $lang->temple; ?>
                    <?php echo $lang->booking; ?>
                  </a></li>
              <?php } ?>
              <li><a href="<?php echo base_url(); ?>/hallbooking/hallbook_remainder_list">
                  <?php echo $lang->reminder; ?>
                  <?php echo $lang->temple; ?>
                  <?php echo $lang->booking; ?>
                </a></li>
              <?php if ($hall_report) { ?>
                <li><a href="<?php echo base_url(); ?>/report/hall_booking_rep_view">
                    <?php echo $lang->report; ?>
                  </a></li>
              <?php } ?>
            </ul>
          </li>
        <?php } */ ?>

        <?php if ($donation_setting || $uom || $product || $cash_donation || $product_donation || $cash_report || $product_donation_report) { ?>
          <li>
            <a href="#"><img src="<?php echo base_url(); ?>/assets/images/donation.png"
                style="width:50px; display:block;"><span>
                <?php echo $lang->donation; ?> <i class='bx bxs-chevron-down js-arrow arrow '></i>
              </span></a>
            <ul class="js-sub-menu sub-menu">
              <?php if ($donation_setting) { ?>
                <li><a href="<?php echo base_url(); ?>/master/donation_setting">
                    <?php echo $lang->donation; ?>
                    <?php echo $lang->setting; ?>
                  </a></li>
              <?php }
              if ($donation_category) { ?>
                <li><a href="<?php echo base_url(); ?>/master/donation_category">
                    <p>Donation Category</p>
                  </a></li>
              <?php }
              //if ($uom) { ?>
                <!-- <li><a href="<?php echo base_url(); ?>/master/uom">
                    <?php //echo $lang->uom; ?>
                    <?php //echo $lang->setting; ?>
                  </a></li> -->
              <?php //}
              if ($product) { ?>
                <!--li><a href="<?php echo base_url(); ?>/master/product">Product Setting</a></li-->
              <?php }
              if ($cash_donation) { ?>
                <li><a href="<?php echo base_url(); ?>/donation">
                    <?php echo $lang->cash; ?>
                    <?php echo $lang->donation; ?>
                  </a></li>
              <?php }
              //if ($product_donation) { ?>
                <!-- <li><a href="<?php echo base_url(); ?>/productdonation">
                    <?php //echo $lang->product; ?>
                    <?php //echo $lang->donation; ?>
                  </a></li> -->
                <!-- <?php //}
              if ($kumbamdonation) { ?>
                <li><a href="<?php echo base_url(); ?>/kumbamdonation">
                   <p>Kumbabishegam Donation</p>
                  </a></li> -->
              <?php }
              if ($cash_report) { ?>
                <li><a href="<?php echo base_url(); ?>/report/cash_don_rep_view">
                    <?php echo $lang->cash; ?>
                    <?php echo $lang->donation; ?>
                    <?php echo $lang->report; ?>
                  </a></li>
              <?php }
              //if ($product_donation_report) { ?>
                <!-- <li><a href="<?php //echo base_url(); ?>/report/prod_don_rep_view">
                    <?php //echo $lang->product; ?>
                    <?php //echo $lang->donation; ?>
                    <?php //echo $lang->report; ?>
                  </a></li> -->
              <?php //} ?>
            </ul>
          </li>
        <?php } ?>

        <!-- <?php if ($ubayam_setting || $ubayam || $ubayam_report || $prasadam || $prasadam_setting || $prasadam_report || $annathanam) { ?>
          <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/ubayam.png"
                style="width:50px; display:block;"><span>
                <?php echo $lang->ubayam; ?> <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
              </span></a>
            <ul class="js-sub-menu sub-menu">
              <?php if ($ubayam_setting) { ?>
                <li><a href="<?php echo base_url(); ?>/master/ubayam_setting">
                    <?php echo $lang->ubayam; ?>
                    <?php echo $lang->setting; ?>
                  </a></li>
              <?php }
              if ($ubayam) { ?>
                <li><a href="<?php echo base_url(); ?>/ubayam">
                    <?php echo $lang->entry; ?>
                  </a></li>
                <li><a href="<?php echo base_url(); ?>/ubayam/ubayam_calendar">
                    <?php echo $lang->ubayam; ?>
                    <?php echo $lang->calendar; ?>
                  </a></li>
              <?php }
              if ($ubayam_report) { ?>
                <li><a href="<?php echo base_url(); ?>/report/ubayam_rep_view">
                    <?php echo $lang->ubayam; ?>
                    <?php echo $lang->report; ?>
                  </a></li>
              <?php }
              if ($prasadam_setting) { ?>
                <li><a href="<?php echo base_url(); ?>/prasadamsetting">
                    <?php echo $lang->prasadam; ?>
                    <?php echo $lang->setting; ?>
                  </a></li>
              <?php }
              if ($prasadam) { ?>
                <li><a href="<?php echo base_url(); ?>/prasadam">
                    <?php echo $lang->prasadam; ?>
                  </a></li>
              <?php }
              if ($prasadam_report) { ?>
                <li><a href="<?php echo base_url(); ?>/report/prasadam_rep_view">
                    <?php echo $lang->prasadam; ?>
                    <?php echo $lang->report; ?>
                  </a></li>
              <?php } ?>
            </ul>
          </li>
        <?php } ?> -->

        <?php if ($prasadam || $prasadam_setting || $prasadam_report || $annathanam) { ?>
          <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/ubayam.png"
                style="width:50px; display:block;"><span>
                <?php echo $lang->prasadam; ?> <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
              </span></a>
            <ul class="js-sub-menu sub-menu">
              <?php if ($prasadam_setting) { ?>
                <li><a href="<?php echo base_url(); ?>/prasadamsetting">
                    <?php echo $lang->prasadam; ?>
                    <?php echo $lang->setting; ?>
                  </a></li>
              <?php }
              if ($prasadam) { ?>
                <li><a href="<?php echo base_url(); ?>/prasadam">
                    <?php echo $lang->prasadam; ?>
                  </a></li>
              <?php }
              if ($prasadam_report) { ?>
                <li><a href="<?php echo base_url(); ?>/report/prasadam_rep_view">
                    <?php echo $lang->prasadam; ?>
                    <?php echo $lang->report; ?>
                  </a></li>
              <?php } 
              if ($prasadam_report) { ?>
                <li><a href="<?php echo base_url(); ?>/report/prasadam_group">
                    <?php echo $lang->prasadam; ?>
                    <?php echo $lang->group; ?>
                  </a></li>
              <?php } ?>
            </ul>
          </li>
        <?php } ?>

        <?php if ($annathanam) { ?>
          <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/annathanam.png"
                style="width:50px; display:block;"><span>
                <?php echo $lang->annathanam; ?> <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
              </span></a>
            <ul class="js-sub-menu sub-menu">
          
              <li><a href="<?php echo base_url(); ?>/annathanam_new/pack_items">
                Items
                </a></li>
                <li><a href="<?php echo base_url(); ?>/annathanam_new/special_types_list">
                Special Types
                </a></li>
                <li><a href="<?php echo base_url(); ?>/annathanam_new/special_items">
                Special Items
                </a></li>
              <li><a href="<?php echo base_url(); ?>/annathanam_new/package">
                Packages
                </a></li>
              <li><a href="<?php echo base_url(); ?>/annathanam_new/index">
                Annathanam
              </a></li>
              <li><a href="<?php echo base_url(); ?>/report/annathanam_rep_view">
                Annathanam Report
              </a></li>
              <li><a href="<?php echo base_url(); ?>/catering">
                Catering
              </a></li>
              <li><a href="<?php echo base_url(); ?>/report/catering_rep_view">
                Catering Report
              </a></li>
            </ul>
          </li>

        <?php }
        if ($bom_archanai || $bom_prasadam || $bom_archanai_report || $bom_prasadam_report) {
         /* ?>
          <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/bom.png"
                style="width:50px; display:block;"><span>
                <?php echo $lang->bom; ?> <i class='bx bxs-chevron-down js-arrow arrow '></i>
              </span></a>
            <ul class="js-sub-menu sub-menu">
              <?php if ($bom_archanai) { ?>
                <li><a href="<?php echo base_url(); ?>/bom/archanai">
                    <?php echo $lang->archanai; ?>
                  </a></li>
              <?php }
              if ($bom_prasadam) { ?>
                <li><a href="<?php echo base_url(); ?>/bom/prasadam">
                    <?php echo $lang->prasadam; ?>
                  </a></li>
              <?php }
              if ($bom_archanai_report) { ?>
                <li><a href="<?php echo base_url(); ?>/bom/archanai_report">
                    <?php echo $lang->archanai; ?>
                    <?php echo $lang->report; ?>
                  </a></li>
              <?php }
              if ($bom_prasadam_report) { ?>
                <li><a href="<?php echo base_url(); ?>/bom/prasadam_report">
                    <?php echo $lang->prasadam; ?>
                    <?php echo $lang->report; ?>
                  </a></li>
              <?php } ?>
            </ul>
          </li>
          <?php
       */ }
        if ($stock_group || $stock_in || $stock_out || $stock_report || $inventory_rawmaterial || $inventory_supplier || $bom_report) { ?>
          <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/inventory.png"
                style="width:50px; display:block;"><span>
                <?php echo $lang->inventory; ?> <i class='bx bxs-chevron-down js-arrow arrow '></i>
              </span></a>
            <ul class="js-sub-menu sub-menu">
              <?php if ($inventory_supplier) { ?>
                <li><a href="<?php echo base_url(); ?>/supplier">
                    <?php echo $lang->supplier; ?>
                  </a></li>
              <?php }
              if ($inventory_rawmaterial) { ?>
                <li><a href="<?php echo base_url(); ?>/rawmaterial">
                    <?php echo $lang->raw; ?>
                  </a></li>
                <li><a href="<?php echo base_url(); ?>/product">
                    <?php echo $lang->product; ?>
                    <?php echo $lang->setting; ?>
                  </a></li>
              <?php }
              if ($stock_group) { ?>
                <li><a href="<?php echo base_url(); ?>/master/stock_group">
                    <?php echo $lang->stock; ?> Group
                    <?php echo $lang->setting; ?>
                  </a></li>
              <?php }
              if ($stock_in) { ?>
                <li><a href="<?php echo base_url(); ?>/stock/stock_in">
                    <?php echo $lang->stock; ?>
                    <?php echo $lang->in; ?>
                    <?php echo $lang->entry; ?>
                  </a></li>
              <?php }
              if ($stock_out) { ?>
                <li><a href="<?php echo base_url(); ?>/stock/stock_out">
                    <?php echo $lang->stock; ?>
                    <?php echo $lang->out; ?>
                    <?php echo $lang->entry; ?>
                  </a></li>
              <?php }
              if ($stock_report) { ?>
                <li><a href="<?php echo base_url(); ?>/report/stock_rep_view">
                    <?php echo $lang->stock; ?>
                    <?php echo $lang->report; ?>
                  </a></li>
              <?php } ?>
            </ul>
          </li>
        <?php }

        if ($ac_creation_accounts || $entries_accounts || $ledger_report_accounts || $trial_balance_accounts || $balance_sheet_accounts || $profit_and_loss_accounts || $ledgers_name_list_accounts || $account_group_list_accounts || $account_setting) { ?>
          <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/account.png"
                style="width:50px; display:block;"><span>
                <?php echo $lang->account; ?> <i class='bx bxs-chevron-down js-arrow arrow '></i>
              </span></a>
            <ul class="js-sub-menu sub-menu">
              <?php if ($ac_creation_accounts) { ?>
                <li><a href="<?php echo base_url(); ?>/account">A/C
                    <?php echo $lang->creation; ?>
                  </a></li>


                <li><a href="<?php echo base_url(); ?>/account/funds">
                    Funds
                  </a></li>
              <?php }
              if ($entries_accounts) { ?>
                <li><a href="<?php echo base_url(); ?>/entries/list">
                    <?php echo $lang->entries; ?>
                  </a></li>
              <?php }
              if ($ledger_report_accounts) { ?>
                <li><a href="<?php echo base_url(); ?>/accountreport/new_ledger_report">
                    <?php echo $lang->general; ?>
                    <?php echo $lang->ledger; ?>
                  </a></li>
              <?php }
              if ($trial_balance_accounts) { ?>
                <li><a href="<?php echo base_url(); ?>/accountreport/trail_balance_new">
                    <?php echo $lang->trial_balance; ?>
                  </a></li>
              <?php }
              if ($balance_sheet_accounts) { ?>
                <li><a href="<?php echo base_url(); ?>/balance_sheet/balancesheet_full">
                    <?php echo $lang->balance_sheet; ?>
                  </a></li>
              <?php }
              if ($profit_and_loss_accounts) { ?>
                <li><a href="<?php echo base_url(); ?>/accountreport/profile_loss">
                    <?php echo $lang->profit_loss; ?>
                    <?php echo $lang->report; ?>
                  </a></li>
              <?php } ?>
              <li><a href="<?php echo base_url(); ?>/reconciliation">
                  <?php echo $lang->reconciliation; ?>
                </a></li>
              <li><a href="<?php echo base_url(); ?>/reportaccount/cash_expense">Cash Expense</a></li>
              <li><a href="<?php echo base_url(); ?>/revenuecapture">Cash Income</a></li>
              <li><a href="<?php echo base_url(); ?>/aging">Aging</a></li>
              <li><a href="<?php echo base_url(); ?>/accountreport/receipt_payment">
                  Receipt & Payment
                </a></li>
              <?php /* <li><a href="<?php echo base_url(); ?>/report/ledger_rep_view">
               <?php echo $lang->ledger; ?>
               <?php echo $lang->report; ?>
             </a></li>
           <li><a href="<?php echo base_url(); ?>/report/groups_rep_view">
               <?php echo $lang->account; ?>
               <?php echo $lang->group; ?>
               <?php echo $lang->report; ?>
             </a></li> */ ?>

              <?php /* if ($account_setting) { ?>
             <li><a href="<?php echo base_url(); ?>/accountsetting">
                 <?php echo $lang->account; ?>
                 <?php echo $lang->setting; ?>
               </a></li>
           <?php } */ ?>
            </ul>
          </li>
        <?php }
        if ($user_setting || $staff_setting || $pay_slip || $commission || $commission_report || $payslip_report) { ?>
          <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/finance.png"
                style="width:50px; display:block;"><span>
                <?php echo $lang->finance; ?> <i class='bx bxs-chevron-down js-arrow arrow '></i>
              </span></a>
            <ul class="js-sub-menu sub-menu">
              <?php if ($user_setting) { ?>
                <li><a href="<?php echo base_url(); ?>/user">
                    <?php echo $lang->user; ?>
                    <?php echo $lang->setting; ?>
                  </a></li>
              <?php }
              if ($staff_setting) { ?>
                <li><a href="<?php echo base_url(); ?>/master/staff">
                    <?php echo $lang->staff; ?>
                    <?php echo $lang->setting; ?>
                  </a></li>
              <?php }
              if ($pay_slip) { ?>

                <li><a href="<?php echo base_url(); ?>/payslip/advance_salary">
                    <?php echo $lang->sallary; ?>
                  </a></li>
                <li><a href="<?php echo base_url(); ?>/payslip">
                    <?php echo $lang->payslip; ?>
                  </a></li>
              <?php }
              if ($commission) { ?>
                <li><a href="<?php echo base_url(); ?>/commission">
                    <?php echo $lang->commision; ?>
                  </a></li>
              <?php }
              if ($commission_report) { ?>
                <li><a href="<?php echo base_url(); ?>/report/commission_rep_view">
                    <?php echo $lang->commision; ?>
                    <?php echo $lang->report; ?>
                  </a></li>
              <?php }
              if ($payslip_report) { ?>
                <li><a href="<?php echo base_url(); ?>/report/">
                    <?php echo $lang->payslip; ?>
                    <?php echo $lang->report; ?>
                  </a></li>
              <?php } ?>
            </ul>
          </li>
        <?php }
        if ($member_setting) { ?>
          <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/profile.png"
                style="width:50px; display:block;"><span>
                <?php echo $lang->member; ?> <i class='bx bxs-chevron-down js-arrow arrow '></i>
              </span></a>
            <ul class="js-sub-menu sub-menu">
              <li><a href="<?php echo base_url(); ?>/member">
                  <?php echo $lang->member; ?>
                  <?php echo $lang->reg; ?>
                </a></li>
              <li><a href="<?php echo base_url(); ?>/member_type">
                  <?php echo $lang->member; ?>
                  <?php echo $lang->type; ?>
                </a></li>
              <li><a href="<?php echo base_url(); ?>/notification">
                  <?php echo $lang->notification; ?>
                </a></li>
              <li><a href="<?php echo base_url(); ?>/report/member_report">
                  <?php echo $lang->report; ?>
                </a></li>
              <li><a href="<?php echo base_url(); ?>/marriage">
                  <?php echo $lang->rof; ?>
                </a></li>
              <li><a href="<?php echo base_url(); ?>/report/courtesy_report">Courtesy
                  <?php echo $lang->report; ?>
                </a></li>
              <li><a href="<?php echo base_url(); ?>/report/visitors_reg_report">Visitor's Registration
                  <?php echo $lang->report; ?>
                </a></li>
              <li><a href="<?php echo base_url(); ?>/member/renewal">Member Renewal</a></li>
              <li><a href="<?php echo base_url(); ?>/member/renewal_report">Renewal Report</a></li>
            </ul>
          </li>
        <?php }
        if ($cemetery_setting || $cemetery_reg || $cemetery_report || $agent_registration || $agent_specialtime_registration || $cemetery_specialtime_approved) { /*?>
          <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/rip11.png"
                style="width:50px; display:block;"><span>
                <?php echo $lang->cemetery; ?> <i class='bx bxs-chevron-down js-arrow arrow '></i>
              </span></a>
            <ul class="js-sub-menu sub-menu">
              <?php if ($cemetery_setting) { ?>
                <li><a href="<?php echo base_url(); ?>/cemetery">
                    <?php echo $lang->setting; ?>
                  </a></li>
                <li><a href="<?php echo base_url(); ?>/cemetery/booking_slot">
                    <?php echo $lang->booking; ?>
                    <?php echo $lang->time; ?>
                  </a></li>
              <?php }
              if ($cemetery_reg) { ?>
                <li><a href="<?php echo base_url(); ?>/cemetery/cemetery_register">
                    <?php echo $lang->reg; ?>
                  </a></li>
              <?php }
              if ($cemetery_report) { ?>
                <?php  <li><a href="<?php echo base_url(); ?>/cemetery/spl_time_approval">Special Time Approval</a></li> ?>
                <li><a href="<?php echo base_url(); ?>/cemetery/report">
                    <?php echo $lang->approved; ?>
                    <?php echo $lang->report; ?>
                  </a></li>
              <?php }
              if ($agent_registration) { ?>
                <li><a href="<?php echo base_url(); ?>/agent_reg">
                    <?php echo $lang->agent; ?>
                    <?php echo $lang->reg; ?>
                  </a></li>
              <?php }
              if ($agent_specialtime_registration) { ?>
                <li><a href="<?php echo base_url(); ?>/cemetery/cemetery_specialtime_register_pending">
                    <?php echo $lang->spl; ?>
                    <?php echo $lang->reg; ?>
                  </a></li>
              <?php }
              if ($cemetery_specialtime_approved) { ?>
                <li><a href="<?php echo base_url(); ?>/cemetery/cemetery_specialtime_register_approved">
                    <?php echo $lang->spl; ?>
                    <?php echo $lang->approved; ?>
                  </a></li>
              <?php } ?>
            </ul>
          </li>
        <?php*/ }
        if ($properties || $rental || $tennant) {/* ?>
          <li><a href="<?php echo base_url(); ?>/properties"><img
                src="<?php echo base_url(); ?>/assets/images/donation.png" style="width:50px; display:block;"><span>
                <?php echo $lang->properties; ?>
              </span></a></li>

        <?php */ } ?>

<li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/temple.png" style="width:50px; display:block;"><span>
                Temple Event<i class='bx bxs-chevron-down js-arrow arrow '></i>
              </span></a>
            <ul class="js-sub-menu sub-menu">
          
              <li><a href="<?php echo base_url(); ?>/master/booking_slot">
                  Booking Slot
                </a></li>
              <li><a href="<?php echo base_url(); ?>/master/venue">
                  Venue
                </a></li>
              <li><a href="<?php echo base_url(); ?>/master/pack_service">
                  Services
                </a></li>
              <li><a href="<?php echo base_url(); ?>/deity">
                  Deity Settings
                </a></li>
              <li><a href="<?php echo base_url(); ?>/master/package">
                  Packages
                </a></li>
              <li><a href="<?php echo base_url(); ?>/templeubayam">
                  Ubayam
                </a></li>
              <li><a href="<?php echo base_url(); ?>/templehallbooking">
                  Hall Booking
                </a></li>
              <li><a href="<?php echo base_url(); ?>/report/temple_rep_view">
                  Report
                </a></li>
            </ul>
          </li>


        <li><a href="#"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>"
              style="height: 50px; display:block;"><span>
              <?php echo $lang->profile; ?> <i class='bx bxs-chevron-down js-arrow arrow '></i>
            </span></a>
          <ul class="js-sub-menu sub-menu" style="right:5px !important; left:auto;">
            <?php if ($temple_setting) { ?>
              <li><a href="<?php echo base_url(); ?>/profile/profile_edit">
                  <?php echo $lang->temple; ?>
                  <?php echo $lang->setting; ?>
                </a></li>
            <?php }
            if ($terms_setting) { ?>
              <li><a href="<?php echo base_url(); ?>/terms/edit">
                  <?php echo $lang->terms; ?>
                  <?php echo $lang->setting; ?>
                </a></li>
            <?php } ?>
            <li><a href="<?php echo base_url(); ?>/settings">Setting</a></li>
            <?php if ($message_setting) { ?>
              <li><a href="<?php echo base_url(); ?>/message/edit">Message
                  <?php echo $lang->setting; ?>
                </a></li>
            <?php } /* if($whatsappmessage_setting) {?>
<li><a href="<?php echo base_url(); ?>/whatsappmessage/edit">Whatsapp Message Setting</a></li>
<?php } */ ?>
            <?php if ($paymentmodesetting) { ?>
              <li><a href="<?php echo base_url(); ?>/paymentmodesetting">
                  <?php echo $lang->pay_mode; ?>
                  <?php echo $lang->setting; ?>
                </a></li>
            <?php }
            if ($document) { ?>
              <li><a href="<?php echo base_url(); ?>/document">
                  <?php echo $lang->docs; ?>
                </a></li>
            <?php }
            if ($youtube) { ?>
              <li><a href="<?php echo base_url(); ?>/youtube/youtube">
                  <?php echo $lang->youtube; ?>
                </a></li>
            <?php }
            if ($daily_closing) { ?>
              <li><a href="<?php echo base_url(); ?>/dailyclosing">
                  <?php echo $lang->daily_closing; ?>
                </a></li>
            <?php }
            if ($sales_report) { ?>
              <li><a href="<?php echo base_url(); ?>/salesreport">
                  <?php echo $lang->sales_report; ?>
                </a></li>
            <?php }

            if ($booking_notification) { ?>
              <li><a href="<?php echo base_url(); ?>/bookingnotification">
                  Booking Notification
                </a></li>
            <?php }
            ?>
            <li><a href="<?php echo base_url(); ?>/login/logout">
                <?php echo $lang->signout; ?>
              </a></li>
          </ul>
        </li>
      </ul>

    </div>

  </div>


</section>


<header class=" hidden-md  hidden-lg">
  <div class="menu-button__wrapper">
    <div class="menu-button">
      <span class="menu-button__bar"></span>
      <span class="menu-button__bar"></span>
      <span class="menu-button__bar"></span>
    </div>
  </div>

  <div class="menu-overlay">
    <section>
      <aside id="leftsidebar" class="sidebar">
        <div class="user-info">
          <!--<div class="image">
                <img src="<?php echo base_url(); ?>assets/images/user.png" width="48" height="48" alt="User" />
            </div>-->
          <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:12px;">
              <i class="material-icons" style="font-size:14px;">person</i>
              <?php echo $_SESSION['log_name']; ?>
            </div>
            <!--<div class="email">john.doe@example.com</div>-->
            <div class="btn-group user-helper-dropdown">
              <i class="material-icons" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="true">keyboard_arrow_down</i>
              <ul class="dropdown-menu pull-right">
                <!--<li><a href="<?php echo base_url(); ?>/profile/myprofile"><i class="material-icons">person</i>Profile</a></li>
                        <li role="separator" class="divider"></li>-->
                <li><a href="<?php echo base_url(); ?>/login/logout"><i class="material-icons">input</i>Sign Out</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="menu">
          <ul class="list">
            <li class="header">MAIN NAVIGATION</li>




            <li><a href="<?php echo base_url(); ?>/dashboard"><img
                  src="<?php echo base_url(); ?>/assets/images/dash.png"
                  style="width:33px; display:block;"><span>Dashboard</span></a></li>
            <?php if ($archanai_setting || $archanai_ticket || $archanai_report) { ?>
              <li><a href="javascript:void(0);" class="menu-toggle"><img
                    src="<?php echo base_url(); ?>/assets/images/archanai.png"
                    style="width:33px; display:block;"><span>Archanai </span></a>
                <ul class="ml-menu">
                  <li><a href="<?php echo base_url(); ?>/archanai/group_list">
                      <?php echo $lang->group; ?>
                    </a></li>
                  <?php if ($archanai_setting) { ?>
                    <li><a href="<?php echo base_url(); ?>/archanai">Setting</a></li>
                    <?php /* <li><a href="<?php echo base_url(); ?>/archanai/rasi">Rasi</a></li>
<li><a href="<?php echo base_url(); ?>/archanai/natchathiram">Natchathiram</a></li> */ ?>
                  <?php }
                  if ($archanai_ticket) { ?>
                    <li><a href="<?php echo base_url(); ?>/archanaibooking">Entry</a></li>
                  <?php }
                  if ($archanai_report) { ?>
                    <li><a href="<?php echo base_url(); ?>/report/arch_book_rep_view">Report</a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php }
            if ($hall_setting || $service_setting || $checklist_setting || $hall_booking || $hall_report) { ?>
              <li>
                <a href="javascript:void(0);" class="menu-toggle"><img
                    src="<?php echo base_url(); ?>/assets/images/booking.png"
                    style="width:33px; display:block;"><span>Booking </span></a>
                <ul class="ml-menu">
                  <?php if ($service_setting) { ?>
                    <li><a href="<?php echo base_url(); ?>/master/service">Service Setting</a></li>
                  <?php }
                  if ($checklist_setting) { ?>
                    <li><a href="<?php echo base_url(); ?>/master/checklist">Checklist Setting</a></li>
                  <?php }
                  if ($hall_setting) { ?>
                    <li><a href="<?php echo base_url(); ?>/master/hall">Hall Package Setting</a></li>
                    <li><a href="<?php echo base_url(); ?>/master/hall_block">Hall Block Setting</a></li>
                  <?php }
                  if ($hall_booking) { ?>
                    <li><a href="<?php echo base_url(); ?>/hallbooking">Hall Booking</a></li>
                  <?php } ?>
                  <li><a href="<?php echo base_url(); ?>/hallbooking/hallbook_remainder_list">Reminder Hall Booking</a>
                  </li>
                  <?php if ($hall_report) { ?>
                    <li><a href="<?php echo base_url(); ?>/report/hall_booking_rep_view">Report</a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php }
            if ($donation_setting || $uom || $cash_donation || $product_donation || $cash_report || $product_donation_report) { ?>
              <li>
                <a href="javascript:void(0);" class="menu-toggle"><img
                    src="<?php echo base_url(); ?>/assets/images/donation.png"
                    style="width:33px; display:block;"><span>Donation</span></a>
                <ul class="ml-menu">
                  <?php if ($donation_setting) { ?>
                    <li><a href="<?php echo base_url(); ?>/master/donation_setting">Donation Setting</a></li>
                  <?php }
                  if ($uom) { ?>
                    <li><a href="<?php echo base_url(); ?>/master/uom">UOM Setting</a></li>
                  <?php }
                  if ($cash_donation) { ?>
                    <li><a href="<?php echo base_url(); ?>/donation">Cash Donation</a></li>
                  <?php }
                  //if ($product_donation) { ?>
                    <!-- <li><a href="<?php echo base_url(); ?>/productdonation">Product Donation</a></li> -->
                  <?php //}
                  if ($cash_report) { ?>
                    <li><a href="<?php echo base_url(); ?>/report/cash_don_rep_view">Cash Donation Report</a></li>
                  <?php }
                  //if ($product_donation_report) { ?>
                    <!-- <li><a href="<?php echo base_url(); ?>/report/prod_don_rep_view">Product Donation Report</a></li> -->
                  <?php //} ?>
                </ul>
              </li>
            <?php }
            if ($ubayam_setting || $ubayam || $ubayam_report || $prasadam_setting) { ?>
              <li><a href="javascript:void(0);" class="menu-toggle"><img
                    src="<?php echo base_url(); ?>/assets/images/ubayam.png"
                    style="width:33px; display:block;"><span>Ubayam </span></a>
                <ul class="ml-menu">
                  <?php if ($ubayam_setting) { ?>
                    <li><a href="<?php echo base_url(); ?>/master/ubayam_setting">Ubayam Setting</a></li>
                  <?php }
                  if ($ubayam) { ?>
                    <li><a href="<?php echo base_url(); ?>/ubayam">Entry</a></li>
                    <li><a href="<?php echo base_url(); ?>/ubayam/ubayam_calendar">Ubayam Calendar</a></li>
                  <?php }
                  if ($ubayam_report) { ?>
                    <li><a href="<?php echo base_url(); ?>/report/ubayam_rep_view">Ubayam Report</a></li>
                  <?php }
                  if ($prasadam_setting) { ?>
                    <li><a href="<?php echo base_url(); ?>/prasadamsetting">Prasadam Setting</a></li>
                  <?php }
                  if ($prasadam) { ?>
                    <li><a href="<?php echo base_url(); ?>/prasadam">Prasadam</a></li>
                  <?php }
                  if ($prasadam_report) { ?>
                    <li><a href="<?php echo base_url(); ?>/report/prasadam_rep_view">Prasadam Report</a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php }
            if ($stock_group || $stock_in || $stock_out || $stock_report || $bom_report) { ?>
              <li><a href="javascript:void(0);" class="menu-toggle"><img
                    src="<?php echo base_url(); ?>/assets/images/inventory.png"
                    style="width:33px; display:block;"><span>Inventory </span></a>
                <ul class="ml-menu">
                  <li><a href="<?php echo base_url(); ?>/supplier">Supplier</a></li>
                  <li><a href="<?php echo base_url(); ?>/rawmaterial">Raw Material</a></li>
                  <li><a href="<?php echo base_url(); ?>/product">Product Setting</a></li>
                  <?php if ($stock_group) { ?>
                    <li><a href="<?php echo base_url(); ?>/master/stock_group">Stock Group Setting</a></li>
                  <?php }
                  if ($stock_in) { ?>
                    <li><a href="<?php echo base_url(); ?>/stock/stock_in">Stock In Entry</a></li>
                  <?php }
                  if ($stock_out) { ?>
                    <li><a href="<?php echo base_url(); ?>/stock/stock_out">Stock Out Entry</a></li>
                  <?php }
                  if ($stock_report) { ?>
                    <li><a href="<?php echo base_url(); ?>/report/stock_rep_view">Stock Report</a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php }
            if ($ac_creation_accounts || $entries_accounts || $ledger_report_accounts || $trial_balance_accounts || $balance_sheet_accounts || $profit_and_loss_accounts || $ledgers_name_list_accounts || $account_group_list_accounts) { ?>
              <li><a href="javascript:void(0);" class="menu-toggle"><img
                    src="<?php echo base_url(); ?>/assets/images/account.png"
                    style="width:33px; display:block;"><span>Account </span></a>
                <ul class="ml-menu">
                  <?php if ($ac_creation_accounts) { ?>
                    <li><a href="<?php echo base_url(); ?>/account">A/C Creation</a></li>

                    <li><a href="<?php echo base_url(); ?>/account/funds">Funds</a></li>
                  <?php }
                  if ($entries_accounts) { ?>
                    <li><a href="<?php echo base_url(); ?>/account/entries">Entries</a></li>
                  <?php }
                  if ($ledger_report_accounts) { ?>
                    <li><a href="<?php echo base_url(); ?>/accountreport/new_ledger_report">General Ledger</a></li>
                  <?php }
                  if ($trial_balance_accounts) { ?>
                    <li><a href="<?php echo base_url(); ?>/accountreport/trail_balance_new">Trial Balance</a></li>
                  <?php }
                  if ($balance_sheet_accounts) { ?>
                    <li><a href="<?php echo base_url(); ?>/balance_sheet/balancesheet_full">Balance Sheet</a></li>
                  <?php }
                  if ($profit_and_loss_accounts) { ?>
                    <li><a href="<?php echo base_url(); ?>/accountreport/profile_loss">Profit & Loss Reports</a></li>
                  <?php } ?>
                  <li><a href="<?php echo base_url(); ?>/reconciliation">Reconciliation</a></li>
                  <li><a href="<?php echo base_url(); ?>/aging">Aging</a></li>
                  <li><a href="<?php echo base_url(); ?>/accountreport/receipt_payment">
                      Receipt & Payment
                    </a></li>
                  <li><a href="<?php echo base_url(); ?>/report/ledger_rep_view">Ledger Report</a></li>
                  <li><a href="<?php echo base_url(); ?>/report/groups_rep_view">Account Group Report</a></li>
                </ul>
              </li>
            <?php }
            if ($user_setting || $staff_setting || $pay_slip || $commission || $commission_report || $payslip_report) { ?>
              <li><a href="javascript:void(0);" class="menu-toggle"><img
                    src="<?php echo base_url(); ?>/assets/images/finance.png"
                    style="width:33px; display:block;"><span>Finance </span></a>
                <ul class="ml-menu">
                  <?php if ($user_setting) { ?>
                    <li><a href="<?php echo base_url(); ?>/user">User Setting </a></li>
                  <?php }
                  if ($staff_setting) { ?>
                    <li><a href="<?php echo base_url(); ?>/master/staff">Staff Setting</a></li>
                  <?php }
                  if ($pay_slip) { ?>
                    <li><a href="<?php echo base_url(); ?>/payslip/advance_salary">Advance Salary</a></li>
                    <li><a href="<?php echo base_url(); ?>/payslip">Pay Slip</a></li>
                  <?php }
                  if ($commission) { ?>
                    <li><a href="<?php echo base_url(); ?>/commission">
                        <?php echo $lang->commision; ?>
                      </a></li>
                  <?php }
                  if ($commission_report) { ?>
                    <li><a href="<?php echo base_url(); ?>/report/commission_rep_view">Commission Report</a></li>
                  <?php }
                  if ($payslip_report) { ?>
                    <li><a href="<?php echo base_url(); ?>/report/">Pay Slip Report</a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php }
            if ($member_setting) { ?>
              <li><a href="javascript:void(0);" class="menu-toggle"><img
                    src="<?php echo base_url(); ?>/assets/images/profile.png"
                    style="width:33px; display:block;"><span>Member </span></a>
                <ul class="ml-menu">
                  <li><a href="<?php echo base_url(); ?>/member">Member Registration</a></li>
                  <li><a href="<?php echo base_url(); ?>/member_type">Member Type</a></li>
                  <li><a href="<?php echo base_url(); ?>/notification">Notification</a></li>
                  <li><a href="<?php echo base_url(); ?>/report/member_report">Report</a></li>
                  <li><a href="<?php echo base_url(); ?>/marriage">Register of Marriage</a></li>
                  <li><a href="<?php echo base_url(); ?>/report/courtesy_report">Courtesy Report</a></li>
                  <li><a href="<?php echo base_url(); ?>/report/visitors_reg_report">Visitor's Registration Report</a>
                  </li>
                </ul>
              </li>
            <?php } ?>
            <li><a href="javascript:void(0);" class="menu-toggle"><img
                  src="<?php echo base_url(); ?>/assets/images/rip.png"
                  style="width:33px; display:block;"><span>Cemetery</span></a>
              <ul class="ml-menu">
                <?php if ($cemetery_setting) { ?>
                  <li><a href="<?php echo base_url(); ?>/cemetery">Setting</a></li>
                  <li><a href="<?php echo base_url(); ?>/cemetery/booking_slot">Booking Time</a></li>
                <?php }
                if ($cemetery_reg) { ?>
                  <li><a href="<?php echo base_url(); ?>/cemetery/cemetery_register">Registration</a></li>
                <?php }
                if ($cemetery_report) { ?>
                  <li><a href="<?php echo base_url(); ?>/cemetery/report">Approved Report</a></li>
                <?php }
                if ($agent_registration) { ?>
                  <li><a href="<?php echo base_url(); ?>/agent_reg">Agent Registration</a></li>
                <?php }
                if ($agent_specialtime_registration) { ?>
                  <li><a href="<?php echo base_url(); ?>/cemetery/cemetery_specialtime_register_pending"> Specialtime
                      Registration</a></li>
                <?php }
                if ($cemetery_specialtime_approved) { ?>
                  <li><a href="<?php echo base_url(); ?>/cemetery/cemetery_specialtime_register_approved"> Specialtime
                      Approved</a></li>
                <?php } ?>
              </ul>
            </li>
            <!-- <li><a href="<?php echo base_url(); ?>/properties"><img
                  src="<?php echo base_url(); ?>/assets/images/donation.png" style="width:50px; display:block;"><span>
                  <?php echo $lang->properties; ?>
                </span></a></li> -->

                <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/temple.png" style="width:50px; display:block;"><span>
                Temple Event<i class='bx bxs-chevron-down js-arrow arrow '></i>
              </span></a>
            <ul class="js-sub-menu sub-menu">
          
              <li><a href="<?php echo base_url(); ?>/master/booking_slot">
                  Booking Slot
                </a></li>
              <li><a href="<?php echo base_url(); ?>/master/venue">
                  Venue
                </a></li>
              <li><a href="<?php echo base_url(); ?>/master/pack_service">
                  Services
                </a></li>
              <li><a href="<?php echo base_url(); ?>/deity">
                  Deity Settings
                </a></li>
              <li><a href="<?php echo base_url(); ?>/master/package">
                  Packages
                </a></li>
              <li><a href="<?php echo base_url(); ?>/templeubayam">
                  Ubayam
                </a></li>
              <li><a href="<?php echo base_url(); ?>/templehallbooking">
                  Hall Booking
                </a></li>
              <!-- <li><a href="<?php echo base_url(); ?>/report/temple_rep_view">
                  Report
                </a></li> -->
            </ul>
          </li>

            <li><a href="<?php echo base_url(); ?>/dailyclosing"><img
                  src="<?php echo base_url(); ?>/assets/images/account.png"
                  style="width:50px; display:block;"><span>Daily Closing</span></a></li>
                  <li><a href="<?php echo base_url(); ?>/salesreport"><img
                  src="<?php echo base_url(); ?>/assets/images/account.png"
                  style="width:50px; display:block;"><span>Sales Report</span></a></li>
            <li><a href="javascript:void(0);" class="menu-toggle"><img
                  src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>"
                  style="width:33px; display:block;"><span>Profile</span></a>
              <ul class="ml-menu">
                <li><a href="<?php echo base_url(); ?>/profile/profile_edit">Temple Setting</a></li>
                <?php if ($terms_setting) { ?>
                  <li><a href="<?php echo base_url(); ?>/terms/edit">Terms Setting</a></li>
                <?php }
                if ($message_setting) { ?>
                  <li><a href="<?php echo base_url(); ?>/message/edit">Message Setting</a></li>
                <?php } /* if($whatsappmessage_setting) {?>
<li><a href="<?php echo base_url(); ?>/whatsappmessage/edit">Whatsapp Message Setting</a></li>
<?php } */ ?>
                <li><a href="<?php echo base_url(); ?>/paymentmodesetting">Payment Mode Setting</a></li>
                <li><a href="<?php echo base_url(); ?>/document">Document Store</a></li>
                <!--<li><a href="<?php echo base_url(); ?>/login/logout">Sign Out</a></li>-->
              </ul>
            </li>








          </ul>

        </div>
        <!--<div class="legal">
            <div class="copyright">
                &copy; 2022 <a href="#">ADMIN</a>. All Rights Reserved.
            </div>
        </div>-->
      </aside>
    </section>
  </div>
  <div class="background-overlay"></div>

</header>
<style>
  .sidebar .user-info {
    padding: 3px 15px 12px 15px;
    height: 50px;
  }

  .navbar1 .links li {
    min-width: 35px;
  }

  .sidebar .menu {
    height: 80vh;
  }
</style>
<script src="<?php echo base_url(); ?>/assets/js/menustyle.js"></script>