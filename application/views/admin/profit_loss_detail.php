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
                <li class="active">Summary</li>
            </ul>
            <input type="button" onclick="printDiv('print')" class="button-style-2 submit-btn print" value="Print"/>
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
                                $name = $this->input->get('voucher_id');
                                $getname = $this->db->get_where('ledger', array('ledger_id' => $name, 'status != ' => 'Trash'))->row();
                                if (!empty($getname)) {
                                    ?>
                                    <div class="trans-table-head"><h4>Ledger Monthly Summary - <span style="text-transform:uppercase"><?php echo $getname->name ?></span></h4></div>
                                <?php } else { ?>
                                    <div class="trans-table-head"><h4>Ledger Monthly Summary - <span style="text-transform:uppercase"><?php echo $name ?></span></h4></div>
                                <?php } ?><table class="transactions-table trans-margin table-striped table-bordered dataTable" id="print">
                                    <style type="text/css">
                                @media print {
                                   
                                    tr{
                                        border:1px solid #ccc;
                                    }
                                     a[href]:after {
                                                content: none !important;
                                            }
                                }
                            </style>
                                    <thead class="transactions-table-head">
                                        <tr>
                                            <th class="text-left">Vch date</th>
                                            <th class="text-right">Credit</th>
                                            <th class="text-right">Debit</th>
                                            <th class="text-right">Closing Balance ( GHS )</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if ($name == "Commission Paid to Bank") {
                                        $openbal= 22912;
                                        $closing_balance = 0;
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td colspan="3" class="text-left" ><b>Opening Balance</b></td>
                                                <td class="text-right">GHS <?php echo moneyformat( $openbal); ?></td>
                                            </tr>
                                            <?php
                                            $closing_balance = 0;
                                            foreach ($commissionres as $commissionresult) {
                                                $date = date('m', strtotime($commissionresult->date));
                                                $year = date('Y', strtotime($commissionresult->date));
                                                //print_r($date);
                                                $tot_other_amts = $this->db->select('*')->select_sum('other_amt')->get_where("replace_loans", array('MONTH(date)' => $date, 'YEAR(date)' => $year, 'status !=' => 'Trash'))->result();
                                                foreach ($tot_other_amts as $tot_other_amt) {
                                                    $closing_balance = $openbal + $tot_other_amt->other_amt;
                                                    ?>    
                                                    <tr>
                                                        <td class="text-left"><a href="day_report?name=<?php echo $name ?>&month=<?php echo date('m', strtotime($tot_other_amt->date)); ?>&year=<?php echo date('Y', strtotime($tot_other_amt->date)); ?>">
                                                                <?php echo date('F, Y', strtotime($tot_other_amt->date)); ?></a></td>
                                                        <td></td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $tot_other_amt->other_amt) ?></td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left"><b>Total</b></td>
                                                <td colspan="5" class="text-right"><b>GHS <?php echo moneyformat( $closing_balance) ?> Dr</b></td>
                                            </tr> 
                                        </tbody>
                                    <?php } else if ($name == "Interest Paid") {
                                        ?>
                                        <tbody>
                                            <?php
                                            $closing_balance = 0;
                                            foreach ($paidint as $paidintresult) {
                                                $date = date('m', strtotime($paidintresult->pymt_date));
                                                $year = date('Y', strtotime($paidintresult->pymt_date));
                                                $tot_paid_amts = $this->db->select('*')->select_sum('paid_int_amt')->get_where("replace_payments", array('MONTH(pymt_date)' => $date, 'YEAR(pymt_date)' => $year, 'status !=' => 'Trash'))->result();
                                                foreach ($tot_paid_amts as $tot_paid_amt) {
                                                    $closing_balance = $closing_balance + $tot_paid_amt->paid_int_amt;
                                                    ?>    
                                                    <tr>
                                                        <td class="text-left"><a href="day_report?name=<?php echo $name ?>&month=<?php echo date('m', strtotime($tot_paid_amt->pymt_date)); ?>&year=<?php echo date('Y', strtotime($tot_paid_amt->pymt_date)); ?>">
                                                                <?php echo date('F, Y', strtotime($tot_paid_amt->pymt_date)); ?></a></td>
                                                        <td></td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $tot_paid_amt->paid_int_amt) ?></td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left"><b>Total</b></td>
                                                <td colspan="5" class="text-right"><b>GHS <?php echo moneyformat( $closing_balance) ?> Dr</b></td>
                                            </tr> 
                                        </tbody>
                                    <?php } else if ($name == "Interest Received") {
                                        ?>
                                        <tbody>
                                            <?php
                                            $closing_balance = 0;
                                            foreach ($loanint as $loanint) {
                                                $date = date('m', strtotime($loanint->receipt_date));
                                                $year = date('Y', strtotime($loanint->receipt_date));
                                                $tot_paid_amts = $this->db->select('*')->select_sum('rcvd_int_amt')->get_where("receipts", array('MONTH(receipt_date)' => $date, 'YEAR(receipt_date)' => $year, 'status !=' => 'Trash'))->result();
                                                foreach ($tot_paid_amts as $tot_paid_amt) {
                                                    $closing_balance = $closing_balance + $tot_paid_amt->rcvd_int_amt;
                                                    ?>    
                                                    <tr>
                                                        <td class="text-left"><a href="day_report?name=<?php echo $name ?>&month=<?php echo date('m', strtotime($tot_paid_amt->receipt_date)); ?>&year=<?php echo date('Y', strtotime($tot_paid_amt->receipt_date)); ?>">
                                                                <?php echo date('F, Y', strtotime($tot_paid_amt->receipt_date)); ?></a><?php //echo date('F, Y', strtotime($tot_paid_amt->receipt_date)); ?></td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $tot_paid_amt->rcvd_int_amt) ?></td>
                                                        <td></td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            }
                                            foreach ($ploanint as $ploanint) {
                                                $date = date('m', strtotime($ploanint->receipt_date));
                                                $year = date('Y', strtotime($ploanint->receipt_date));
                                                $tot_paid_amts = $this->db->select('*')->select_sum('rcvd_int_amt')->get_where("personalloan_receipts", array('MONTH(receipt_date)' => $date, 'YEAR(receipt_date)' => $year, 'status !=' => 'Trash'))->result();
                                                foreach ($tot_paid_amts as $tot_paid_amt) {
                                                    $closing_balance = $closing_balance + $tot_paid_amt->rcvd_int_amt;
                                                    ?>    
                                                    <tr>
                                                        <td class="text-left"><a href="day_report?name=<?php echo $name ?>&month=<?php echo date('m', strtotime($tot_paid_amt->receipt_date)); ?>&year=<?php echo date('Y', strtotime($tot_paid_amt->receipt_date)); ?>">
                                                                <?php echo date('F, Y', strtotime($tot_paid_amt->receipt_date)); ?></a><?php //echo date('F, Y', strtotime($tot_paid_amt->receipt_date)); ?></td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $tot_paid_amt->rcvd_int_amt) ?></td>
                                                        <td></td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-left"><b>Total</b></td>
                                                <td colspan="5" class="text-right"><b>GHS <?php echo moneyformat( $closing_balance) ?> Dr</b></td>
                                            </tr> 
                                        </tbody>
                                        <?php
                                    } else if ($name == "Add/Less") {
                                        $closing_balance = 0;
                                        $openbal= 62286;
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td colspan="3" class="text-left" ><b>Opening Balance</b></td>
                                                <td class="text-right">GHS <?php echo moneyformat( $openbal); ?></td>
                                            </tr>
                                            <?php
                                            foreach ($results as $key => $result) {
                                                $debit = $credit = 0;
                                                $details = $this->db->select('add_less')->select_sum('add_less')->get_where('receipts', array('MONTH(receipt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(receipt_date)' => date('Y', strtotime('01-' . $key)),'receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                $credit += $details->add_less;
                                                $details = $this->db->select('add_less')->select_sum('add_less')->get_where('receipts', array('MONTH(receipt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(receipt_date)' => date('Y', strtotime('01-' . $key)),'receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                $debit += -($details->add_less);

                                                $details = $this->db->select('add_less')->select_sum('add_less')->get_where('personalloan_receipts', array('MONTH(receipt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(receipt_date)' => date('Y', strtotime('01-' . $key)),'receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                $credit += $details->add_less;
                                                $details = $this->db->select('add_less')->select_sum('add_less')->get_where('personalloan_receipts', array('MONTH(receipt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(receipt_date)' => date('Y', strtotime('01-' . $key)),'receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                $debit += -($details->add_less);

                                                $details = $this->db->select('add_less')->select_sum('add_less')->get_where('replace_payments', array('MONTH(pymt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(pymt_date)' => date('Y', strtotime('01-' . $key)),'pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                $debit += $details->add_less;
                                                $details = $this->db->select('add_less')->select_sum('add_less')->get_where('replace_payments', array('MONTH(pymt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(pymt_date)' => date('Y', strtotime('01-' . $key)),'pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                $credit += -($details->add_less);

                                                $details = $this->db->select('add_less')->select_sum('add_less')->get_where('deposit_payments', array('MONTH(pymt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(pymt_date)' => date('Y', strtotime('01-' . $key)),'pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                $debit += $details->add_less;
                                                $details = $this->db->select('add_less')->select_sum('add_less')->get_where('deposit_payments', array('MONTH(pymt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(pymt_date)' => date('Y', strtotime('01-' . $key)),'pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                $credit += -($details->add_less);
                                               // print_r($ab);exit;
                                                $closing_balance = $openbal + $credit - $debit; 
                                            
                                            ?>
                                            <tr>
                                                <td class="text-left">
                                                    <a href="day_report?name=<?php echo $name ?>&month=<?php echo date('m', strtotime('01-' . $key)); ?>&year=<?php echo date('Y', strtotime('01-' . $key)); ?>">
                                                        <?php echo date('F-Y', strtotime('01-' . $key)); ?>
                                                    </a>
                                                </td>
                                                <td class="text-right">GHS <?php echo moneyformat( $credit); //$res->loan_amount                            ?></td>
                                                <td class="text-right">GHS <?php echo moneyformat( $debit); //$res->loan_amount                            ?></td>
                                                <td class="text-right">GHS <?php echo moneyformat( $closing_balance); ?></td>
                                            </tr>
                                        </tbody>

                                            <?php } } else {
                                        ?>

                                        <tbody>    
                                            <?php
                                            $closing_balance = 0;
                                            foreach ($getdetails as $getdetail) {
                                                $date = date('m', strtotime($getdetail->vch_date));
                                                $year = date('Y', strtotime($getdetail->vch_date));
                                                $credit = $this->db->select_sum('credit')->get_where("vouchers", array('MONTH(vch_date)' => $date, 'YEAR(vch_date)' => $year, 'particulars' => $name, 'status !=' => 'Trash'))->result();
                                                $debit = $this->db->select_sum('debit')->get_where("vouchers", array('MONTH(vch_date)' => $date, 'YEAR(vch_date)' => $year, 'particulars' => $name, 'status !=' => 'Trash'))->result();
                                                if ($credit[0]->credit < $debit[0]->debit) {
                                                    $closing_balance = ($closing_balance + $debit[0]->debit - $credit[0]->credit);
                                                } else {
                                                    $closing_balance = ($closing_balance + $credit[0]->credit - $debit[0]->debit);
                                                }
                                                ?>
                                                <tr>
                                                    <?php $date = date('F, Y', strtotime($getdetail->vch_date)); ?>
                                                    <td class="text-left"><a href="day_report?name=<?php echo $name ?>&month=<?php echo date('m', strtotime($getdetail->vch_date)); ?>&year=<?php echo date('Y', strtotime($getdetail->vch_date)); ?>">
                                                            <?php echo $date;
                                                            ?></a></td>
                                                    <td class="text-right">GHS <?php echo moneyformat( $credit[0]->credit) ?></td>
                                                    <td class="text-right">GHS <?php echo moneyformat( $debit[0]->debit) ?></td>
                                                    <?php if ($credit[0]->credit < $debit[0]->debit) { ?>
                                                        <td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?>Dr</td> 
                                                    <?php } else { ?> 
                                                        <td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?>Cr</td>    
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <?php if ($credit[0]->credit < $debit[0]->debit) { ?>
                                                    <td class="text-left"><b>Total</b></td><td colspan="3" class="text-right">GHS <b><?php echo moneyformat( ($closing_balance)) . "Dr" ?></b></td>  
                                                <?php } else { ?>
                                                    <td class="text-left"><b>Total</b></td><td colspan="3" class="text-right">GHS <b><?php echo moneyformat( ($closing_balance)) . "Cr" ?></b></td>  
                                                <?php } ?>
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
