<?php
$from = $this->input->get('from');
$to = $this->input->get('to');
$get_addless_adjustment_val = $this->db->select_sum('addless')->get_where('settings', array('status != ' => 'Trash'))->row();
$get_commision_adjustment_val = $this->db->select_sum('commision')->get_where('settings', array('status != ' => 'Trash'))->row();
$get_year_credit = $this->db->select_sum('credit')->get_where('settings', array('status != ' => 'Trash'))->row();
$get_year_debit = $this->db->select_sum('debit')->get_where('settings', array('status != ' => 'Trash'))->row();
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
                <li class="active">Trial Balance</li>
            </ul>
            <input type="button" onclick="printDiv('example4')" class="button-style-2 submit-btn print" value="Print"/>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <form action="<?php echo base_url('admin/trialbalance_search') ?>" method="get" id="search" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12" style="float:right">
                            <div class="form-group daybk-date">
                                <label class="col-md-offset-4 col-lg-2 col-xs-6 control-label"><b>From date</b><span> :</span></label> 
                                <div class="col-lg-2 col-xs-6"> 
                                    <div class="class input-group date">
                                        <input id="from_date"  class="form-control datepicker" data-date-format="yyyy-mm-dd" type="text" name="from" value="<?php echo $from ?>"  >                                       
                                    </div>
                                </div>
                                <label class="col-lg-1 col-xs-6 control-label"><b>To date</b><span> :</span></label> 
                                <div class="col-lg-2 col-xs-6"> 
                                    <div class="class input-group date">
                                        <input id="to_date"  class="form-control datepicker" data-date-format="yyyy-mm-dd"  type="text" name="to" value="<?php echo $to ?>" >                                       
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
                        <div class="trans-table-display">
                            <!-- <div class="trans-table">-->
                            <table class="transactions-table trans-margin table-striped table-bordered dataTable tribal" id="example4">
                                <style type="text/css">
                                    @media print {

                                        tr{
                                            border:1px solid #ccc;
                                        }
                                        a[href]:after {
                                            content: none !important;
                                        }
                                        .hidden-print {
                                            display:none;
                                        }
                                        td {
                                            border: 1px solid #bad8b0 !important;
                                            font-size: 11px;
                                        }
                                    }
                                </style>
                                <thead class="transactions-table-head">
                                    <tr>
                                        <th class="text-left">Particulars</th>
                                        <th class="text-right">Open Bal ( GHS )</th>
                                        <th class="text-right" style="width: 16%;">Credit ( GHS )</th>
                                        <th class="text-right" style="width: 13%;">Debit ( GHS )</th>
                                    </tr>
                                </thead>
                                <?php if (!empty($from) || (!empty($to))) { ?>
                                    <tbody>
                                        <?php
                                        $tot_cr = 0;
                                        $cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Capital Account', 'status!=' => 'Trash'))->row();
                                        $dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Capital Account', 'status!=' => 'Trash'))->row();
                                        ?>

                                        <tr><td colspan="2" class = "text-left bold-head"><b>Capital Account</b>
                                            <td class="text-right"><b><?php echo moneyformat($cr->credit + $get_year_credit->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($dr->debit + $get_year_debit->debit) ?></b></td>
                                        </tr>                              
                                        <?php
                                        $get_capacc = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Capital Account', 'particulars!=' => '59', 'status!=' => 'Trash'))->result();
                                        foreach ($get_capacc as $get_capacc) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $get_capacc->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $get_capacc->particulars, 'particulars!=' => '59', 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $get_capacc->particulars, 'particulars!=' => '59', 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            $tot_cr += $cred->credit;
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $get_capacc->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => '59', 'status!=' => 'Trash'))->row();
                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => '59', 'status!=' => 'Trash'))->row();
                                        if ($cred->credit < $debit->debit) {
                                            $cp_openbal = $debit->debit - $cred->credit + $get_year_credit->credit - $get_year_debit->debit;
                                        } else {
                                            $cp_openbal = $cred->credit - $debit->debit + $get_year_credit->credit - $get_year_debit->debit;
                                        }
                                        $tot_cr += $cred->credit + $get_year_credit->credit;
                                        ?>
                                        <tr>
                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=59">S. UNNAMALAI CURRENT ACCOUNT</a></td>
                                            <?php if ($cred->credit < $debit->debit) { ?>
                                                <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                            <?php } else { ?>
                                                <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                            <?php } ?>
                                            <td class="text-right"><?php echo moneyformat($cred->credit + $get_year_credit->credit) ?></td>
                                            <td class="text-right"><?php echo moneyformat($debit->debit + $get_year_debit->debit) ?></td>
                                        </tr>
                                        <?php
                                        $l_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Loans(Liability)', 'status!=' => 'Trash'))->row();
                                        $l_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Loans(Liability)', 'status!=' => 'Trash'))->row();
                                        ?>

                                        <tr><td colspan="2" class="text-left bold-head"><b>Loans(Liability)</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($l_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($l_dr->debit) ?></b></td></tr>                                
                                        <?php
                                        $loans_liblty = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Loans(Liability)', 'status!=' => 'Trash'))->result();
                                        foreach ($loans_liblty as $loans_liblty) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $loans_liblty->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $loans_liblty->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $loans_liblty->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            $tot_cr += $cred->credit;
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $loans_liblty->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                            <?php
                                        }

                                        $bank = $this->db->select_sum('loan_amount')->get_where('replace_loans', array('date<=' => $to, 'status !=' => 'Trash'))->row();
                                        $getloan = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('pymt_date<=' => $to, 'status !=' => 'Trash'))->row();
                                        //print_r($getloan)
                                        if (!empty($bankdetails)) {
                                            ?>
                                            <tr>
                                                <td colspan="2" class="text-left  bold-head"><b>Bank OD Account</b></td>
                                                <td class="text-right"><b><?php echo moneyformat($bank->loan_amount - $getloan->loan_amt) ?></b></td><td></td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                        foreach ($bankdetails as $bankdetail) {
                                            $getname = $this->db->select('bank_name')->get_where('banks', array('bank_id' => $bankdetail->bank_name, 'status!=' => 'Trash'))->row();
                                            $getloanamt = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('bank_name' => $getname->bank_name, 'pymt_date<=' => $to, 'status !=' => 'Trash'))->row();
                                            $tot_cr += $bankdetail->loan_amount - $getloanamt->loan_amt;
                                            ?>
                                            <tr>

                                                <td class="text-left" ><a href="view_vch_details?id=<?php echo $bankdetail->bank_name; ?>"><?php echo $getname->bank_name ?></a></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"><?php echo moneyformat($bankdetail->loan_amount - $getloanamt->loan_amt) ?></td>
                                                <td class="text-right"></td>
                                            </tr> 
                                        <?php }
                                        ?>
                                        <?php
                                        $cl_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Current Liabilities', 'status!=' => 'Trash'))->row();
                                        $cl_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Current Liabilities', 'status!=' => 'Trash'))->row();
                                        ?>

                                        <tr><td colspan="2" class="text-left bold-head"><b>Current Liabilities</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($cl_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($cl_dr->debit) ?></b></td>
                                        </tr>                                
                                        <?php
                                        $cur_liablty = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Current Liabilities', 'status!=' => 'Trash'))->result();
                                        foreach ($cur_liablty as $cur_liablty) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $cur_liablty->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $cur_liablty->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $cur_liablty->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            $tot_cr += $cred->credit;
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $cur_liablty->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>

                                        <?php
                                        $sc_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Sundry Creditors', 'status!=' => 'Trash'))->row();
                                        $sc_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Sundry Creditors', 'status!=' => 'Trash'))->row();
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Sundry Creditors</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($sc_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($sc_dr->debit) ?></b></td>
                                        </tr>                                
                                        <?php
                                        $sundry_cr = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Sundry Creditors', 'status!=' => 'Trash'))->result();
                                        foreach ($sundry_cr as $sundry_cr) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $sundry_cr->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $sundry_cr->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $sundry_cr->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            $tot_cr += $cred->credit;
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $sundry_cr->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>

                                        <tr><td colspan="2" class="text-left bold-head"><a href="loans_details?voucher_id=deposits"><b>Deposit Party(s)</b></a></td>
                                            <td class="text-right"><b><?php echo moneyformat($dep->dep_amount); ?></b></td><td>
                                            </td>
                                        </tr>
                                        <?php $tot_cr += $dep->dep_amount; ?>
                                        <?php
                                        $i_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Investments', 'status!=' => 'Trash'))->row();
                                        $i_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Investments', 'status!=' => 'Trash'))->row();
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Investments</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($i_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($i_dr->debit) ?></b></td>
                                        </tr>                                
                                        <?php
                                        $investments = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Investments', 'status!=' => 'Trash'))->result();
                                        foreach ($investments as $investments) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $investments->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $investments->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $investments->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            $tot_cr += $cred->credit;
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $investments->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>  <?php
                                        $ca_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Current Assets', 'status!=' => 'Trash'))->row();
                                        $ca_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Current Assets', 'status!=' => 'Trash'))->row();
                                        ?>

                                        <tr><td colspan="2" class="text-left bold-head"><b>Current Assets</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($ca_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($ca_dr->debit) ?></b></td>
                                        </tr>                                
                                        <?php
                                        $cur_assets = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Current Assets', 'status!=' => 'Trash'))->result();
                                        foreach ($cur_assets as $cur_assets) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $cur_assets->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $cur_assets->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $cur_assets->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            $tot_cr += $cred->credit;
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $cur_assets->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                        $la_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Loan & Advances', 'status!=' => 'Trash'))->row();
                                        $la_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Loan & Advances', 'status!=' => 'Trash'))->row();
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Loan & Advances</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($la_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($la_dr->debit) ?></b></td>
                                        </tr>                                
                                        <?php
                                        $loans_adv = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Loan & Advances', 'status!=' => 'Trash'))->result();
                                        foreach ($loans_adv as $loans_adv) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $loans_adv->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $loans_adv->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $loans_adv->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            $tot_cr += $cred->credit;
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $loans_adv->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                        $sd_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Sundry Debtors', 'status!=' => 'Trash'))->row();
                                        $sd_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Sundry Debtors', 'status!=' => 'Trash'))->row();
                                        ?>   
                                        <tr><td colspan="2" class="text-left bold-head"><b>Sundry Debtors</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($sd_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($sd_dr->debit) ?></b></td>
                                        </tr>                                
                                        <?php
                                        $sund_dr = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Sundry Debtors', 'status!=' => 'Trash'))->result();
                                        foreach ($sund_dr as $sund_dr) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $sund_dr->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $sund_dr->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $sund_dr->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            $tot_cr += $cred->credit;
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $sund_dr->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>

                                        <tr><td colspan="3" class="text-left bold-head"><b><a href="loans_details?voucher_id=loans">Loans</a></b></td>          
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
                                        <?php if ($balance > 0) { ?>
                                            <tr><td colspan="3" class="text-left"><a href="view_vch_details?voucher_id=cash_a/c"><b>Cash A/C</b></a></td>
                                                <td class="text-right"><b><?php echo moneyformat($balance); ?></b></td>
                                            </tr>
                                        <?php } else { ?>
                                            <tr><td class="text-left"><a href="view_vch_details?voucher_id=cash_a/c"><b>Cash A/C</b></a></td><td></td>
                                                <td class="text-right"><b><?php echo moneyformat($balance); ?></b></td>
                                            </tr>
                                        <?php } ?>

                                        <?php
                                        $msc_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Misc.Expenses(Assets)', 'status!=' => 'Trash'))->row();
                                        $msc_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Misc.Expenses(Assets)', 'status!=' => 'Trash'))->row();
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Misc.Expenses(Assets)</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($msc_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($msc_dr->debit) ?></b></td>
                                        </tr>                                
                                        <?php
                                        $misc_exps = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Misc.Expenses(Assets)', 'status!=' => 'Trash'))->result();
                                        foreach ($misc_exps as $misc_exps) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $misc_exps->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $misc_exps->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $misc_exps->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            $tot_cr += $cred->credit;
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $misc_exps->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                        $susp_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Suspense Accounts', 'status!=' => 'Trash'))->row();
                                        $susp_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Suspense Accounts', 'status!=' => 'Trash'))->row();
                                        ?>

                                        <tr><td colspan="2" class="text-left bold-head"><b>Suspense Accounts</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($susp_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($susp_dr->debit) ?></b></td>
                                        </tr>                                
                                        <?php
                                        $suspense = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'under' => 'Suspense Accounts', 'status!=' => 'Trash'))->result();
                                        foreach ($suspense as $suspense) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $suspense->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $suspense->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'particulars' => $suspense->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            $tot_cr += $cred->credit;
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $suspense->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>

                                        <?php
                                        $pl_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'vch_date>'=>'2019-03-31', 'under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->row();
                                        $pl_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'vch_date>'=>'2019-03-31', 'under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->row();
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Profit & Loss A/c</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($pl_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($pl_dr->debit) ?></b></td>
                                        </tr> <?php
                                        $prfloss = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'vch_date>'=>'2019-03-31', 'under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->result();
                                        foreach ($prfloss as $prfloss) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $prfloss->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'vch_date>'=>'2019-03-31', 'particulars' => $prfloss->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'vch_date>'=>'2019-03-31', 'particulars' => $prfloss->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            $tot_cr += $cred->credit;
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $prfloss->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php }
                                        ?>
                                        <?php
                                        $credit = $deb = 0;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('receipts', array('receipt_date>=' => $from, 'receipt_date<=' => $to, 'receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                        $credit += $details->add_less;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('receipts', array('receipt_date>=' => $from, 'receipt_date<=' => $to, 'receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                        $deb += -($details->add_less);

                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date>=' => $from, 'receipt_date<=' => $to, 'receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                        $credit += $details->add_less;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date>=' => $from, 'receipt_date<=' => $to, 'receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                        $deb += -($details->add_less);

                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date>=' => $from, 'pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                        $deb += $details->add_less;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date>=' => $from, 'pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                        $credit += -($details->add_less);

                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>=' => $from, 'pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                        $deb += $details->add_less;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>=' => $from, 'pymt_date<=' => $to, 'pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                        $credit += -($details->add_less);
                                        ?>
                                        <?php
                                        $getinterest = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'vch_date>'=>'2019-03-31', 'particulars' => "48", 'status != ' => 'Trash'))->row();
                                        $int = $loanint[0]->rcvd_int_amt + $ploanint[0]->rcvd_int_amt + $getinterest->credit;
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Direct Incomes</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($int + $credit) ?></b></td><td class="text-right"><b><?php echo moneyformat($deb) ?></b></td>
                                        </tr> 
                                        <tr>
                                            <td colspan="2" class="text-left"><a href="profit_loss_detail?voucher_id=Add/Less">Add/Less</a></td>
                                            <td class="text-right"><?php echo moneyformat($credit) ?></td><td class="text-right"><?php echo moneyformat($deb) ?></td>
                                        </tr> 
                                        <tr>
                                            <td colspan="2" class="text-left"><a href="view_vch_details?voucher_id=Interest Received">Interest Received</a></td>
                                            <td class="text-right"><?php echo moneyformat($int); ?></td><td ></td>
                                        </tr>
                                        <?php
                                        $dexp_cr = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'vch_date>'=> '2019-03-31', 'under' => 'Direct Expenses', 'particulars !=' => '46', 'status!=' => 'Trash'))->row();
                                        $dexp_dr = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'vch_date>'=> '2019-03-31', 'under' => 'Direct Expenses', 'particulars !=' => '46', 'status!=' => 'Trash'))->row();
                                        ?>
                                        <?php
                                        $getinterest = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from,'vch_date>'=>'2019-03-31','vch_date<=' => $to, 'particulars' => "46", 'status != ' => 'Trash'))->row();
                                        $intpaid = $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $getinterest->debit;
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Direct Expenses</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($dexp_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($dexp_dr->debit + $intpaid + $commission[0]->other_amt) ?></b></td>
                                        </tr>                                
                                        <?php
                                        $dir_exp = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('vch_date<=' => $to, 'vch_date>'=>'2019-03-31', 'under' => 'Direct Expenses', 'particulars !=' => '46', 'status!=' => 'Trash'))->result();
                                        foreach ($dir_exp as $dir_exp) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $dir_exp->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'vch_date>'=>'2019-03-31', 'particulars' => $dir_exp->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>=' => $from, 'vch_date<=' => $to, 'vch_date>'=>'2019-03-31', 'particulars' => $dir_exp->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $dir_exp->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>

                                        <tr>

                                            <td colspan="3" class="text-left"><a href="view_vch_details?voucher_id=Interest Paid">Interest Paid</a></td>
                                            <td class="text-right"><?php echo moneyformat($intpaid); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-left"><a href="profit_loss_detail?voucher_id=Commission Paid to Bank">Commission Paid to Bank</a></td>
                                            <td colspan="3" class="text-right"><?php echo moneyformat($commission[0]->other_amt) ?></td>
                                        </tr>




                                        <?php
