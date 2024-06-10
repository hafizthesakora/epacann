<?php
$from = $this->input->get('from');
$to = $this->input->get('to');
?>
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Form Layouts</span> - Horizontal</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
                </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="icon-home2 position-left"></i>Accounts</a></li>
                <li class="active">Profit & Loss</li>
            </ul>
            <input type="button" onclick="printDiv('Printdiv')" class="button-style-2 submit-btn print" value="Print"/>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <form action="<?php echo base_url('admin/profloss_search') ?>" method="get" id="search" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12" style="float:right">
                            <div class="form-group daybk-date">
                                <label class="col-md-offset-4 col-lg-2 col-xs-6 control-label"><b>From date</b><span> :</span></label> 
                                <div class="col-lg-2 col-xs-6"> 
                                    <div class="class input-group date">
                                        <?php $fromdate = $this->input->get('from'); ?>
                                        <input id="from_date"  class="form-control datepicker" data-date-format="yyyy-mm-dd" type="text" name="from" value="<?php echo $fromdate ?>"  >                                       
                                    </div>
                                </div>
                                <label class="col-lg-1 col-xs-6 control-label"><b>To date</b><span> :</span></label> 
                                <div class="col-lg-2 col-xs-6"> 
                                    <div class="class input-group date">
                                        <?php $todate = $this->input->get('to'); ?>
                                        <input id="to_date"  class="form-control datepicker" data-date-format="yyyy-mm-dd"  type="text" name="to" value="<?php echo $todate ?>" >                                       
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12 align-center">               
                                        <button class="button-style-2 submit-btn" type="submit" name="submit" id="Submit">Search </button>                                                 </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="panel-body">
                <div class="pane-search">
                    <div class="table-responsive">   
                        <div class="trans-table-display" id="Printdiv">
                            <style type="text/css">
                                @media print {
                                    tr{
                                        border:1px solid #ccc;
                                    }
                                    td{
                                        font-size: 11px;
                                    }
                                    a[href]:after {
                                        content: none !important;
                                    }
                                    .table-one{
                                        float:left  !important;
                                        width:48% !important;
                                    }
                                    .table-two{
                                        float:left  !important;
                                        width:48% !important;
                                    }.trans-margin , table.transactions-table{
                                        margin: unset !important; 
                                    }
                                    html, body {
                                        border: 1px solid white;
                                        height: 99%;
                                        page-break-after: avoid !important;
                                        page-break-before: avoid !important;
                                    }

                                }
                            </style>
                            <!-- <div class="trans-table">-->
                            <div class="row">
                                <div class="col-md-6 ">
                                    <table class="transactions-table trans-margin table-striped table-bordered table-one">
                                        <thead class="transactions-table-head">
                                            <tr>
                                                <th class="text-left">Particulars</th>
                                                <th class="text-right">Amount in Rs.</th>
                                            </tr>
                                        </thead>
                                        <?php if (!empty($from) || !empty($to)) { ?>
                                            <tbody class="match-height">
                                                 <?php
                                                    $pl_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to,'vch_date>' => '2019-03-31','under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->row();
                                                    $pl_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to,'vch_date>' => '2019-03-31','under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                <?php
                                                $getdinterest = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to,'vch_date>' => '2019-03-31', 'particulars' => "46", 'status != ' => 'Trash'))->row();
                                                $getcinterest = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to,'vch_date>' => '2019-03-31', 'particulars' => "48", 'status != ' => 'Trash'))->row();
                                                $get_addless_adjustment_val = $this->db->select_sum('addless')->get_where('settings', array('status != ' => 'Trash'))->row();
                                                $get_commision_adjustment_val = $this->db->select_sum('commision')->get_where('settings', array('status != ' => 'Trash'))->row();
                                                $d_exp_tot2 = 0;
                                                foreach ($details as $detail) {
                                                    ?>
                                                    <?php
                                                    $vch_detail = $this->db->group_by('particulars')->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to,'vch_date>' => '2019-03-31', 'particulars' => $detail->particulars,'particulars!='=>'46', 'status !=' => 'Trash'))->row();
                                                    $d_exp_tot2 += $vch_detail->debit;
                                                    ?>
                                                    <?php
                                                }
                                                $c_ladd_less = $this->db->select_sum('add_less')->get_where('receipts', array( 'receipt_date>' => '2019-03-31','receipt_date>=' => $from, 'receipt_date<=' => $to, 'add_less >' => 0, 'status !=' => 'Trash'))->result();
                                                $c_pladd_less = $this->db->select_sum('add_less')->get_where('personalloan_receipts', array( 'receipt_date>' => '2019-03-31','receipt_date>=' => $from, 'receipt_date<=' => $to, 'add_less >' => 0, 'status !=' => 'Trash'))->result();
                                                $d_radd_less = $this->db->select_sum('add_less')->get_where('replace_payments', array('pymt_date>' => '2019-03-31','pymt_date>=' => $from, 'pymt_date<=' => $to, 'add_less >' => 0, 'status !=' => 'Trash'))->result();
                                                $d_dadd_less = $this->db->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31','pymt_date>=' => $from, 'pymt_date<=' => $to, 'add_less >' => 0, 'status !=' => 'Trash'))->result();
                                                $d_ladd_less = $this->db->select_sum('add_less')->get_where('receipts', array( 'receipt_date>' => '2019-03-31','receipt_date>=' => $from, 'receipt_date<=' => $to, 'add_less <' => 0, 'status !=' => 'Trash'))->result();
                                                $d_pladd_less = $this->db->select_sum('add_less')->get_where('personalloan_receipts', array( 'receipt_date>' => '2019-03-31','receipt_date>=' => $from, 'receipt_date<=' => $to, 'add_less <' => 0, 'status !=' => 'Trash'))->result();
                                                $c_radd_less = $this->db->select_sum('add_less')->get_where('replace_payments', array('pymt_date>' => '2019-03-31','pymt_date>=' => $from, 'pymt_date<=' => $to, 'add_less <' => 0, 'status !=' => 'Trash'))->result();
                                                $c_dadd_less = $this->db->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31','pymt_date>=' => $from, 'pymt_date<=' => $to, 'add_less <' => 0, 'status !=' => 'Trash'))->result();
                                                $addless = $get_addless_adjustment_val->addless - ($c_ladd_less[0]->add_less) - $c_pladd_less[0]->add_less - (-($c_radd_less[0]->add_less)) - (-($c_dadd_less[0]->add_less)) + $d_radd_less[0]->add_less +$d_dadd_less[0]->add_less + (-($d_ladd_less[0]->add_less)) + (-($d_pladd_less[0]->add_less));
