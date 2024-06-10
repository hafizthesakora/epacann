<?php
ini_set('memory_limit', '2048M');
$get_addless_adjustment_val = $this->db->select_sum('addless')->get_where('settings', array('status != ' => 'Trash'))->row();
$get_commision_adjustment_val = $this->db->select_sum('commision')->get_where('settings', array('status != ' => 'Trash'))->row();
$get_loanamt = $this->db->select_sum('loans')->get_where('settings', array('status != ' => 'Trash'))->row();
$get_cashamt = $this->db->select_sum('cash')->get_where('settings', array('status != ' => 'Trash'))->row();
$get_year_credit = $this->db->select_sum('credit')->get_where('settings', array('status != ' => 'Trash'))->row();
$get_year_debit = $this->db->select_sum('debit')->get_where('settings', array('status != ' => 'Trash'))->row();
$tot_cr = 0;
$tot_dr = 0;
$to = $this->input->get('to');
?>
<div class = "content-wrapper">
    <!--Page header -->
    <div class = "page-header">
        <div class = "page-header-content">
            <div class = "page-title">
                <h4><i class = "icon-arrow-left52 position-left"></i> <span class = "text-semibold">Form Layouts</span> - Horizontal</h4>
            </div>
            <div class = "heading-elements">
                <div class = "heading-btn-group">
                    <a href = "#" class = "btn btn-link btn-float has-text"><i class = "icon-bars-alt text-primary"></i><span>Statistics</span></a>
                    <a href = "#" class = "btn btn-link btn-float has-text"><i class = "icon-calculator text-primary"></i> <span>Invoices</span></a>
                    <a href = "#" class = "btn btn-link btn-float has-text"><i class = "icon-calendar5 text-primary"></i> <span>Schedule</span></a>
                </div>
            </div>
        </div>
        <div class = "breadcrumb-line">
            <ul class = "breadcrumb">
                <li><a href = ""><i class = "icon-home2 position-left"></i>Accounts</a></li>
                <li class = "active">Balance Sheet</li>
            </ul>
            <input type = "button" onclick = "printDiv('Printdiv')" class = "button-style-2 submit-btn print" value = "Print"/>
        </div>
    </div>
    <!--/page header -->
    <!--Content area -->
    <div class = "content">
        <div class = "panel panel-flat">
            <div class="panel-heading">
                <form action="<?php echo base_url('admin/balance_sheet_search') ?>" method="get" id="search" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12" style="float:right">
                            <div class="form-group daybk-date">
                                <label class="col-md-offset-7 col-lg-2 col-xs-6 control-label"><b>As on Date </b><span> :</span></label> 
                                <div class="col-lg-2 col-xs-6"> 
                                    <div class="class input-group date">
                                        <input id="from_date"  class="form-control datepicker" data-date-format="yyyy-mm-dd" type="text" name="to" value="<?php echo $to ?>"  >                                       
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12 align-center">               
                                        <button class="button-style-2 submit-btn" type="submit" name="submit" id="Submit">Search </button>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class = "panel-body">
                <div class = "pane-search">
                    <div class = "table-responsive">
                        <div class = "trans-table-display" id = "Printdiv">
                            <!--<div class = "trans-table"> -->
                            <style type = "text/css">
                                @media print {
                                    tr{
                                        border:1px solid #ccc;
                                    }
                                    a[href]:after {
                                        content: none!important;
                                    }
                                    .hidden-print {
                                        display:none;
                                    }
                                    td {
                                        border: 1px solid #bad8b0 !important;
                                        font-size: 8px;
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

                            <?php if (!empty($to)) { ?>
                                <?php
                                $pl_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>' => '2019-03-31', 'vch_date<=' => $to, 'under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->row();
                                $pl_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>' => '2019-03-31', 'vch_date<=' => $to, 'under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->row();
                                ?>
                                <?php
                                $getdinterest = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>' => '2019-03-31', 'vch_date<=' => $to, 'particulars' => "46", 'status != ' => 'Trash'))->row();
                                $getcinterest = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>' => '2019-03-31', 'vch_date<=' => $to, 'particulars' => "48", 'status != ' => 'Trash'))->row();
                                $get_addless_adjustment_val = $this->db->select_sum('addless')->get_where('settings', array('status != ' => 'Trash'))->row();
                                $get_commision_adjustment_val = $this->db->select_sum('commision')->get_where('settings', array('status != ' => 'Trash'))->row();
                                $d_exp_tot2 = 0;
                                foreach ($detailss as $detail) {
                                    ?>
                                    <?php
                                    $vch_detail = $this->db->group_by('particulars')->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'vch_date>' => '2019-03-31', 'particulars' => $detail->particulars, 'particulars!=' => '46', 'status !=' => 'Trash'))->row();
                                    $d_exp_tot2 += $vch_detail->debit;
                                    ?>
                                    <?php
                                }
                                $c_ladd_less = $this->db->select_sum('add_less')->get_where('receipts', array('receipt_date>' => '2019-03-31', 'receipt_date<=' => $to, 'add_less >' => 0, 'status !=' => 'Trash'))->result();
                                $c_pladd_less = $this->db->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date>' => '2019-03-31', 'receipt_date<=' => $to, 'add_less >' => 0, 'status !=' => 'Trash'))->result();
                                $d_radd_less = $this->db->select_sum('add_less')->get_where('replace_payments', array('pymt_date>' => '2019-03-31', 'pymt_date<=' => $to, 'add_less >' => 0, 'status !=' => 'Trash'))->result();
                                $d_dadd_less = $this->db->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31', 'pymt_date<=' => $to, 'add_less >' => 0, 'status !=' => 'Trash'))->result();
                                $d_ladd_less = $this->db->select_sum('add_less')->get_where('receipts', array('receipt_date>' => '2019-03-31', 'receipt_date<=' => $to, 'add_less <' => 0, 'status !=' => 'Trash'))->result();
                                $d_pladd_less = $this->db->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date>' => '2019-03-31', 'receipt_date<=' => $to, 'add_less <' => 0, 'status !=' => 'Trash'))->result();
                                $c_radd_less = $this->db->select_sum('add_less')->get_where('replace_payments', array('pymt_date>' => '2019-03-31', 'pymt_date<=' => $to, 'add_less <' => 0, 'status !=' => 'Trash'))->result();
                                $c_dadd_less = $this->db->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31', 'pymt_date<=' => $to, 'add_less <' => 0, 'status !=' => 'Trash'))->result();
                                $addless = $get_addless_adjustment_val->addless - ($c_ladd_less[0]->add_less) - $c_pladd_less[0]->add_less - (-($c_radd_less[0]->add_less)) - (-($c_dadd_less[0]->add_less)) + $d_radd_less[0]->add_less + $d_dadd_less[0]->add_less + (-($d_ladd_less[0]->add_less)) + (-($d_pladd_less[0]->add_less));
//                                               print_r($addless);

                                if ($addless > 0) {
                                    $tot2 = $d_exp_tot2 + $commission[0]->other_amt + $get_commision_adjustment_val->commision + $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $getdinterest->debit + $addless + $pl_dr->debit - $pl_cr->credit;
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

                                <div class = "container-fluid">
                                    <div class = "row">
                                        <div class = "col-md-6">
                                            <table class = "transactions-table trans-margin table-striped table-bordered tribal table-one" >
                                                <thead class = "transactions-table-head">
                                                    <tr>
                                                        <th class = "text-left">Liabilities</th>
                                                        <th class = "text-right">Amount (GHS)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Capital Account', 'status!=' => 'Trash'))->row();
                                                    $dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Capital Account', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class = "text-left bold-head"><b>Capital Account</b>
                                                        <td class="text-right"><b><?php echo moneyformat($cr->credit - $dr->debit + $get_year_credit->credit - $get_year_debit->debit) ?></b></td></td>
                                                    </tr>
                                                    <?php
                                                    $get_capacc = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Capital Account', 'particulars!=' => '59', 'status!=' => 'Trash'))->result();
                                                    foreach ($get_capacc as $get_capacc) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $get_capacc->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $get_capacc->particulars, 'particulars!=' => '59', 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $get_capacc->particulars, 'particulars!=' => '59', 'status!=' => 'Trash'))->row();
                                                        $tot_cr += $cred->credit - $debit->debit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $get_capacc->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit) ?></td>
                                                        </tr>
                                                    <?php } ?> 
                                                    <?php
                                                    $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => '59', 'status!=' => 'Trash'))->row();
                                                    $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => '59', 'status!=' => 'Trash'))->row();
                                                    $tot_cr += $cred->credit - $debit->debit + $get_year_credit->credit - $get_year_debit->debit;
                                                    ?>
                                                    <tr>
                                                        <td class="text-left bold-head"><a href="view_vch_details?voucher_id=59">S. UNNAMALAI CURRENT ACCOUNT</a></td>
                                                        <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit + $get_year_credit->credit - $get_year_debit->debit) ?></td>
                                                    </tr>

                                                    <?php
                                                    $l_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Loans(Liability)', 'status!=' => 'Trash'))->row();
                                                    $l_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Loans(Liability)', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Loans(Liability)</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($l_cr->credit - $l_dr->debit) ?></b></td></tr>                                  
                                                    <?php
                                                    $loans_liblty = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Loans(Liability)', 'status!=' => 'Trash'))->result();
                                                    foreach ($loans_liblty as $loans_liblty) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $loans_liblty->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $loans_liblty->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $loans_liblty->particulars, 'status!=' => 'Trash'))->row();
                                                        $tot_cr += $cred->credit - $debit->debit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $loans_liblty->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit) ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    $bank = $this->db->select_sum('loan_amount')->get_where('replace_loans', array('date<=' => $to, 'status !=' => 'Trash'))->row();
                                                    $getloan = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('pymt_date<=' => $to, 'status !=' => 'Trash'))->row();
                                                    if (!empty($bankdetails)) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-left  bold-head"><b>Bank OD Account</b></td>
                                                            <td class="text-right"><b><?php echo moneyformat($bank->loan_amount - $getloan->loan_amt) ?></b></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    //$cb = 0;
                                                    foreach ($bankdetails as $bankdetail) {
                                                        $getname = $this->db->select('bank_name')->get_where('banks', array('bank_id' => $bankdetail->bank_name, 'status!=' => 'Trash'))->row();
                                                        $getloan = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('bank_name' => $getname->bank_name, 'pymt_date<=' => $to, 'status !=' => 'Trash'))->row();
                                                        // $cb = $cb + $bankdetail->loan_amount;
                                                        $tot_cr += $bankdetail->loan_amount - $getloan->loan_amt;
                                                        ?>
                                                        <tr>

                                                            <td class="text-left" ><a href="view_vch_details?id=<?php echo $bankdetail->bank_name; ?>"><?php echo $getname->bank_name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($bankdetail->loan_amount - $getloan->loan_amt) ?></td>
                                                        </tr> 
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    $cl_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Current Liabilities', 'status!=' => 'Trash'))->row();
                                                    $cl_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Current Liabilities', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Current Liabilities</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($cl_cr->credit - $cl_dr->debit) ?></b></td></tr>                             
                                                    <?php
                                                    $cur_liablty = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Current Liabilities', 'status!=' => 'Trash'))->result();
                                                    foreach ($cur_liablty as $cur_liablty) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $cur_liablty->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $cur_liablty->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $cur_liablty->particulars, 'status!=' => 'Trash'))->row();
                                                        $tot_cr += $cred->credit - $debit->debit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $cur_liablty->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php
                                                    $sc_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Sundry Creditors', 'status!=' => 'Trash'))->row();
                                                    $sc_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Sundry Creditors', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Sundry Creditors</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($sc_cr->credit - $sc_dr->debit) ?></b></td>
                                                    </tr>                               
                                                    <?php
                                                    $sundry_cr = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Sundry Creditors', 'status!=' => 'Trash'))->result();
                                                    foreach ($sundry_cr as $sundry_cr) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $sundry_cr->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $sundry_cr->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $sundry_cr->particulars, 'status!=' => 'Trash'))->row();
                                                        $tot_cr += $cred->credit - $debit->debit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $sundry_cr->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr><td class="text-left bold-head"><a href="loans_details?voucher_id=deposits"><b>Deposit Party(s)</b></a></td>
                                                        <td class="text-right"><b><?php echo moneyformat($dep->dep_amount); ?></b></td>
                                                    </tr>
                                                    <?php
                                                    $i_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Investments', 'status!=' => 'Trash'))->row();
                                                    $i_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Investments', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Investments</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($i_cr->credit - $i_dr->debit) ?></b></td></tr>                             
                                                    <?php
                                                    $investments = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Investments', 'status!=' => 'Trash'))->result();
                                                    foreach ($investments as $investments) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $investments->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $investments->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $investments->particulars, 'status!=' => 'Trash'))->row();
                                                        $tot_cr += $cred->credit - $debit->debit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $investments->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php
                                                    $sus_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Suspense Accounts', 'status!=' => 'Trash'))->row();
                                                    $sus_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Suspense Accounts', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Suspense Accounts</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($sus_cr->credit - $sus_dr->debit) ?></b></td></tr>                                
                                                    <?php
                                                    $suspense = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Suspense Accounts', 'status!=' => 'Trash'))->result();
                                                    foreach ($suspense as $suspense) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $suspense->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $suspense->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $suspense->particulars, 'status!=' => 'Trash'))->row();
                                                        $tot_cr += $cred->credit - $debit->debit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $suspense->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php if ($tot2 < $int2) { ?>
                                                        <tr>
                                                            <td class="text-left"><b><a href="profit_loss" >Gross Profit</a></b></td>
                                                            <td class="text-right">(GHS) <b><?php echo moneyformat($int2 - $tot2) ?></b></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <!--calculating total--> 
                                                    <?php ?><tr>
                                                        <td class="text-left"><b>Total</b></td><td class="text-right"> <b><?php echo moneyformat($tot_cr + $dep->dep_amount + $int2 - $tot2); ?></b></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="transactions-table trans-margin table-striped table-bordered tribal table-two" >
                                                <thead class="transactions-table-head">
                                                    <tr>
                                                        <th class="text-left">Assets</th>
                                                        <th class="text-right">Amount (GHS)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $ca_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Current Assets', 'status!=' => 'Trash'))->row();
                                                    $ca_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Current Assets', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Current Assets</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($ca_dr->debit - $ca_cr->credit) ?></b></td></tr>                             
                                                    <?php
                                                    $cur_assets = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Current Assets', 'status!=' => 'Trash'))->result();
                                                    foreach ($cur_assets as $cur_assets) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $cur_assets->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $cur_assets->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $cur_assets->particulars, 'status!=' => 'Trash'))->row();
                                                        // $tot_dr += $debit->debit - $cred->credit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $cur_assets->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($debit->debit - $cred->credit) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php
                                                    $la_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Loan & Advances', 'status!=' => 'Trash'))->row();
                                                    $la_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Loan & Advances', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Loan & Advances</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($la_dr->debit - $la_cr->credit) ?></b></td></tr>                                    
                                                    <?php
                                                    $loans_adv = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Loan & Advances', 'status!=' => 'Trash'))->result();
                                                    foreach ($loans_adv as $loans_adv) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $loans_adv->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $loans_adv->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $loans_adv->particulars, 'status!=' => 'Trash'))->row();
                                                        // $tot_dr += $debit->debit - $cred->credit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $loans_adv->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($debit->debit - $cred->credit) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php
                                                    $sd_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Sundry Debtors', 'status!=' => 'Trash'))->row();
                                                    $sd_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Sundry Debtors', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Sundry Debtors</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($sd_dr->debit - $sd_cr->credit) ?></b></td></tr>                            
                                                    <?php
                                                    $sund_dr = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date<=' => $to, 'under' => 'Sundry Debtors', 'status!=' => 'Trash'))->result();
                                                    foreach ($sund_dr as $sund_dr) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $sund_dr->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $sund_dr->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'particulars' => $sund_dr->particulars, 'status!=' => 'Trash'))->row();
                                                        //$tot_dr += $debit->debit - $cred->credit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $sund_dr->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($debit->debit - $cred->credit) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr><td class="text-left bold-head"><a href="loans_details?voucher_id=loans"><b>Loan Party(s) - JL</b></a></td> 
                                                        <td class="text-right"><b><?php echo moneyformat($loan->loan_amount - $loanrec->loan_amt); ?></b></td>
                                                    </tr>
                                                    <?php
                                                    $creditt = $debitt = 0;
                                                    $get = $this->db->select('*')->get_where('daybooks', array('status!=' => 'Trash'))->row();
                                                    $openbal = $get->closing_balance;
                                                    if ($to == '2019-03-31') {
                                                        $balance = $openbal;
                                                    } else {
                                                        $resultq = $this->db->select_sum('loan_amount')->get_where('loans', array('loan_date<=' => $to, 'loan_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $debitt += $resultq->loan_amount;
                                                        $resultq = $this->db->select_sum('loan_amount')->get_where('personal_loans', array('loan_date<=' => $to, 'loan_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $debitt += $resultq->loan_amount;
                                                        $resultq = $this->db->select_sum('loan_amt')->get_where('receipts', array('receipt_date<=' => $to, 'receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $creditt += $resultq->loan_amt;
                                                        $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('receipt_date<=' => $to, 'receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $creditt += $resultq->rcvd_int_amt;
                                                        $resultq = $this->db->select_sum('loan_amt')->get_where('personalloan_receipts', array('receipt_date<=' => $to, 'receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $creditt += $resultq->loan_amt;
                                                        $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('receipt_date<=' => $to, 'receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $creditt += $resultq->rcvd_int_amt;
                                                        $resultq = $this->db->select_sum('dep_amount')->get_where('deposits', array('dep_date<=' => $to, 'dep_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $creditt += $resultq->dep_amount;
                                                        $resultq = $this->db->select_sum('dep_amt')->get_where('deposit_payments', array('pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $creditt += $resultq->dep_amt;
                                                        $resultq = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $debitt += $resultq->paid_int_amt;
                                                        $resultq = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $debitt += $resultq->loan_amt;
                                                        $resultq = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $debitt += $resultq->paid_int_amt;
                                                        $resultq = $this->db->select_sum('loan_amount')->get_where('replace_loans', array('date<=' => $to, 'date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $creditt += $resultq->loan_amount;
                                                        $resultq = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date<=' => $to, 'date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $debitt += $resultq->other_amt;
                                                        $resultq = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $to, 'vch_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $debitt += $resultq->debit;
                                                        $resultq = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $to, 'vch_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                        $creditt += $resultq->credit;

                                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('receipts', array('receipt_date<=' => $to, 'receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                        $creditt += $details->add_less;
                                                        $details = $this->db->select_sum('add_less')->get_where('receipts', array('receipt_date<=' => $to, 'receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                        $debitt += -($details->add_less);

                                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date<=' => $to, 'receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                        $creditt += $details->add_less;
                                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date<=' => $to, 'receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                        $debitt += -($details->add_less);

                                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                        $debitt += $details->add_less;
                                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                        $creditt += -($details->add_less);

                                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                        $debitt += $details->add_less;
                                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                        $creditt += -($details->add_less);
                                                        $balance = $openbal + $creditt - $debitt;
                                                        //print_r($creditt);
                                                    }
                                                    ?>
                                                    <tr><td class="text-left"><a href="view_vch_details?voucher_id=cash_a/c"><b>Cash A/C</b></a></td>
                                                        <td class="text-right"><b><?php echo moneyformat($balance); ?></b></td>
                                                    </tr>


                                                    <?php
                                                    $int = $loanint[0]->rcvd_int_amt + $ploanint[0]->rcvd_int_amt + $getcinterest->credit;
                                                    $tot_dr = $ca_dr->debit - $ca_cr->credit + $la_dr->debit - $la_cr->credit + $sd_dr->debit - $sd_cr->credit + $loan->loan_amount - $loanrec->loan_amt + $balance;
                                                    ?>
                                                    <?php if ($tot2 > $int2) { ?>
                                                        <tr>
                                                            <td class="text-left"><b>Gross Loss(C/o)</b></td>
                                                            <td class="text-right"> <b><?php echo moneyformat($tot2 - $int2) ?></b></td>
                                                        </tr> <?php } ?>

                                                    <?php if ($tot2 > $int2) { ?>
                                                        <tr><td class="text-left"><b>Total</b></td><td class="text-right">(GHS) <?php echo moneyformat($tot_dr + $tot2 - $int2) ?></td></tr>
                                                    <?php } else { //print_r($total)   ?>
                                                        <tr><td class="text-left"><b>Total</b></td><td class="text-right">(GHS) <?php echo moneyformat($tot_dr) ?></td></tr>    
                                                    <?php } ?>
                                                </tbody> 
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <?php
                                $pl_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>' => '2019-03-31', 'under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->row();
                                $pl_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>' => '2019-03-31', 'under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->row();
                                ?>
                                <?php
                                $getdinterest = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>' => '2019-03-31', 'particulars' => "46", 'status != ' => 'Trash'))->row();
                                $getcinterest = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>' => '2019-03-31', 'particulars' => "48", 'status != ' => 'Trash'))->row();
                                $get_addless_adjustment_val = $this->db->select_sum('addless')->get_where('settings', array('status != ' => 'Trash'))->row();
                                $get_commision_adjustment_val = $this->db->select_sum('commision')->get_where('settings', array('status != ' => 'Trash'))->row();
                                $d_exp_tot2 = 0;
                                foreach ($detailss as $detail) {
                                    ?>
                                    <?php
                                    $vch_detail = $this->db->group_by('particulars')->select_sum('debit')->get_where('vouchers', array('vch_date>' => '2019-03-31', 'particulars' => $detail->particulars, 'status !=' => 'Trash'))->row();
                                    $d_exp_tot2 += $vch_detail->debit;
                                    ?>
                                    <?php
                                }
                                $c_ladd_less = $this->db->select_sum('add_less')->get_where('receipts', array('receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->result();
                                $c_pladd_less = $this->db->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->result();
                                $d_radd_less = $this->db->select_sum('add_less')->get_where('replace_payments', array('pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->result();
                                $d_dadd_less = $this->db->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->result();
                                $d_ladd_less = $this->db->select_sum('add_less')->get_where('receipts', array('receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->result();
                                $d_pladd_less = $this->db->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->result();
                                $c_radd_less = $this->db->select_sum('add_less')->get_where('replace_payments', array('pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->result();
                                $c_dadd_less = $this->db->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->result();
                                $addless = $get_addless_adjustment_val->addless - ($c_ladd_less[0]->add_less) - $c_pladd_less[0]->add_less - (-($c_radd_less[0]->add_less)) - (-($c_dadd_less[0]->add_less)) + $d_radd_less[0]->add_less + $d_dadd_less[0]->add_less + (-($d_ladd_less[0]->add_less)) + (-($d_pladd_less[0]->add_less));
                                if ($addless > 0) {
                                    $tot2 = $d_exp_tot2 + $commission[0]->other_amt + $get_commision_adjustment_val->commision + $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $getdinterest->debit + $pl_dr->debit - $pl_cr->credit;
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
                                <div class = "container-fluid">
                                    <div class = "row">
                                        <div class = "col-md-6">
                                            <table class = "transactions-table trans-margin table-striped table-bordered tribal table-one" >
                                                <thead class = "transactions-table-head">
                                                    <tr>
                                                        <th class = "text-left">Liabilities</th>
                                                        <th class = "text-right">Amount (GHS)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cr = $this->db->select_sum('credit')->get_where('vouchers', array( 'under' => 'Capital Account', 'status!=' => 'Trash'))->row();
                                                    $dr = $this->db->select_sum('debit')->get_where('vouchers', array( 'under' => 'Capital Account', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class = "text-left bold-head"><b>Capital Account</b>
                                                        <td class="text-right"><b><?php echo moneyformat($cr->credit - $dr->debit + $get_year_credit->credit - $get_year_debit->debit) ?></b></td></td>
                                                    </tr>
                                                    <?php
                                                    $get_capacc = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Capital Account', 'particulars!=' => '59', 'status!=' => 'Trash'))->result();
                                                    foreach ($get_capacc as $get_capacc) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $get_capacc->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $get_capacc->particulars, 'particulars!=' => '59', 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $get_capacc->particulars, 'particulars!=' => '59', 'status!=' => 'Trash'))->row();
                                                        $tot_cr += $cred->credit - $debit->debit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $get_capacc->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit) ?></td>
                                                        </tr>
                                                    <?php } ?> 
                                                    <?php
                                                    $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => '59', 'status!=' => 'Trash'))->row();
                                                    $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => '59', 'status!=' => 'Trash'))->row();
                                                    $tot_cr += $cred->credit - $debit->debit + $get_year_credit->credit - $get_year_debit->debit;
                                                    ?>
                                                    <tr>
                                                        <td class="text-left bold-head"><a href="view_vch_details?voucher_id=59">S. UNNAMALAI CURRENT ACCOUNT</a></td>
                                                        <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit + $get_year_credit->credit - $get_year_debit->debit) ?></td>
                                                    </tr>

                                                    <?php
                                                    $l_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Loans(Liability)', 'status!=' => 'Trash'))->row();
                                                    $l_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Loans(Liability)', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Loans(Liability)</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($l_cr->credit - $l_dr->debit) ?></b></td></tr>                                
                                                    <?php
                                                    $loans_liblty = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Loans(Liability)', 'status!=' => 'Trash'))->result();
                                                    foreach ($loans_liblty as $loans_liblty) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $loans_liblty->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $loans_liblty->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $loans_liblty->particulars, 'status!=' => 'Trash'))->row();
                                                        $tot_cr += $cred->credit - $debit->debit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $loans_liblty->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit) ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    $bank = $this->db->select_sum('loan_amount')->get_where('replace_loans', array('status !=' => 'Trash'))->row();
                                                    $getloan = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('status !=' => 'Trash'))->row();
                                                    if (!empty($bankdetails)) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-left  bold-head"><b>Bank OD Account</b></td>
                                                            <td class="text-right"><b><?php echo moneyformat($bank->loan_amount - $getloan->loan_amt) ?></b></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    //$cb = 0;
                                                    foreach ($bankdetails as $bankdetail) {
                                                        $getname = $this->db->select('bank_name')->get_where('banks', array('bank_id' => $bankdetail->bank_name, 'status!=' => 'Trash'))->row();
                                                        $getloan = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('bank_name' => $getname->bank_name, 'status !=' => 'Trash'))->row();
                                                        // $cb = $cb + $bankdetail->loan_amount;
                                                        $tot_cr += $bankdetail->loan_amount - $getloan->loan_amt;
                                                        ?>
                                                        <tr>

                                                            <td class="text-left" ><a href="view_vch_details?id=<?php echo $bankdetail->bank_name; ?>"><?php echo $getname->bank_name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($bankdetail->loan_amount - $getloan->loan_amt) ?></td>
                                                        </tr> 
                                                    <?php }
                                                    ?>
                                                    <?php
                                                    $cl_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Current Liabilities', 'status!=' => 'Trash'))->row();
                                                    $cl_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Current Liabilities', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Current Liabilities</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($cl_cr->credit - $cl_dr->debit) ?></b></td></tr>                                
                                                    <?php
                                                    $cur_liablty = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Current Liabilities', 'status!=' => 'Trash'))->result();
                                                    foreach ($cur_liablty as $cur_liablty) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $cur_liablty->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $cur_liablty->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $cur_liablty->particulars, 'status!=' => 'Trash'))->row();
                                                        $tot_cr += $cred->credit - $debit->debit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $cur_liablty->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php
                                                    $sc_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Sundry Creditors', 'status!=' => 'Trash'))->row();
                                                    $sc_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Sundry Creditors', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Sundry Creditors</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($sc_cr->credit - $sc_dr->debit) ?></b></td>
                                                    </tr>                                
                                                    <?php
                                                    $sundry_cr = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Sundry Creditors', 'status!=' => 'Trash'))->result();
                                                    foreach ($sundry_cr as $sundry_cr) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $sundry_cr->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $sundry_cr->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $sundry_cr->particulars, 'status!=' => 'Trash'))->row();
                                                        $tot_cr += $cred->credit - $debit->debit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $sundry_cr->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr><td class="text-left bold-head"><a href="loans_details?voucher_id=deposits"><b>Deposit Party(s)</b></a></td>
                                                        <td class="text-right"><b><?php echo moneyformat($dep->dep_amount); ?></b></td>
                                                    </tr>
                                                    <?php
                                                    $i_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Investments', 'status!=' => 'Trash'))->row();
                                                    $i_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Investments', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Investments</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($i_cr->credit - $i_dr->debit) ?></b></td></tr>                                
                                                    <?php
                                                    $investments = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Investments', 'status!=' => 'Trash'))->result();
                                                    foreach ($investments as $investments) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $investments->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $investments->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $investments->particulars, 'status!=' => 'Trash'))->row();
                                                        $tot_cr += $cred->credit - $debit->debit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $investments->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php
                                                    $sus_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Suspense Accounts', 'status!=' => 'Trash'))->row();
                                                    $sus_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Suspense Accounts', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Suspense Accounts</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($sus_cr->credit - $sus_dr->debit) ?></b></td></tr>                                
                                                    <?php
                                                    $suspense = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Suspense Accounts', 'status!=' => 'Trash'))->result();
                                                    foreach ($suspense as $suspense) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $suspense->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $suspense->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $suspense->particulars, 'status!=' => 'Trash'))->row();
                                                        $tot_cr += $cred->credit - $debit->debit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $suspense->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($cred->credit - $debit->debit) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php if ($tot2 < $int2) { ?>
                                                        <tr>
                                                            <td class="text-left"><b><a href="profit_loss" >Gross Profit</a></b></td>
                                                            <td class="text-right">(GHS) <b><?php echo moneyformat($int2 - $tot2) ?></b></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <!--calculating total--> 
                                                    <?php ?><tr>
                                                        <td class="text-left"><b>Total</b></td><td class="text-right"> <b><?php echo moneyformat($tot_cr + $dep->dep_amount + $int2 - $tot2); ?></b></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="transactions-table trans-margin table-striped table-bordered tribal table-two" >
                                                <thead class="transactions-table-head">
                                                    <tr>
                                                        <th class="text-left">Assets</th>
                                                        <th class="text-right">Amount (GHS)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <?php
                                                    $ca_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Current Assets', 'status!=' => 'Trash'))->row();
                                                    $ca_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Current Assets', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Current Assets</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($ca_dr->debit - $ca_cr->credit) ?></b></td></tr>                                
                                                    <?php
                                                    $cur_assets = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Current Assets', 'status!=' => 'Trash'))->result();
                                                    foreach ($cur_assets as $cur_assets) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $cur_assets->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $cur_assets->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $cur_assets->particulars, 'status!=' => 'Trash'))->row();
                                                        //$tot_dr += $debit->debit - $cred->credit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $cur_assets->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($debit->debit - $cred->credit) ?></td>
                                                        </tr>
                                                    <?php } ?>


                                                    <?php
                                                    $la_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Loan & Advances', 'status!=' => 'Trash'))->row();
                                                    $la_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Loan & Advances', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Loan & Advances</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($la_dr->debit - $la_cr->credit) ?></b></td></tr>                                
                                                    <?php
                                                    $loans_adv = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Loan & Advances', 'status!=' => 'Trash'))->result();
                                                    foreach ($loans_adv as $loans_adv) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $loans_adv->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $loans_adv->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $loans_adv->particulars, 'status!=' => 'Trash'))->row();
                                                        //$tot_dr += $debit->debit - $cred->credit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $loans_adv->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($debit->debit - $cred->credit) ?></td>
                                                        </tr>
                                                    <?php } ?>


                                                    <?php
                                                    $sd_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Sundry Debtors', 'status!=' => 'Trash'))->row();
                                                    $sd_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Sundry Debtors', 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <tr><td class="text-left bold-head"><b>Sundry Debtors</b></td>
                                                        <td class="text-right"><b><?php echo moneyformat($sd_dr->debit - $sd_cr->credit) ?></b></td></tr>                                
                                                    <?php
                                                    $sund_dr = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Sundry Debtors', 'status!=' => 'Trash'))->result();
                                                    foreach ($sund_dr as $sund_dr) {
                                                        $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $sund_dr->particulars, 'status!=' => 'Trash'))->row();
                                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $sund_dr->particulars, 'status!=' => 'Trash'))->row();
                                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $sund_dr->particulars, 'status!=' => 'Trash'))->row();
                                                        //$tot_dr += $debit->debit - $cred->credit;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $sund_dr->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                            <td class="text-right"><?php echo moneyformat($debit->debit - $cred->credit) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr><td class="text-left bold-head"><a href="loans_details?voucher_id=loans"><b>Loan Party(s)- JL</b></a></td> 
                                                        <td class="text-right"><b><?php echo moneyformat($loan->loan_amount - $loanrec->loan_amt); ?></b></td>
                                                    </tr>
                                                    <?php
                                                    $creditt = $debitt = 0;
                                                    $get = $this->db->select('*')->get_where('daybooks', array('status!=' => 'Trash'))->row();
                                                    $openbal = $get->closing_balance;

                                                    $resultq = $this->db->select_sum('loan_amount')->get_where('loans', array('loan_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->loan_amount;
                                                    $resultq = $this->db->select_sum('loan_amount')->get_where('personal_loans', array('loan_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->loan_amount;
                                                    $resultq = $this->db->select_sum('loan_amt')->get_where('receipts', array('receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->loan_amt;
                                                    $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->rcvd_int_amt;
                                                    $resultq = $this->db->select_sum('loan_amt')->get_where('personalloan_receipts', array('receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->loan_amt;
                                                    $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->rcvd_int_amt;
                                                    $resultq = $this->db->select_sum('dep_amount')->get_where('deposits', array('dep_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->dep_amount;
                                                    $resultq = $this->db->select_sum('dep_amt')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->dep_amt;
                                                    $resultq = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->paid_int_amt;
                                                    $resultq = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->loan_amt;
                                                    $resultq = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->paid_int_amt;
                                                    $resultq = $this->db->select_sum('loan_amount')->get_where('replace_loans', array('date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->loan_amount;
                                                    $resultq = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->other_amt;
                                                    $resultq = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->debit;
                                                    $resultq = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->credit;

                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('receipts', array('receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                    $creditt += $details->add_less;
                                                    $details = $this->db->select_sum('add_less')->get_where('receipts', array('receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                    $debitt += -($details->add_less);

                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                    $creditt += $details->add_less;
                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                    $debitt += -($details->add_less);

                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                    $debitt += $details->add_less;
                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                    $creditt += -($details->add_less);

                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                    $debitt += $details->add_less;
                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                    $creditt += -($details->add_less);
                                                    $balance = $openbal + $creditt - $debitt;
                                                    // print_r($balance);
                                                    ?>
                                                    <tr><td  class="text-left"><a href="view_vch_details?voucher_id=cash_a/c"><b>Cash A/C</b></a></td>
                                                        <td class="text-right"><b><?php echo moneyformat($balance); ?></b></td>
                                                    </tr>

                                                    <?php
                                                    $int = $loanint[0]->rcvd_int_amt + $ploanint[0]->rcvd_int_amt + $getcinterest->credit;

                                                    $tot_dr = $ca_dr->debit - $ca_cr->credit + $la_dr->debit - $la_cr->credit + $sd_dr->debit - $sd_cr->credit + $loan->loan_amount - $loanrec->loan_amt + $balance;
                                                    ?>
                                                    <?php if ($tot2 > $int2) { ?>
                                                        <tr>
                                                            <td class="text-left"><b>Gross Loss(C/o)</b></td>
                                                            <td class="text-right"> <b><?php echo moneyformat($tot2 - $int2) ?></b></td>
                                                        </tr> <?php } ?>
    <?php if ($tot2 > $int2) { ?>
                                                        <tr><td class="text-left"><b>Total</b></td><td class="text-right">(GHS) <?php echo moneyformat($tot_dr + $tot2 - $int2) ?></td></tr>
                                                    <?php } else { //print_r($total)  ?>
                                                        <tr><td class="text-left"><b>Total</b></td><td class="text-right">(GHS) <?php echo moneyformat($tot_dr) ?></td></tr>    
                                                    <?php } ?>
                                                </tbody> 
                                            </table>
                                        </div>
                                    </div>
                                </div>
<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /2 columns form -->
<style>
    .transactions-table td {
        border:none !important;
    }
</style>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = '<h2>Kundrakudian Finance</h2><h6>540, South car street ,</h6><h6>Kundrakudi .</h6><h6 class="text-right" style="position:absolute; top:50px;right:0;"><b>From</b> :  <?php echo (!empty($from)) ? $from : "01-04-2018" ?> ,<b>To</b> :  <?php echo (!empty($to)) ? $to : date('d-m-Y'); ?></h6><br><h5 class="text-right" style="position:absolute; top:80px;right:0;font-size:10px"><b>Print Date</b> :  <?php echo date('d-m-Y') ?></h5><h3 class="text-center">Balance Sheet</h3><table style="width:100% !important;border:1px solid #ddd;padding:10px;">' + document.getElementById(divName).innerHTML + '</table>';
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