//                                      
                                        $bankdetails = $this->db->select_sum('loan_amount')->get_where('replace_loans', array('date>=' => $from, 'date<=' => $to, 'status !=' => 'Trash'))->row();
                                        $getbloanamt = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('pymt_date>=' => $from, 'pymt_date<=' => $to, 'status !=' => 'Trash'))->row();
                                        $cr_total = $cr->credit + $get_year_credit->credit + $l_cr->credit + $bankdetails->loan_amount - $getbloanamt->loan_amt + $cl_cr->credit + $sc_cr->credit + $dep->dep_amount + $i_cr->credit + $ca_cr->credit + $la_cr->credit + $sd_cr->credit + $msc_cr->credit + $susp_cr->credit + $pl_cr->credit + $int + $credit;
                                        $dr_total = $dr->debit +$get_year_debit->debit + $l_dr->debit + $cl_dr->debit + $sc_dr->debit + $i_dr->debit + $ca_dr->debit + $la_dr->debit + $sd_dr->debit + $loan->loan_amount - $loanrec->loan_amt + $balance + $msc_dr->debit + $susp_dr->debit + $pl_dr->debit + $deb + $dexp_dr->debit + $intpaid + $commission[0]->other_amt;
                                        //$get_year_debit->debit + $balance + $deb + $vch_dr + $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $loan->loan_amount - $loanrec->loan_amt + $commission[0]->other_amt;