//                                               print_r($addless);

                                                if ($addless > 0) {
                                                    $tot2 = $d_exp_tot2 + $commission[0]->other_amt + $get_commision_adjustment_val->commision + $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $getdinterest->debit + $addless +$pl_dr->debit - $pl_cr->credit ;
                                                } else {
                                                    $tot2 = $d_exp_tot2 + $commission[0]->other_amt + $get_commision_adjustment_val->commision + $paidint[0]->paid_int_amt + $getdinterest->debit + $paiddepint[0]->paid_int_amt + $pl_dr->debit - $pl_cr->credit;
                                                }
                                                ?>
                                                <?php
                                                if ($addless > 0) {
                                                    $int2 = $loanint[0]->rcvd_int_amt + $ploanint[0]->rcvd_int_amt + $getcinterest->credit;
                                                } else {
                                                    $int2 = $loanint[0]->rcvd_int_amt + $ploanint[0]->rcvd_int_amt + $getcinterest->credit - $addless;
                                                }
                                                ?>

                                            <td colspan="2" class="text-left"><b>Direct Expenses</b></td>
                                            <?php
                                            $d_exp_tot = 0;
                                            foreach ($details as $detail) {
                                                $getname = $this->db->get_where('ledger', array('ledger_id' => $detail->particulars, 'status != ' => 'Trash'))->row();
                                                ?>
                                                <tr>
                                                    <td class="text-left"><a href="view_vch_details?voucher_id=<?php echo $detail->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                    <?php
                                                    $vch_detail = $this->db->group_by('particulars')->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to,'vch_date>' => '2019-03-31', 'particulars' => $detail->particulars, 'status !=' => 'Trash'))->row();
                                                    $d_exp_tot += $vch_detail->debit;
                                                    ?>
                                                    <td class="text-right"> <?php echo moneyformat($vch_detail->debit); ?></td>  
                                                </tr>
                                                <?php
                                            }
                                            if ($addless > 0) {

                                                $tot = $d_exp_tot + $commission[0]->other_amt + $get_commision_adjustment_val->commision + $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $addless + $pl_dr->debit - $pl_cr->credit;
                                            } else {
                                                $tot = $d_exp_tot + $commission[0]->other_amt + $get_commision_adjustment_val->commision + $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $pl_dr->debit - $pl_cr->credit;
                                                //  print_r($tot);
                                            }
                                            ?>
                                            <tr>
                                                <?php
                                                $intpaid = $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $getdinterest->debit;
                                                ?>
                                                <td class="text-left"><a href="view_vch_details?voucher_id=Interest Paid">Interest Paid</a></td>
                                                <td class="text-right"> <?php echo moneyformat($intpaid) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><a href="profit_loss_detail?voucher_id=Commission Paid to Bank">Commission Paid to Bank</a></td>
                                                <td class="text-right"> <?php echo moneyformat($commission[0]->other_amt + $get_commision_adjustment_val->commision) ?></td>
                                            </tr>
                                            <?php if ($addless > 0) { ?>
                                                <tr>
                                                    <td class="text-left"><a href="profit_loss_detail?voucher_id=Add/Less">Add/Less</a></td>
                                                    <td class="text-right"> <?php echo moneyformat($addless) ?></td>
                                                </tr>
                                            <?php } ?>
                                                                     
                                                    <?php
                                                    $prfloss_dr = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to,'vch_date>' => '2019-03-31','under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->result();
                                                    foreach ($prfloss_dr as $prfloss_dr) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $prfloss_dr->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to,'vch_date>' => '2019-03-31','particulars' => $prfloss_dr->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to,'vch_date>' => '2019-03-31','particulars' => $prfloss_dr->particulars, 'status!=' => 'Trash'))->row();
                                                        //$tot_dr += $debit->debit - $cred->credit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $prfloss_dr->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($debit->debit - $cred->credit) ?></td>
                                                        </tr>
                                                    <?php } ?>

                                            <tr><td colspan="2" class="text-right"> <b><?php echo moneyformat($tot2 ); ?></b></td>
                                            </tr>
                                            <?php if ($tot2 < $int2) { ?>
                                                <tr>
                                                    <td class="text-left"><b>Gross Profit</b></td>
                                                    <td class="text-right"> <b><?php echo moneyformat($int2 - $tot2) ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left"><b>Total</b></td><td class="text-right"> <b><?php echo moneyformat($tot2 + $int2 - $tot2); ?></b></td>
                                                </tr>
                                            <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="transactions-table trans-margin table-striped table-bordered table-two">
                                            <thead class="transactions-table-head">
                                                <tr>
                                                    <th class="text-left">Particulars</th>
                                                    <th class="text-right">Amount in Rs.</th>
                                                </tr>
                                            </thead>
                                            <tbody class="match-height">
                                                <tr><td colspan="2"  class="text-left"><b>Direct Incomes</b></td></tr>
                                                <tr><?php
                                                    $int = $loanint[0]->rcvd_int_amt + $ploanint[0]->rcvd_int_amt + $getcinterest->credit;
                                                    ?><td class="text-left"><a href="view_vch_details?voucher_id=Interest Received">Interest Received</a></td> 
                                                    <td class="text-right"><b> <?php echo moneyformat($int); ?></b></td>
                                                </tr>
                                                <?php if ($addless < 0) { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="profit_loss_detail?voucher_id=Add/Less">Add/Less</a></td>
                                                        <td class="text-right"> <?php echo moneyformat(-$addless) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($tot2 > $int2) { ?>
                                                    <tr>
                                                        <td class="text-left"><b>Gross Loss(C/o)</b></td>
                                                        <td class="text-right"> <b><?php echo moneyformat($tot2 - $int2) ?></b></td>
                                                    </tr> <?php } ?>
                                                <tr>
                                                    <?php if ($addless < 0 && $tot2 > $int2) { ?>
                                                        <td class="text-left"><b>Total</b></td><td class="text-right"> <b><?php echo moneyformat($int - $addless + $tot2 - $int2); ?></b></td>
                                                    <?php } else if($addless < 0 && $tot2 < $int2) { ?>
                                                        <td class="text-left"><b>Total</b></td><td class="text-right"> <b><?php echo moneyformat($int - $addless ); ?></b></td>
                                                   <?php } else {  ?>
                                                        <td class="text-left"><b>Total</b></td><td class="text-right"> <b><?php echo moneyformat($tot2 + $int2 - $tot2); ?></b></td>
                                                    <?php } ?>
                                                </tr>
                                            </tbody>
                                        <?php } else { ?>
                                            <tbody class="match-height">
                                                 <?php
                                                    $pl_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>' => '2019-03-31','under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->row();
                                                    $pl_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>' => '2019-03-31','under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                <?php
                                                $getdinterest = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>' => '2019-03-31','particulars' => "46", 'status != ' => 'Trash'))->row();
                                                $getcinterest = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>' => '2019-03-31','particulars' => "48", 'status != ' => 'Trash'))->row();
                                                $get_addless_adjustment_val = $this->db->select_sum('addless')->get_where('settings', array('status != ' => 'Trash'))->row();
                                                $get_commision_adjustment_val = $this->db->select_sum('commision')->get_where('settings', array('status != ' => 'Trash'))->row();
                                                $d_exp_tot2 = 0;
                                                foreach ($details as $detail) {
                                                    ?>
                                                    <?php
                                                    $vch_detail = $this->db->group_by('particulars')->select_sum('debit')->get_where('vouchers', array('vch_date>' => '2019-03-31','particulars' => $detail->particulars, 'status !=' => 'Trash'))->row();
                                                    $d_exp_tot2 += $vch_detail->debit;
                                                    ?>
                                                    <?php
                                                }
                                                $c_ladd_less = $this->db->select_sum('add_less')->get_where('receipts', array( 'receipt_date>' => '2019-03-31','add_less >' => 0, 'status !=' => 'Trash'))->result();
                                                $c_pladd_less = $this->db->select_sum('add_less')->get_where('personalloan_receipts', array( 'receipt_date>' => '2019-03-31','add_less >' => 0, 'status !=' => 'Trash'))->result();
                                                $d_radd_less = $this->db->select_sum('add_less')->get_where('replace_payments', array('pymt_date>' => '2019-03-31','add_less >' => 0, 'status !=' => 'Trash'))->result();
                                                $d_dadd_less = $this->db->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31','add_less >' => 0, 'status !=' => 'Trash'))->result();
                                                $d_ladd_less = $this->db->select_sum('add_less')->get_where('receipts', array( 'receipt_date>' => '2019-03-31','add_less <' => 0, 'status !=' => 'Trash'))->result();
                                                $d_pladd_less = $this->db->select_sum('add_less')->get_where('personalloan_receipts', array( 'receipt_date>' => '2019-03-31','add_less <' => 0, 'status !=' => 'Trash'))->result();
                                                $c_radd_less = $this->db->select_sum('add_less')->get_where('replace_payments', array('pymt_date>' => '2019-03-31','add_less <' => 0, 'status !=' => 'Trash'))->result();
                                                $c_dadd_less = $this->db->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31','add_less <' => 0, 'status !=' => 'Trash'))->result();
                                                $addless = $get_addless_adjustment_val->addless - ($c_ladd_less[0]->add_less) - $c_pladd_less[0]->add_less - (-($c_radd_less[0]->add_less)) - (-($c_dadd_less[0]->add_less)) + $d_radd_less[0]->add_less +$d_dadd_less[0]->add_less + (-($d_ladd_less[0]->add_less)) + (-($d_pladd_less[0]->add_less));
                                                if ($addless > 0) {
                                                    $tot2 = $d_exp_tot2 + $commission[0]->other_amt + $get_commision_adjustment_val->commision + $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $getdinterest->debit + $pl_dr->debit - $pl_cr->credit ;
                                                } else {
                                                    $tot2 = $d_exp_tot2 + $commission[0]->other_amt + $get_commision_adjustment_val->commision + $paidint[0]->paid_int_amt + $getdinterest->debit + $paiddepint[0]->paid_int_amt + $addless + $pl_dr->debit - $pl_cr->credit;
                                                }
                                                ?>
                                                <?php
                                                if ($addless > 0) {
                                                    $int2 = $loanint[0]->rcvd_int_amt + $ploanint[0]->rcvd_int_amt + $getcinterest->credit;
                                                } else {
                                                    $int2 = $loanint[0]->rcvd_int_amt + $ploanint[0]->rcvd_int_amt + $getcinterest->credit - $addless;
                                                }
                                                ?>
                                            <td colspan="2" class="text-left"><b>Direct Expenses</b></td>
                                            <?php
                                            $d_exp_tot = 0;
                                            foreach ($details as $detail) {
                                                $getname = $this->db->get_where('ledger', array('ledger_id' => $detail->particulars, 'status != ' => 'Trash'))->row();
                                                ?>
                                                <tr>
                                                    <td class="text-left"><a href="view_vch_details?voucher_id=<?php echo $detail->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                    <?php
                                                    $vch_detail = $this->db->group_by('particulars')->select_sum('debit')->get_where('vouchers', array('particulars' => $detail->particulars, 'status !=' => 'Trash'))->row();
                                                    $d_exp_tot += $vch_detail->debit;
                                                    ?>
                                                    <td class="text-right"> <?php echo moneyformat($vch_detail->debit); ?></td>  
                                                </tr>
                                                <?php
                                            }
                                            if ($addless > 0) {

                                                $tot = $d_exp_tot + $commission[0]->other_amt + $get_commision_adjustment_val->commision + $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $addless + $pl_dr->debit - $pl_cr->credit;
                                            } else {
                                                $tot = $d_exp_tot + $commission[0]->other_amt + $get_commision_adjustment_val->commision + $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $pl_dr->debit - $pl_cr->credit;
                                                //  print_r($tot);
                                            }
                                            ?>
                                            <tr>
                                                <?php
                                                $intpaid = $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $getdinterest->debit;
                                                ?>
                                                <td class="text-left"><a href="view_vch_details?voucher_id=Interest Paid">Interest Paid</a></td>
                                                <td class="text-right"> <?php echo moneyformat($intpaid) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><a href="profit_loss_detail?voucher_id=Commission Paid to Bank">Commission Paid to Bank</a></td>
                                                <td class="text-right"> <?php echo moneyformat($commission[0]->other_amt + $get_commision_adjustment_val->commision) ?></td>
                                            </tr>
                                            <?php if ($addless > 0) { ?>
                                                <tr>
                                                    <td class="text-left"><a href="profit_loss_detail?voucher_id=Add/Less">Add/Less</a></td>
                                                    <td class="text-right"> <?php echo moneyformat($addless) ?></td>
                                                </tr>
                                            <?php } ?>
                                                
                                                                         
                                                    <?php
                                                    $prfloss_dr = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date>' => '2019-03-31','under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->result();
                                                    foreach ($prfloss_dr as $prfloss_dr) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $prfloss_dr->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>' => '2019-03-31','particulars' => $prfloss_dr->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>' => '2019-03-31','particulars' => $prfloss_dr->particulars, 'status!=' => 'Trash'))->row();
                                                        //$tot_dr += $debit->debit - $cred->credit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $prfloss_dr->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($debit->debit - $cred->credit) ?></td>
                                                        </tr>
                                                    <?php } ?>

                                            <tr><td colspan="2" class="text-right"> <b><?php echo moneyformat($tot2); ?></b></td>
                                            </tr>
                                            <?php if ($tot2 < $int2) { ?>
                                                <tr>
                                                    <td class="text-left"><b>Gross Profit</b></td>
                                                    <td class="text-right"> <b><?php echo moneyformat($int2 - $tot2) ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left"><b>Total</b></td><td class="text-right"> <b><?php echo moneyformat($tot2 + $int2 - $tot2); ?></b></td>
                                                </tr>
                                            <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6 ">
                                        <table class="transactions-table trans-margin table-striped table-bordered table-two">
                                            <thead class="transactions-table-head">
                                                <tr>
                                                    <th class="text-left">Particulars</th>
                                                    <th class="text-right">Amount in Rs.</th>
                                                </tr>
                                            </thead>
                                            <tbody class="match-height">
                                                <tr><td colspan="2"  class="text-left"><b>Direct Incomes</b></td></tr>
                                                <tr><?php
                                                    $int = $loanint[0]->rcvd_int_amt + $ploanint[0]->rcvd_int_amt + $getcinterest->credit;
                                                    ?><td class="text-left"><a href="view_vch_details?voucher_id=Interest Received">Interest Received</a></td> 
                                                    <td class="text-right"><b> <?php echo moneyformat($int); ?></b></td>
                                                </tr>
                                                <?php if ($addless < 0) { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="profit_loss_detail?voucher_id=Add/Less">Add/Less</a></td>
                                                        <td class="text-right"> <?php echo moneyformat(-$addless) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if ($tot2 > $int2) { ?>
                                                    <tr>
                                                        <td class="text-left"><b>Gross Loss(C/o)</b></td>
                                                        <td class="text-right"> <b><?php echo moneyformat($tot2 - $int2) ?></b></td>
                                                    </tr> <?php } ?>
                                                <tr>
                                                    <?php if ($addless < 0 && $tot2 > $int2) { ?>
                                                        <td class="text-left"><b>Total</b></td><td class="text-right"> <b><?php echo moneyformat($int - $addless + $tot2 - $int2); ?></b></td>
                                                    <?php } else if ($addless < 0 && $tot2 < $int2) { ?>
                                                        <td class="text-left"><b>Total</b></td><td class="text-right"> <b><?php echo moneyformat($int - $addless); ?></b></td>
                                                   <?php } else { ?>
                                                        <td class="text-left"><b>Total</b></td><td class="text-right"> <b><?php echo moneyformat($int + $tot2 - $int2); ?></b></td>
                                                    <?php } ?>
                                                </tr>

                                            </tbody>

                                        <?php } ?>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /2 columns form -->
</div>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = '<h2>Kundrakudian Finance</h2><h6>540, South car street ,</h6><h6>Kundrakudi .</h6><h6 class="text-right" style="position:absolute; top:50px;right:0;"><b>From</b> :  <?php echo (!empty($from)) ? $from : "01-04-2018"?> ,<b>To</b> :  <?php echo (!empty($to)) ? $to : date('d-m-Y');?></h6><br><h5 class="text-right" style="position:absolute; top:80px;right:0;font-size:10px"><b>Print Date</b> :  <?php echo date('d-m-Y') ?></h5><h3 class="text-center">PL Balance</h3><table style="width:100% !important;border:1px solid #ddd;padding:10px;">' + document.getElementById(divName).innerHTML + '</table>';
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<script>
    jQuery(function () {
        jQuery('.match-height').matchHeight();
    });
</script>