<div class="content-wrapper">
    <!-- Page header -->                
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Form Layouts</span> - Horizontal</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>                            </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href=""><i class="icon-home2 position-left"></i>Accounts</a></li>
                <li>Profit & Loss</li>
                <li class="active">Day Summary</li>
            </ul>
            <input type="button" onclick="printDiv('example4')" class="button-style-2 submit-btn print" value="Print"/>
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body">
                <fieldset>
                    <legend style="margin-bottom:unset ;">
                        <div class="button-style-2 invoice-button back-btn">
                            <a onclick="window.history.back();"><span class="trans-icons-3"></span>Back</a>     
                        </div>
                    </legend>
                    <div class="pane-search">
                        <div class="table-responsive">   
                            <div class="trans-table-display">
                                <?php
                                //  $mth = $this->input->get('month');
                                //  $yr = $this->input->get('year');
                                //  $month = date('m', strtotime($mth));
                                //  $year = date('Y', strtotime($yr));
                                $name = $this->input->get('name');
                                $getname = $this->db->get_where('ledger', array('ledger_id' => $name, 'status != ' => 'Trash'))->row();
                                if (!empty($getname)) {
                                    ?>
                                    <div class="trans-table-head"><h4>Ledger Monthly Summary - <span style="text-transform:uppercase"><?php echo $getname->name ?></span></h4></div>
                                <?php } else { ?>
                                    <div class="trans-table-head"><h4>Ledger Monthly Summary - <span style="text-transform:uppercase"><?php echo $name ?></span></h4></div>
                                <?php } ?>