//                                        if ($addless_tot < 0) {
//                                            $cr_total = $addless_tot + $vch_cr_tot->credit  + $dep->dep_amount + $loanint[0]->rcvd_int_amt + $ploanint[0]->rcvd_int_amt + $bankdetails->loan_amount + $cash_amt;
//                                            $dr_total = $deb + $vch_dr_tot->debit + $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $loan->loan_amount  + $get_commision_adjustment_val->commision + $commission[0]->other_amt;
//                                        } else {
//                                            $cr_total = $vch_cr_tot->credit  + $dep->dep_amount + $loanint[0]->rcvd_int_amt + $ploanint[0]->rcvd_int_amt + $bankdetails->loan_amount;
//                                            $dr_total = $addless_tot + $deb + $cash_amt + $vch_dr_tot->debit + $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $loan->loan_amount  + $get_commision_adjustment_val->commision + $commission[0]->other_amt;
//                                        }
                                        ?><tr><td colspan="2" class="text-left bold-head"><b>Total</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($cr_total) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($dr_total) ?></b></td>
                                        </tr>    




                                    </tbody>
                                <?php } else { ?>
                                    <tbody>
                                        <?php
                                        $cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Capital Account', 'status!=' => 'Trash'))->row();
                                        $dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Capital Account', 'status!=' => 'Trash'))->row();
                                        ?>

                                        <tr><td colspan="2" class = "text-left bold-head"><b>Capital Account</b>
                                            <td class="text-right"><b><?php echo moneyformat($cr->credit + $get_year_credit->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($dr->debit + $get_year_debit->debit) ?></b></td>
                                        </tr>                              
                                        <?php
                                        $get_capacc = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Capital Account', 'particulars!=' => '59', 'status!=' => 'Trash'))->result();
                                        foreach ($get_capacc as $get_capacc) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $get_capacc->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $get_capacc->particulars, 'particulars!=' => '59', 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $get_capacc->particulars, 'particulars!=' => '59', 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $get_capacc->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                        $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => '59', 'status!=' => 'Trash'))->row();
                                        $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => '59', 'status!=' => 'Trash'))->row();
                                        if ($cred->credit < $debit->debit) {
                                            $cp_openbal = $debit->debit - $cred->credit + $get_year_credit->credit - $get_year_debit->debit;
                                        } else {
                                            $cp_openbal = $cred->credit - $debit->debit + $get_year_credit->credit - $get_year_debit->debit;
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-left bold-head"><a href="view_vch_details?voucher_id=59">S. UNNAMALAI CURRENT ACCOUNT</a></td>
                                            <?php if ($cred->credit < $debit->debit) { ?>
                                                <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                            <?php } else { ?>
                                                <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                            <?php } ?>
                                            <td class="text-right"><?php echo moneyformat($cred->credit + $get_year_credit->credit) ?></td>
                                            <td class="text-right"><?php echo moneyformat($debit->debit + $get_year_debit->debit) ?></td>
                                        </tr>

                                        <?php
                                        $l_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Loans(Liability)', 'status!=' => 'Trash'))->row();
                                        $l_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Loans(Liability)', 'status!=' => 'Trash'))->row();
                                        ?>

                                        <tr><td colspan="2" class="text-left bold-head"><b>Loans(Liability)</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($l_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($l_dr->debit) ?></b></td></tr>                                  
                                        <?php
                                        $loans_liblty = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Loans(Liability)', 'status!=' => 'Trash'))->result();
                                        foreach ($loans_liblty as $loans_liblty) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $loans_liblty->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $loans_liblty->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $loans_liblty->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $loans_liblty->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                            <?php
                                        }
                                        $bank = $this->db->select_sum('loan_amount')->get_where('replace_loans', array('status !=' => 'Trash'))->row();
                                        $getloan = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('status !=' => 'Trash'))->row();
                                        if (!empty($bankdetails)) {
                                            ?>
                                            <tr>
                                                <td colspan="2" class="text-left  bold-head"><b>Bank OD Account</b></td>
                                                <td class="text-right"><b><?php echo moneyformat($bank->loan_amount - $getloan->loan_amt) ?></b></td><td></td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                        foreach ($bankdetails as $bankdetail) {
                                            $getname = $this->db->select('bank_name')->get_where('banks', array('bank_id' => $bankdetail->bank_name, 'status!=' => 'Trash'))->row();
                                            $getloanamt = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('bank_name' => $getname->bank_name, 'status !=' => 'Trash'))->row();
                                            ?>
                                            <tr>

                                                <td class="text-left" ><a href="view_vch_details?id=<?php echo $bankdetail->bank_name; ?>"><?php echo $getname->bank_name ?></a></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"><?php echo moneyformat($bankdetail->loan_amount - $getloanamt->loan_amt) ?></td>
                                                <td class="text-right"></td>
                                            </tr> 
                                        <?php }
                                        ?>
                                        <?php
                                        $cl_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Current Liabilities', 'status!=' => 'Trash'))->row();
                                        $cl_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Current Liabilities', 'status!=' => 'Trash'))->row();
                                        ?>

                                        <tr><td colspan="2" class="text-left bold-head"><b>Current Liabilities</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($cl_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($cl_dr->debit) ?></b></td>
                                        </tr>                                  
                                        <?php
                                        $cur_liablty = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Current Liabilities', 'status!=' => 'Trash'))->result();
                                        foreach ($cur_liablty as $cur_liablty) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $cur_liablty->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $cur_liablty->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $cur_liablty->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $cur_liablty->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                        $sc_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Sundry Creditors', 'status!=' => 'Trash'))->row();
                                        $sc_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Sundry Creditors', 'status!=' => 'Trash'))->row();
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Sundry Creditors</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($sc_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($sc_dr->debit) ?></b></td>
                                        </tr>                                
                                        <?php
                                        $sundry_cr = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Sundry Creditors', 'status!=' => 'Trash'))->result();
                                        foreach ($sundry_cr as $sundry_cr) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $sundry_cr->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $sundry_cr->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $sundry_cr->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $sundry_cr->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>

                                        <tr><td colspan="2" class="text-left bold-head"><a href="loans_details?voucher_id=deposits"><b>Deposit Party(s)</b></a></td>
                                            <td class="text-right"><b><?php echo moneyformat($dep->dep_amount); ?></b></td><td>
                                            </td>
                                        </tr>
                                        <?php
                                        $i_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Investments', 'status!=' => 'Trash'))->row();
                                        $i_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Investments', 'status!=' => 'Trash'))->row();
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Investments</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($i_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($i_dr->debit) ?></b></td>
                                        </tr>                                
                                        <?php
                                        $investments = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Investments', 'status!=' => 'Trash'))->result();
                                        foreach ($investments as $investments) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $investments->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $investments->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $investments->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $investments->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>

                                        <?php
                                        $ca_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Current Assets', 'status!=' => 'Trash'))->row();
                                        $ca_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Current Assets', 'status!=' => 'Trash'))->row();
                                        ?>

                                        <tr><td colspan="2" class="text-left bold-head"><b>Current Assets</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($ca_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($ca_dr->debit) ?></b></td>
                                        </tr>                                  
                                        <?php
                                        $cur_assets = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Current Assets', 'status!=' => 'Trash'))->result();
                                        foreach ($cur_assets as $cur_assets) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $cur_assets->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $cur_assets->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $cur_assets->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $cur_assets->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>

                                        <?php
                                        $la_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Loan & Advances', 'status!=' => 'Trash'))->row();
                                        $la_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Loan & Advances', 'status!=' => 'Trash'))->row();
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Loan & Advances</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($la_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($la_dr->debit) ?></b></td>
                                        </tr>                                   
                                        <?php
                                        $loans_adv = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Loan & Advances', 'status!=' => 'Trash'))->result();
                                        foreach ($loans_adv as $loans_adv) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $loans_adv->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $loans_adv->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $loans_adv->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $loans_adv->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                        $sd_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Sundry Debtors', 'status!=' => 'Trash'))->row();
                                        $sd_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Sundry Debtors', 'status!=' => 'Trash'))->row();
                                        ?>   
                                        <tr><td colspan="2" class="text-left bold-head"><b>Sundry Debtors</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($sd_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($sd_dr->debit) ?></b></td>
                                        </tr>                                 
                                        <?php
                                        $sund_dr = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Sundry Debtors', 'status!=' => 'Trash'))->result();
                                        foreach ($sund_dr as $sund_dr) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $sund_dr->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $sund_dr->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $sund_dr->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $sund_dr->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                            <?php
                                        } $loans = $this->db->select('loan_amount')->select_sum('loan_amount')->get_where('loans', array('status !=' => 'Trash'))->row();
                                        $loanrecpt = $this->db->select_sum('loan_amt')->get_where('receipts', array('status !=' => 'Trash'))->row();
                                        ?>

                                        <tr><td colspan="3" class="text-left bold-head"><b><a href="loans_details?voucher_id=loans">Loans</a></b></td>         
                                          <!--<td class="text-right"><?php echo moneyformat($loanrec->loan_amt); ?></td>-->
                                            <td class="text-right"><b><?php echo moneyformat($loans->loan_amount - $loanrecpt->loan_amt); ?></b></td>
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
                                        <?php if ($balance > 0) { ?>
                                            <tr><td colspan="3" class="text-left"><a href="view_vch_details?voucher_id=cash_a/c"><b>Cash A/C</b></a></td>
                                                <td class="text-right"><b><?php echo moneyformat($balance); ?></b></td>
                                            </tr>
                                        <?php } else { ?>
                                            <tr><td  class="text-left"><a href="view_vch_details?voucher_id=cash_a/c"><b>Cash A/C</b></a></td><td></td>
                                                <td class="text-right"><b><?php echo moneyformat($balance); ?></b></td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                        $msc_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Misc.Expenses(Assets)', 'status!=' => 'Trash'))->row();
                                        $msc_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Misc.Expenses(Assets)', 'status!=' => 'Trash'))->row();
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Misc.Expenses(Assets)</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($msc_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($msc_dr->debit) ?></b></td>
                                        </tr>                                  
                                        <?php
                                        $misc_exps = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Misc.Expenses(Assets)', 'status!=' => 'Trash'))->result();
                                        foreach ($misc_exps as $misc_exps) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $misc_exps->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $misc_exps->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $misc_exps->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $misc_exps->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>

                                        <?php
                                        $susp_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Suspense Accounts', 'status!=' => 'Trash'))->row();
                                        $susp_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Suspense Accounts', 'status!=' => 'Trash'))->row();
                                        ?>

                                        <tr><td colspan="2" class="text-left bold-head"><b>Suspense Accounts</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($susp_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($susp_dr->debit) ?></b></td>
                                        </tr>                                
                                        <?php
                                        $suspense = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Suspense Accounts', 'status!=' => 'Trash'))->result();
                                        foreach ($suspense as $suspense) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $suspense->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $suspense->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $suspense->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $suspense->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                        $prfloss = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->result();
                                        foreach ($prfloss as $prfloss) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $prfloss->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $prfloss->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $prfloss->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $prfloss->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php }
                                        ?>

                                        <?php
                                        $getrint = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date>' => '2019-03-31', 'particulars' => "48", 'status != ' => 'Trash'))->row();
                                        $loaninterest = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('receipt_date>' => '2019-03-31', 'status !=' => 'Trash'))->row();
                                        $ploaninterest = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('receipt_date>' => '2019-03-31', 'status !=' => 'Trash'))->row();
                                        $int = $loaninterest->rcvd_int_amt + $ploaninterest->rcvd_int_amt + $getrint->credit;
                                        ?>
                                        <?php
                                        $credit = $deb = 0;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('receipts', array('receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                        $credit += $details->add_less;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('receipts', array('receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                        $deb += -($details->add_less);

                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                        $credit += $details->add_less;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                        $deb += -($details->add_less);

                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                        $deb += $details->add_less;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                        $credit += -($details->add_less);

                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                        $deb += $details->add_less;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                        $credit += -($details->add_less);
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Direct Incomes</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($int + $credit - $get_addless_adjustment_val->addless) ?></b></td><td class="text-right"><b><?php echo moneyformat($deb) ?></b></td>
                                        </tr>  
                                        <tr>
                                            <td colspan="2" class="text-left"><a href="profit_loss_detail?voucher_id=Add/Less">Add/Less</a></td>
                                            <td class="text-right"><?php echo moneyformat($credit - $get_addless_adjustment_val->addless) ?></td><td class="text-right"><?php echo moneyformat($deb) ?></b></td>
                                        </tr> 
                                        <tr>
                                            <td colspan="2" class="text-left"><a href="view_vch_details?voucher_id=Interest Received">Interest Received</a></td>
                                            <td class="text-right"<?php echo moneyformat($int); ?></td><td ></td>
                                        </tr>

                                        <?php
                                        $dexp_cr = $this->db->select_sum('credit')->get_where('vouchers', array('particulars !=' => '46', 'under' => 'Direct Expenses', 'status!=' => 'Trash'))->row();
                                        $dexp_dr = $this->db->select_sum('debit')->get_where('vouchers', array('particulars !=' => '46', 'under' => 'Direct Expenses', 'status!=' => 'Trash'))->row();
                                        ?>
                                        <?php
                                        $getint = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date>' => '2019-03-31', 'particulars' => "46", 'status != ' => 'Trash'))->row();
                                        $paidinterest = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date>' => '2019-03-31', 'status !=' => 'Trash'))->row();
                                        $paiddepinterest = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('pymt_date>' => '2019-03-31', 'status !=' => 'Trash'))->row();
                                        $intpaid = $paidinterest->paid_int_amt + $paiddepinterest->paid_int_amt + $getint->debit;
                                        ?>
                                        <?php
                                        $comm = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date>' => '2019-03-31', 'status !=' => 'Trash'))->row();
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Direct Expenses</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($dexp_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($dexp_dr->debit + $intpaid + $comm->other_amt + $get_commision_adjustment_val->commision) ?></b></td>
                                        </tr>                           
                                        <?php
                                        $dir_exp = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Direct Expenses', 'particulars !=' => '46', 'status!=' => 'Trash'))->result();
                                        //$dir_exp2 = $this->db->select('*')->group_by('particulars')->get_where('vouchers', array('under' => 'Direct Expenses','particulars !='=>'9','status!=' => 'Trash'))->result();
                                        //  $query = '(SELECT voucher_id,credit,debit,`particulars` AS PARTICULARS,"vouchers" as TABLES FROM vouchers  WHERE status != "Trash" GROUP BY PARTICULARS) UNION (SELECT voucher_id,credit,debit,`particulars` AS PARTICULARS,"vouchers" as TABLES FROM vouchers  WHERE status != "Trash" GROUP BY PARTICULARS)';
                                        //    $query = $this->db->query($query)->result_array();
                                        foreach ($dir_exp as $dir_exp) {
                                            $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $dir_exp->particulars, 'status!=' => 'Trash'))->row();
                                            $cred = $this->db->select_sum('credit')->get_where('vouchers', array('particulars' => $dir_exp->particulars, 'status!=' => 'Trash'))->row();
                                            $debit = $this->db->select_sum('debit')->get_where('vouchers', array('particulars' => $dir_exp->particulars, 'status!=' => 'Trash'))->row();
                                            if ($cred->credit < $debit->debit) {
                                                $cp_openbal = $debit->debit - $cred->credit;
                                            } else {
                                                $cp_openbal = $cred->credit - $debit->debit;
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left bold-head"><a href="view_vch_details?voucher_id=<?php echo $dir_exp->particulars; ?>"><?php echo $getname->name ?></a></td>
                                                <?php if ($cred->credit < $debit->debit) { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Dr" ?></td>
                                                <?php } else { ?>
                                                    <td class="text-right"><?php echo moneyformat($cp_openbal) . " Cr" ?></td>  
                                                <?php } ?>
                                                <td class="text-right"><?php echo moneyformat($cred->credit) ?></td>
                                                <td class="text-right"><?php echo moneyformat($debit->debit) ?></td>
                                            </tr>
                                        <?php } ?>

                                        <tr>

                                            <td colspan="3" class="text-left"><a href="view_vch_details?voucher_id=Interest Paid">Interest Paid</a></td>
                                            <td class="text-right"><?php echo moneyformat($intpaid); ?></td>
                                        </tr>

                                        <tr>
                                            <td class="text-left"><a href="profit_loss_detail?voucher_id=Commission Paid to Bank">Commission Paid to Bank</a></td>
                                            <td colspan="3" class="text-right"><?php echo moneyformat($comm->other_amt + $get_commision_adjustment_val->commision) ?></td>
                                        </tr>




                                        <?php
                                        $pl_cr = $this->db->select_sum('credit')->get_where('vouchers', array('under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->row();
                                        $pl_dr = $this->db->select_sum('debit')->get_where('vouchers', array('under' => 'Profit & Loss A/c', 'status!=' => 'Trash'))->row();
                                        ?>
                                        <tr><td colspan="2" class="text-left bold-head"><b>Profit & Loss A/c</b></td>
                                            <td class="text-right"><b><?php echo moneyformat($pl_cr->credit) ?></b></td>
                                            <td class="text-right"><b><?php echo moneyformat($pl_dr->debit) ?></b></td>
                                        </tr>                                  
                                        <?php
                                        $vch_cr_tot = $this->db->select_sum('credit')->get_where('vouchers', array('particulars!=' => "46", 'status!=' => 'Trash'))->row();
                                        $vch_dr_tot = $this->db->select_sum('debit')->get_where('vouchers', array('particulars!=' => "46", 'status!=' => 'Trash'))->row();
                                        $bankdetails = $this->db->select_sum('loan_amount')->get_where('replace_loans', array('status !=' => 'Trash'))->row();

                                        $cr_total =  $cr->credit  + $get_year_credit->credit + $credit - $get_addless_adjustment_val->addless + $vch_cr_tot->credit + $dep->dep_amount + $loanint[0]->rcvd_int_amt + $ploanint[0]->rcvd_int_amt + $bankdetails->loan_amount - $getloan->loan_amt;
                                        $dr_total = $dr->debit + $get_year_debit->debit + $balance + $deb + $vch_dr_tot->debit + $paidint[0]->paid_int_amt + $paiddepint[0]->paid_int_amt + $loan->loan_amount - $loanrec->loan_amt + $comm->other_amt + $get_commision_adjustment_val->commision;
                                        ?>

                                        <tr><td colspan="2" class="text-left bold-head"><b>Total</b></td>
                                            <td class="text-right"><?php echo moneyformat($cr_total) ?></td>
                                            <td class="text-right"><?php echo moneyformat($dr_total) ?></td>
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
    <!-- /2 columns form -->
</div>
<style>
    .transactions-table td {
        border:none !important;
    }
    .bold-head{
        font-size: 16px;
    }
</style>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = '<h2 style="font-size:10px;">Kundrakudian Finance</h2><h6 style="font-size:10px;">540, South car street ,</h6><h6 style="font-size:10px;">Kundrakudi .</h6><h6 class="text-right" style="position:absolute; top:50px;right:0;font-size:10px"><b>From</b> :  <?php echo (!empty($from)) ? date('d-m-Y', strtotime($from)) : "01-04-2018" ?> ,<b>To</b> :  <?php echo (!empty($to)) ? date('d-m-Y', strtotime($to)) : date('d-m-Y'); ?></h6><br><h6 class="text-right" style="position:absolute; top:70px;right:0;font-size:10px"><b>Print Date</b> :  <?php echo date('d-m-Y') ?></h6><h2 class="text-center" style="font-size:12px;">Trialbalance</h2><table style="width:100% !important;border:1px solid #ddd;padding:10px;">' + document.getElementById(divName).innerHTML + '</table>';
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>