<table class="transactions-table trans-margin table-striped table-bordered dataTable" id="example4" >
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
                                        html, body {
                                            border: 1px solid white;
                                            height: 99%;
                                            page-break-after: avoid !important;
                                            page-break-before: avoid !important;
                                        }

                                    }
                                </style>
                                    <thead class="transactions-table-head">
                                        <tr>
                                            <th class="text-left">Date</th>
                                            <th class="text-left">Particulars</th>
                                            <th class="text-left">Vch. Type</th>
                                            <th class="text-right">Credit</th>
                                            <th class="text-right">Debit</th>
                                            <th class="text-right"> Balance ( (GHS) )</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if ($name == "Commission Paid to Bank") {
                                        $closing_balance = 0;
                                        ?>
                                        <tbody>
                                            <?php
                                            foreach ($commissionres as $commissionresult) {
                                                //$tot_other_amt = $this->db->select_sum('other_amt')->get_where("replace_loans", array('date' => $commissionresult->date, 'status !=' => 'Trash'))->result(); 
                                                // $get_sum = $this->db->order_by('date', "asc")->group_by('date')->select_sum('other_amt')->get_where('replace_loans', array('date' => $commissionresult->date, 'status !=' => 'Trash'))->row();
                                                $closing_balance = $closing_balance + $commissionresult->other_amt;
                                                ?>
                                                <tr>
                                                    <td class="text-left"><a href="view_rep_loan?replaceloan_id=<?php echo $commissionresult->replaceloan_id; ?>" ><?php echo date('d-m-Y', strtotime($commissionresult->date)); ?></a></td>
                                                    <td class="text-left"><?php echo "S.No." . $commissionresult->sno . "\t, Bank Loan No." . $commissionresult->bank_loan_no ?></td>
                                                    <td class="text-left">Receipt</td>
                                                    <td></td><td class="text-right">(GHS) <?php echo moneyformat($commissionresult->other_amt) ?></td>
                                                    <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                </tr>

                                            <?php } ?><tr>
                                                <td class="text-left"><b>Total</b></td>
                                                <td></td><td></td><td></td><td></td><td class="text-right"><b>(GHS) <?php echo moneyformat($closing_balance) ?> Dr</b></td>
                                            </tr> 
                                        </tbody>
                                    <?php } else if ($name == "Interest Paid") {
                                        ?>                                      
                                        <tbody>
                                            <?php
                                            $closing_balance = 0;
                                            foreach ($paidint as $paidintresult) {
                                                $closing_balance = ($closing_balance + $paidintresult->paid_int_amt);
                                                ?>
                                                <tr>
                                                    <td class="text-left"><a href="view_rep_pymt?replace_payment_id=<?php echo $paidintresult->replace_payment_id; ?>" ><?php echo date('d-m-Y', strtotime($paidintresult->pymt_date)); ?></a></td>
                                                    <td class="text-left"><?php echo "S.No." . $paidintresult->pymt_no . "\t, Bank Loan No." . $paidintresult->bank_loan_no ?></td>
                                                    <td class="text-left">Receipt</td>
                                                    <td></td><td class="text-right">(GHS) <?php echo moneyformat($paidintresult->paid_int_amt) ?></td>
                                                    <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                </tr>

                                                <?php
                                            } foreach ($paiddepint as $paiddepint) {
                                               $closing_balance = ($closing_balance + $paiddepint->paid_int_amt);
                                                ?>
                                                <tr>
                                                    <td class="text-left"><a href="view_dep_pymt?pymt_id=<?php echo $paiddepint->pymt_id; ?>" ><?php echo date('d-m-Y', strtotime($paiddepint->pymt_date)); ?></a></td>
                                                    <td class="text-left"><?php echo "Dep.No." . $paiddepint->dep_no ?></td>
                                                    <td class="text-left">Receipt</td>
                                                    <td></td><td class="text-right">(GHS) <?php echo moneyformat($paiddepint->paid_int_amt) ?></td>
                                                    <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                </tr>

                                                <?php
                                            }
                                            $year = $this->input->get('year');
                                            $month = date('m', strtotime($this->input->get('month')));
                                            $vchres = $this->db->select('*')->order_by('vch_date', "asc")->get_where('vouchers', array('particulars' => "46", 'MONTH(vch_date)' => $month, 'YEAR(vch_date)' => $year, 'status !=' => 'Trash'))->result();
                                            foreach ($vchres as $vchres) {
                                                $closing_balance = $closing_balance + $vchres->debit;
                                                ?>    
                                                <tr>
                                                    <td class="text-left"><a href="view_voucher?voucher_id=<?php echo $vchres->voucher_id; ?>" ><?php echo date('d-m-Y', strtotime($vchres->vch_date)); ?></a></td>
                                                    <td class="text-left"><?php echo "Vch.No." . $vchres->vch_no ?></td>
                                                    <td class="text-left">Journal</td>
                                                    <td class="text-right">(GHS) <?php echo moneyformat($vchres->debit) ?></td>
                                                    <td></td>
                                                    <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                </tr>

                                                <?php
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left"><b>Total</b></td>
                                                <td></td><td></td><td></td><td></td><td class="text-right"><b>(GHS) <?php echo moneyformat($closing_balance) ?> Dr</b></td>
                                            </tr>
                                        </tbody>
                                    <?php } else if ($name == "Interest Received") {
                                        ?>
                                        <tbody>
                                            <?php
                                            $closing_balance = 0;
                                            foreach ($loanints as $loanint) {
                                                $closing_balance = $closing_balance + $loanint->rcvd_int_amt;
                                                ?>    
                                                <tr>
                                                    <td class="text-left"><a href="view_receipt?receipt_id=<?php echo $loanint->receipt_id; ?>" ><?php echo date('d-m-Y', strtotime($loanint->receipt_date)); ?></a></td>
                                                    <td class="text-left"><?php echo "Rcpt.No." . $loanint->receipt_no . "\t, Loan No." . $loanint->loan_no ?></td>
                                                    <td class="text-left">Receipt</td>
                                                    <td class="text-right">(GHS) <?php echo moneyformat($loanint->rcvd_int_amt) ?></td>
                                                    <td></td>
                                                    <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                </tr>

                                                <?php
                                            }
                                            foreach ($ploanint as $ploanint) {
                                                $closing_balance = $closing_balance + $ploanint->rcvd_int_amt;
                                                ?>    
                                                <tr>
                                                    <td class="text-left"><a href="view_plreceipt?receipt_id=<?php echo $ploanint->receipt_id; ?>" ><?php echo date('d-m-Y', strtotime($ploanint->receipt_date)); ?></a></td>
                                                    <td class="text-left"><?php echo "Rcpt.No." . $ploanint->receipt_no . "\t, Loan No." . $ploanint->loan_no ?></td>
                                                    <td class="text-left">Receipt</td>
                                                    <td class="text-right">(GHS) <?php echo moneyformat($ploanint->rcvd_int_amt) ?></td>
                                                    <td></td>
                                                    <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                </tr>

                                                <?php
                                            }
                                            $year = $this->input->get('year');
                                            $month = date('m', strtotime($this->input->get('month')));
                                            $vchres = $this->db->select('*')->order_by('vch_date', "asc")->get_where('vouchers', array('particulars' => "48", 'MONTH(vch_date)' => $month, 'YEAR(vch_date)' => $year, 'status !=' => 'Trash'))->result();
                                            foreach ($vchres as $vchres) {
                                                $closing_balance = $closing_balance + $vchres->credit;
                                                ?>    
                                                <tr>
                                                    <td class="text-left"><a href="view_voucher?voucher_id=<?php echo $vchres->voucher_id; ?>" ><?php echo date('d-m-Y', strtotime($vchres->vch_date)); ?></a></td>
                                                    <td class="text-left"><?php echo "Vch.No." . $vchres->vch_no ?></td>
                                                    <td class="text-left">Journal</td>
                                                    <td class="text-right">(GHS) <?php echo moneyformat($vchres->credit) ?></td>
                                                    <td></td>
                                                    <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                </tr>

                                                <?php
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left"><b>Total</b></td>
                                                <td></td><td></td><td></td><td></td><td  class="text-right"><b>(GHS) <?php echo moneyformat($closing_balance) ?> Cr</b></td>
                                            </tr> 
                                        </tbody>
                                    <?php } else if ($name == "Add/Less") { ?>
                                        <tbody>
                                            <?php
                                            $closing_balance = 0;
                                            $tot = 0;
                                            foreach ($rec_results as $rec_result) {
                                                // $closing_balance = $closing_balance + $rec_result->add_less;
                                                if (!empty($rec_result->add_less)) {
                                                    if ($rec_result->add_less < 0) {
                                                        $closing_balance = $closing_balance + $rec_result->add_less;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left"><a href="view_receipt?receipt_id=<?php echo $rec_result->receipt_id; ?>" ><?php echo date('d-m-Y', strtotime($rec_result->receipt_date)); ?></a></td>
                                                            <td class="text-left"><?php echo "Rcpt.No." . $rec_result->receipt_no ?></td>
                                                            <td class="text-left">Receipt</td>
                                                            <td></td><td class="text-right">(GHS) <?php echo moneyformat(-$rec_result->add_less) ?></td>
                                                            <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                        </tr> 

                                                        <?php
                                                    } else {
                                                        $closing_balance = $closing_balance + $rec_result->add_less;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left"><a href="view_receipt?receipt_id=<?php echo $rec_result->receipt_id; ?>" ><?php echo date('d-m-Y', strtotime($rec_result->receipt_date)); ?></a></td>
                                                            <td class="text-left"><?php echo "Rcpt.No." . $rec_result->receipt_no ?></td>
                                                            <td class="text-left">Receipt</td>
                                                            <td class="text-right">(GHS) <?php echo moneyformat($rec_result->add_less) ?></td>
                                                            <td></td><td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                        </tr> 
                                                        <?php
                                                    }
                                                }
                                            }
                                            foreach ($repl_results as $repl_result) {
                                               
                                                    if ($repl_result->add_less < 0) {
                                                        $closing_balance = $closing_balance + (-$repl_result->add_less);
                                                        ?>
                                                        <tr>
                                                            <td class="text-left"><a href="view_rep_pymt?replace_payment_id=<?php echo $repl_result->replace_payment_id; ?>" ><?php echo date('d-m-Y', strtotime($repl_result->pymt_date)); ?></a></td>
                                                            <td class="text-left"><?php echo "Pymt.No." . $repl_result->pymt_no ?></td>
                                                            <td class="text-left">Payment</td>
                                                            <td class="text-right">(GHS) <?php echo moneyformat(-($repl_result->add_less)) ?></td>
                                                            <td></td>

                                                            <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                        </tr> 

                                                        <?php
                                                    } else {
                                                        $closing_balance = $closing_balance - $repl_result->add_less;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left"><a href="view_rep_pymt?replace_payment_id=<?php echo $repl_result->replace_payment_id; ?>" ><?php echo date('d-m-Y', strtotime($repl_result->pymt_date)); ?></a></td>
                                                            <td class="text-left"><?php echo "Pymt.No." . $repl_result->pymt_no ?></td>
                                                            <td class="text-left">Payment</td>
                                                            <td></td>
                                                            <td class="text-right">(GHS) <?php echo moneyformat($repl_result->add_less) ?></td>

                                                            <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                        </tr> 
                                                        <?php
                                                    }
                                                
                                            }

                                            foreach ($pl_results as $pl_result) {

                                                if (!empty($pl_result->add_less)) {
                                                    if ($pl_result->add_less < 0) {
                                                        $closing_balance = $closing_balance - $pl_result->add_less;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left"><a href="view_plreceipt?receipt_id=<?php echo $pl_result->receipt_id; ?>" ><?php echo date('d-m-Y', strtotime($pl_result->receipt_date)); ?></a></td>
                                                            <td class="text-left"><?php echo "Rcpt.No." . $pl_result->receipt_no ?></td>
                                                            <td class="text-left">Receipt</td>
                                                            <td></td><td class="text-right">(GHS) <?php echo moneyformat($pl_result->add_less) ?></td>

                                                            <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                        </tr> 

                                                        <?php
                                                    } else {
                                                        $closing_balance = $closing_balance + $pl_result->add_less;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left"><a href="view_plreceipt?receipt_id=<?php echo $pl_result->receipt_id; ?>" ><?php echo date('d-m-Y', strtotime($pl_result->receipt_date)); ?></a></td>
                                                            <td class="text-left"><?php echo "Rcpt.No." . $pl_result->receipt_no ?></td>
                                                            <td class="text-left">Receipt</td>

                                                            <td class="text-right">(GHS) <?php echo moneyformat($pl_result->add_less) ?></td>

                                                            <td></td><td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                        </tr> 
                                                        <?php
                                                    }
                                                }
                                            }
                                            foreach ($dep_results as $dep_result) {

                                                if (!empty($dep_result->add_less)) {
                                                    if ($dep_result->add_less < 0) {
                                                        $closing_balance = $closing_balance + (-$dep_result->add_less);
                                                        ?>
                                                        <tr>
                                                            <td class="text-left"><a href="view_dep_pymt?pymt_id=<?php echo $dep_result->pymt_id; ?>" ><?php echo date('d-m-Y', strtotime($dep_result->pymt_date)); ?></a></td>
                                                            <td class="text-left"><?php echo "Dep.No." . $dep_result->dep_no ?></td>
                                                            <td class="text-left">Payment</td>
                                                            <td class="text-right">(GHS) <?php echo moneyformat(-($dep_result->add_less)) ?></td>
                                                            <td></td>
                                                            <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                        </tr> 

                                                        <?php
                                                    } else {
                                                        $closing_balance = $closing_balance - $dep_result->add_less;
                                                        ?>
                                                        <tr>
                                                            <td class="text-left"><a href="view_dep_pymt?pymt_id=<?php echo $dep_result->pymt_id; ?>" ><?php echo date('d-m-Y', strtotime($dep_result->pymt_date)); ?></a></td>
                                                            <td class="text-left"><?php echo "Pymt.No." . $dep_result->pymt_no ?></td>
                                                            <td class="text-left">Payment</td>
                                                            <td></td>
                                                            <td class="text-right">(GHS) <?php echo moneyformat($dep_result->add_less) ?></td>

                                                            <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                        </tr> 
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>


                                    <?php } else if ($name == "cash_a/c") {
                                        ?>                                      
                                        <tbody>
                                            <?php
                                            $closing_balance = 0;
                                            foreach ($get_tot_from_loans as $get_tot_from_loans) {
                                                // $get_sum = $this->db->order_by('pymt_date', "asc")->group_by('pymt_date')->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date' => $paidintresult->pymt_date, 'status !=' => 'Trash'))->row();
                                                $closing_balance = ($closing_balance - $get_tot_from_loans->loan_amount);
                                                ?>
                                                <?php if ($get_tot_from_loans != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_loan?loan_id=<?php echo $get_tot_from_loans->loan_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_loans->loan_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Loan no." . $get_tot_from_loans->loan_no ?></td>
                                                        <td class="text-left">Loan</td>
                                                        <td class="text-right">(GHS) <?php echo moneyformat($get_tot_from_loans->loan_amount) ?></td>
                                                        <td></td><td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } foreach ($get_tot_from_ploans as $get_tot_from_ploans) {
                                                // $get_sum = $this->db->order_by('pymt_date', "asc")->group_by('pymt_date')->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date' => $paidintresult->pymt_date, 'status !=' => 'Trash'))->row();
                                                $closing_balance = ($closing_balance - $get_tot_from_ploans->loan_amount);
                                                ?>
                                                <?php if ($get_tot_from_ploans != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_ploan?personal_loan_id=<?php echo $get_tot_from_ploans->personal_loan_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_ploans->loan_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Loan no." . $get_tot_from_ploans->loan_no ?></td>
                                                        <td class="text-left">Loan</td>
                                                        <td class="text-right">(GHS) <?php echo moneyformat($get_tot_from_ploans->loan_amount) ?></td>
                                                        <td></td><td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } foreach ($get_tot_from_rploans as $get_tot_from_rploans) {
                                                // $get_sum = $this->db->order_by('pymt_date', "asc")->group_by('pymt_date')->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date' => $paidintresult->pymt_date, 'status !=' => 'Trash'))->row();
                                                $closing_balance = ($closing_balance + $get_tot_from_rploans->bal_amt);
                                                ?>
                                                <?php if ($get_tot_from_rploans != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_rep_loan?replaceloan_id=<?php echo $get_tot_from_rploans->replaceloan_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_rploans->date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Bank Loan.No." . $get_tot_from_rploans->bank_loan_no ?></td>
                                                        <td class="text-left">Receipt</td>
                                                        <td></td><td class="text-right">(GHS) <?php echo moneyformat($get_tot_from_rploans->bal_amt) ?></td>
                                                        <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } foreach ($get_tot_from_deposits as $get_tot_from_deposits) {
                                                $closing_balance = ($closing_balance + $get_tot_from_deposits->dep_amount);
                                                ?>
                                                <?php if ($get_tot_from_deposits != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_deposit?deposit_id=<?php echo $get_tot_from_deposits->deposit_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_deposits->dep_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Dep.No." . $get_tot_from_deposits->dep_no ?></td>
                                                        <td class="text-left">Receipt</td>
                                                        <td></td><td class="text-right">(GHS) <?php echo moneyformat($get_tot_from_deposits->dep_amount) ?></td>
                                                        <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } foreach ($get_tot_from_recpt as $get_tot_from_recpt) {
                                                $closing_balance = ($closing_balance + $get_tot_from_recpt->total_amt);
                                                ?>
                                                <?php if (!empty($get_tot_from_recpt)) { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_receipt?receipt_id=<?php echo $get_tot_from_recpt->receipt_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_recpt->receipt_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Rcpt.No." . $get_tot_from_recpt->receipt_no ?></td>
                                                        <td class="text-left">Receipt</td>
                                                        <td></td><td class="text-right">(GHS) <?php echo moneyformat($get_tot_from_recpt->total_amt) ?></td>
                                                        <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } foreach ($get_tot_from_precpt as $get_tot_from_precpt) {
                                                $closing_balance = ($closing_balance + $get_tot_from_precpt->total_amt);
                                                ?>
                                                <?php if (!empty($get_tot_from_precpt)) { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_plreceipt?receipt_id=<?php echo $get_tot_from_precpt->receipt_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_precpt->receipt_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Rcpt.No." . $get_tot_from_precpt->receipt_no ?></td>
                                                        <td class="text-left">Receipt</td>
                                                        <td></td><td class="text-right">(GHS) <?php echo moneyformat($get_tot_from_precpt->total_amt) ?></td>
                                                        <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } foreach ($get_tot_from_deppay as $get_tot_from_deppay) {
                                                $closing_balance = ($closing_balance + $get_tot_from_deppay->dep_amt);
                                                ?>
                                                <?php if ($get_tot_from_deppay != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_dep_pymt?pymt_id=<?php echo $get_tot_from_deppay->pymt_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_deppay->pymt_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Pymt.No." . $get_tot_from_deppay->pymt_no ?></td>
                                                        <td class="text-left">Payment</td>
                                                        <td></td><td class="text-right">(GHS) <?php echo moneyformat($get_tot_from_deppay->dep_amt) ?></td>
                                                        <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            }
                                            foreach ($get_inttot_from_deppay as $get_inttot_from_deppay) {
                                                $closing_balance = ($closing_balance - $get_inttot_from_deppay->paid_int_amt);
                                                ?>
                                                <?php if ($get_inttot_from_deppay != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_dep_pymt?pymt_id=<?php echo $get_inttot_from_deppay->pymt_id; ?>" ><?php echo date('d-m-Y', strtotime($get_inttot_from_deppay->pymt_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Pymt.No." . $get_inttot_from_deppay->pymt_no ?></td>
                                                        <td class="text-left">Payment</td>
                                                        <td class="text-right">(GHS) <?php echo moneyformat($get_inttot_from_deppay->paid_int_amt) ?></td>
                                                        <td></td><td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } foreach ($get_tot_from_reppay as $get_tot_from_reppay) {
                                                $closing_balance = ($closing_balance - $get_tot_from_reppay->total_amt);
                                                ?>
                                                <?php if ($get_tot_from_reppay != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_rep_pymt?replace_payment_id=<?php echo $get_tot_from_reppay->replace_payment_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_reppay->pymt_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Pymt.No." . $get_tot_from_reppay->pymt_no ?></td>
                                                        <td class="text-left">Receipt</td>
                                                        <td class="text-right">(GHS) <?php echo moneyformat($get_tot_from_reppay->total_amt) ?></td>
                                                        <td></td><td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } foreach ($get_ctot_from_voucher as $get_ctot_from_voucher) {
                                                $closing_balance = ($closing_balance + $get_ctot_from_voucher->credit);
                                                ?>
                                                <?php if ($get_ctot_from_voucher != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_voucher?voucher_id=<?php echo $get_ctot_from_voucher->voucher_id; ?>" ><?php echo date('d-m-Y', strtotime($get_ctot_from_voucher->vch_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Vch.No." . $get_ctot_from_voucher->vch_no ?></td>
                                                        <td class="text-left">Receipt</td>
                                                        <td></td><td class="text-right">(GHS) <?php echo moneyformat($get_ctot_from_voucher->credit) ?></td>
                                                        <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } foreach ($get_dtot_from_voucher as $get_dtot_from_voucher) {
                                                $closing_balance = ($closing_balance - $get_dtot_from_voucher->debit);
                                                ?>
                                                <?php if ($get_dtot_from_voucher != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_voucher?voucher_id=<?php echo $get_dtot_from_voucher->voucher_id; ?>" ><?php echo date('d-m-Y', strtotime($get_dtot_from_voucher->vch_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Vch.No." . $get_dtot_from_voucher->vch_no ?></td>
                                                        <td class="text-left">Receipt</td>
                                                        <td class="text-right">(GHS) <?php echo moneyformat($get_dtot_from_voucher->debit) ?></td>
                                                        <td></td><td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } ?>
                                            <tr>
                                                <td class="text-left"><b>Total</b></td>
                                                <td></td><td></td><td></td><td></td> <td class="text-right"><b>(GHS) <?php echo moneyformat($closing_balance) ?> Dr</b></td>
                                            </tr>
                                        </tbody>
                                    <?php } else {
                                        ?>
                                        <tbody>
                                            <?php
                                            $closing_balance = 0;
                                            foreach ($getdetails as $getdetail) {
                                                   $closing_balance = $closing_balance + $getdetail->credit - $getdetail->debit;
                                                ?>
                                                <?php if (!empty($getdetail)) { ?>
                                                    <tr>
                                                        <?php $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $getdetail->particulars, 'status != ' => 'Trash'))->row(); ?>
                                                        <td class="text-left"><a href="view_voucher?voucher_id=<?php echo $getdetail->voucher_id; ?>" ><?php echo date('d-m-Y', strtotime($getdetail->vch_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Vch.No :\t" . $getdetail->vch_no . ",\t" . "Narration :\t" . $getdetail->narration ?></td>
                                                        <td class="text-left">Journal</td>
                                                        <?php if (!empty($getdetail->debit)) { ?><td></td>
                                                            <td class="text-right">(GHS) <?php echo moneyformat($getdetail->debit) ?></td>
                                                        <?php } else { ?>

                                                            <td class="text-right">(GHS) <?php echo moneyformat($getdetail->credit) ?></td>
                                                            <td></td>
                                                        <?php } ?>
                                                        <td class="text-right">(GHS) <?php echo moneyformat($closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            }
//                                            if (!empty($bankdetails)) {
//                                                foreach ($bankdetails as $bankdetail) {
//                                                    ?>
<!--                                                    <tr>
                                                        <?php //$getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $getdetail->particulars, 'status != ' => 'Trash'))->row();    ?>
                                                        <td class="text-left"><a href="view_rep_loan?replaceloan_id=//<?php echo $bankdetail->replaceloan_id; ?>" ><?php echo date('d-m-Y', strtotime($bankdetail->date)); ?></a></td>
                                                        <td class="text-left">//<?php echo "Bank Loan No :\t" . $bankdetail->bank_loan_no . ",\t" . "Partculars :\t" . $bankdetail->bank_name ?></td>
                                                        <td class="text-left">Replace Loan</td>
                                                        <td class="text-right">(GHS) //<?php echo moneyformat($bankdetail->loan_amount) ?></td>
                                                        <td></td>
                                                        <td class="text-right">(GHS) //<?php echo moneyformat($closing_balance) ?></td>
                                                    </tr>  -->
                                                   <?php
//                                                }
//                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left"><b>Total</b></td>
                                                <?php 
                                              //  if ($getdetail->debit > $getdetail->credit) { ?>
                                                    <td></td><td></td><td></td><td></td><td class="text-right"><b>(GHS) <?php echo moneyformat($closing_balance) ?> </b></td>
                                                <?php //} else { ?>
                                                    <!--<td></td><td></td><td></td><td></td><td class="text-right"><b>(GHS) <?php echo moneyformat($closing_balance) ?> Cr</b></td>-->
                                                            <?php //} ?>
                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                            </div> 
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <!-- /2 columns form -->
</div>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = '<h2 style="font-size:10px;">Kundrakudian Finance</h2><h6 style="font-size:10px;">540, South car street ,</h6><h6 style="font-size:10px;">Kundrakudi .</h6><h6 class="text-right" style="position:absolute; top:50px;right:0;font-size:10px"><b>From</b> :  <?php echo (!empty($from)) ? date('d-m-Y', strtotime($from)) : "01-04-2018" ?> ,<b>To</b> :  <?php echo (!empty($to)) ? date('d-m-Y', strtotime($to)) : date('d-m-Y'); ?></h6><br><h6 class="text-right" style="position:absolute; top:70px;right:0;font-size:10px"><b>Print Date</b> :  <?php echo date('d-m-Y') ?></h6><h2 class="text-center" style="font-size:12px;">Day Report</h2><table style="width:100% !important;border:1px solid #ddd;padding:10px;">' + document.getElementById(divName).innerHTML + '</table>';
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
