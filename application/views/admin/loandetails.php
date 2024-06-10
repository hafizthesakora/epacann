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
                <li>Trial Balance</li>
                <li class="active">Summary</li>
            </ul>
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
                    <?php
                    $get_closing_balance = $this->db->order_by('daybook_date', "desc")->get_where('daybooks')->row();
                    if (!empty($get_closing_balance)) {
                        $cb = $get_closing_balance->closing_balance;
                    } else {
                        $cb = 0;
                    }
                    ?>
                    <div class="pane-search">
                        <div class="table-responsive">   
                            <div class="trans-table-display">
                                <?php
                                $id=$this->input->get('id');
                                $name = $this->input->get('voucher_id');
                                $getname = $this->db->get_where('ledger', array('ledger_id' => $name, 'status != ' => 'Trash'))->row();
                                if (!empty($getname)) {
                                    ?>
                                    <div class="trans-table-head"><h4>Ledger Monthly Summary - <span style="text-transform:uppercase"><?php echo $getname->name ?></span></h4></div>
                                <?php } else { ?>
                                    <div class="trans-table-head"><h4>Ledger Monthly Summary - <span style="text-transform:uppercase"><?php echo $name ?></span></h4></div>
                                <?php } ?>
                                <table class="transactions-table trans-margin table-striped table-bordered dataTable">
                                    <thead class="transactions-table-head">
                                        <tr>
                                            <th class="text-left">Month & Year</th>
                                            <th class="text-right">Credit</th>
                                            <th class="text-right">Debit</th>
                                            <th class="text-right">Closing Balance ( GHS )</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $voucher_id = $this->input->get('voucher_id');
                                    if ($name == "cash_a/c") {
                                        $closing_balance = $cb;
                                        ?>
                                        <tr>
                                            <td class="text-left"><b>Opening Balance</b></td>
                                            <td colspan="3" class="text-right"> <b> GHS <?php echo money_format('%!i', $closing_balance) ?> Dr</b></td>
                                        </tr>
                                        <?php
                                        foreach ($results as $key => $result) {
                                            $debit = $credit = 0;
                                            $details = $this->db->select('*')->select_sum('loan_amount')->get_where('loans', array('MONTH(loan_date)' => date('m', strtotime('01-' . $key)), 'YEAR(loan_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $credit += $details->loan_amount;
                                            $details = $this->db->select('*')->select_sum('loan_amount')->get_where('personal_loans', array('MONTH(loan_date)' => date('m', strtotime('01-' . $key)), 'YEAR(loan_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $credit += $details->loan_amount;
                                            $details = $this->db->select('*')->select_sum('total_amt')->get_where('receipts', array('MONTH(receipt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(receipt_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $debit += $details->total_amt;
                                            $details = $this->db->select('*')->select_sum('total_amt')->get_where('personalloan_receipts', array('MONTH(receipt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(receipt_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $debit += $details->total_amt;
                                            $details = $this->db->select('*')->select_sum('dep_amount')->get_where('deposits', array('MONTH(dep_date)' => date('m', strtotime('01-' . $key)), 'YEAR(dep_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $debit += $details->dep_amount;
                                            $details = $this->db->select('*')->select_sum('total_amt')->get_where('replace_payments', array('MONTH(pymt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(pymt_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $credit += $details->total_amt;
                                            $details = $this->db->select('*')->select_sum('dep_amt')->get_where('deposit_payments', array('MONTH(pymt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(pymt_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $debit += $details->dep_amt;
                                            $details = $this->db->select('*')->select_sum('paid_int_amt')->get_where('deposit_payments', array('MONTH(pymt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(pymt_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $credit += $details->paid_int_amt;
                                            $details = $this->db->select('*')->select_sum('loan_amount')->get_where('replace_loans', array('MONTH(date)' => date('m', strtotime('01-' . $key)), 'YEAR(date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $debit += $details->loan_amount;
                                            $details = $this->db->select('*')->select_sum('other_amt')->get_where('replace_loans', array('MONTH(date)' => date('m', strtotime('01-' . $key)), 'YEAR(date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $credit += $details->other_amt;
                                            $details = $this->db->select('*')->select_sum('debit')->get_where('vouchers', array('MONTH(vch_date)' => date('m', strtotime('01-' . $key)), 'YEAR(vch_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $credit += $details->debit;
                                            $details = $this->db->select('*')->select_sum('credit')->get_where('vouchers', array('MONTH(vch_date)' => date('m', strtotime('01-' . $key)), 'YEAR(vch_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $debit += $details->credit;

                                            $details = $this->db->select('*')->select_sum('add_less', 'addlesss')->get_where('receipts', array('MONTH(receipt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(receipt_date)' => date('Y', strtotime('01-' . $key)), 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                            $debit += $details->add_less;
                                            $details = $this->db->select('*')->select_sum('add_less', 'addlesss')->get_where('receipts', array('MONTH(receipt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(receipt_date)' => date('Y', strtotime('01-' . $key)), 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                            $credit += $details->add_less;

                                            $details = $this->db->select('*')->select_sum('add_less', 'addlesss')->get_where('personalloan_receipts', array('MONTH(receipt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(receipt_date)' => date('Y', strtotime('01-' . $key)), 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                            $debit += $details->add_less;
                                            $details = $this->db->select('*')->select_sum('add_less', 'addlesss')->get_where('personalloan_receipts', array('MONTH(receipt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(receipt_date)' => date('Y', strtotime('01-' . $key)), 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                            $credit += $details->add_less;

                                            $details = $this->db->select('*')->select_sum('add_less', 'addlesss')->get_where('replace_payments', array('MONTH(pymt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(pymt_date)' => date('Y', strtotime('01-' . $key)), 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                            $debit += $details->add_less;
                                            $details = $this->db->select('*')->select_sum('add_less', 'addlesss')->get_where('replace_payments', array('MONTH(pymt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(pymt_date)' => date('Y', strtotime('01-' . $key)), 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                            $credit += $details->add_less;

                                            $details = $this->db->select('*')->select_sum('add_less', 'addlesss')->get_where('deposit_payments', array('MONTH(pymt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(pymt_date)' => date('Y', strtotime('01-' . $key)), 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                            $debit += $details->add_less;
                                            $details = $this->db->select('*')->select_sum('add_less', 'addlesss')->get_where('deposit_payments', array('MONTH(pymt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(pymt_date)' => date('Y', strtotime('01-' . $key)), 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                            $credit += $details->add_less;
                                            //  $details = $this->db->select('*')->select_sum('loan_amount')->get_where('receipts', array('MONTH(loan_date)' => date('m', strtotime('01-' . $key)), 'YEAR(loan_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->result();
                                            $closing_balance = $closing_balance + ($debit - $credit);
                                           
                                            ?>
                                            <tr>
                                                <td class="text-left">
                                                    <a href="day_report?name=<?php echo $name ?>&month=<?php echo date('F', strtotime('01-' . $key)); ?>&year=<?php echo date('Y', strtotime('01-' . $key)); ?>">
                                                        <?php echo date('F-Y', strtotime('01-' . $key)); ?>
                                                    </a>
                                                </td>
                                                <td class="text-right">GHS <?php echo money_format('%!i', $credit); //$res->loan_amount                          ?></td>
                                                <td class="text-right">GHS <?php echo money_format('%!i', $debit); //$res->loan_amount                          ?></td>
                                                <td class="text-right">GHS <?php echo money_format('%!i', $closing_balance); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else if ($voucher_id == "Interest Received") {
                                        $closing_balance = 0;
                                        ?>
                                        <tr>
                                            <td class="text-left"><b>Opening Balance</b></td>
                                            <td colspan="3" class="text-right"> <b> GHS <?php echo money_format('%!i', $closing_balance) ?> Dr</b></td>
                                        </tr>
                                        <?php
                                        foreach ($results as $key => $result) {
                                            $closing_balance = $closing_balance + $result;
                                            ?>
                                            <tr>
                                                <td class="text-left"><a href="day_report?name=<?php echo $name ?>&month=<?php echo date('F', strtotime($key)); ?>&year=<?php echo date('Y', strtotime($key)); ?>">
                                                        <?php echo $key; ?></a></td>
                                                <td class="text-right">GHS <?php echo money_format('%!i', $result); ?></td>
                                                <td colspan="2" class="text-right">GHS <?php echo money_format('%!i', $closing_balance); ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td class="text-left"><b>Total</b></td><td colspan="3" class="text-right">GHS <b><?php echo money_format('%!i', $closing_balance) ?>Cr</b></td> 
                                        </tr>
                                        <?php
                                    } else if ($voucher_id == "Interest Paid") {
                                        $closing_balance = 0;
                                        ?>
                                        <tr>
                                            <td class="text-left"><b>Opening Balance</b></td>
                                            <td colspan="3" class="text-right"> <b> GHS <?php echo money_format('%!i', $closing_balance) ?> Dr</b></td>
                                        </tr><?php
                                        foreach ($results as $key => $result) {
                                            $closing_balance = $closing_balance - $result;
                                            ?>
                                            <tr>
                                                <td class="text-left"><?php //$date = date('F', strtotime($key));                                        ?>
                                                    <a href="day_report?name=<?php echo $name ?>&month=<?php echo date('F', strtotime($key)); ?>&year=<?php echo date('Y', strtotime($key)); ?>">
                                                        <?php echo $key; ?></a></td>
                                                <td colspan="2"  class="text-right">GHS <?php echo money_format('%!i', $result); ?></td>
                                                <td class="text-right">GHS <?php echo money_format('%!i', $closing_balance); ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td class="text-left"><b>Total</b></td><td colspan="3" class="text-right">GHS <b><?php echo money_format('%!i', $closing_balance) ?>Dr</b></td> 
                                        </tr>
                                    <?php } else if (isset($id)) {
                                          if (!empty($replaceloan)) {
                                                    $cb = 0; ?>
                                            <tr>
                                                            <td colspan='4' class="text-left"><b>Replace Loans</b></td></tr>
                                                    <?php foreach ($replaceloan as $res) {
                                                        $datee = date('m', strtotime($res->date));
                                                        $yearr = date('Y', strtotime($res->date));
                                                        $replaceloan = $this->db->select('*')->group_by('bank_name')->select_sum('bank_name')->get_where("replace_loans", array('MONTH(date)' => $datee, 'YEAR(date)' => $yearr, 'bank_name' => $id, 'status !=' => 'Trash'))->row();
                                                        $cb = ($cb + $replaceloan->loan_amount);
                                                        ?>

                                                        
                                                        <tr>
                                                            <td class="text-left"><?php $date = date('F, Y', strtotime($res->date)); ?>
                                                                <a href="replace_day_report?name=<?php echo $replaceloan->bank_name ?>&m=<?php echo date('F', strtotime($res->date)); ?>&y=<?php echo date('Y', strtotime($res->date)); ?>">
                                                                    <?php echo $date; ?></a> 
                                                            </td>
                                                            <td class="text-right">GHS <?php echo money_format('%!i', $replaceloan->loan_amount) ?></td>
                                                            <td></td>
                                                            <?php //if ($getdetail->debit > $getdetail->credit) {        ?>
                                                            <td class="text-right">GHS <?php echo money_format('%!i', $cb) ?></td> 
                                                        </tr>    
                                                        <?php
                                                    }
                                                }
                                    } else {
                                    
                                        ?>
                                        <tbody>    
                                            <?php
                                            $closing_balance = 0;
                                            ?>
                                            <tr>
                                                <td class="text-left"><b>Opening Balance</b></td>
                                                <td colspan="3" class="text-right"> <b> GHS <?php echo money_format('%!i', $closing_balance) ?> Dr</b></td>
                                            </tr>
                                            <?php 
                                            foreach ($getdetails as $getdetail) {
                                                $voucher_id = $this->input->get('voucher_id');

                                                $first_result = $this->db->select('*')->order_by('vch_date', "asc")->get_where("vouchers", array('particulars' => $voucher_id, 'status !=' => 'Trash'))->row();
                                                $date = date('m', strtotime($getdetail->vch_date));
                                                $year = date('Y', strtotime($getdetail->vch_date));
                                                $credit = $this->db->select_sum('credit')->get_where("vouchers", array('MONTH(vch_date)' => $date, 'YEAR(vch_date)' => $year, 'particulars' => $name, 'status !=' => 'Trash'))->result();
                                                $debit = $this->db->select_sum('debit')->get_where("vouchers", array('MONTH(vch_date)' => $date, 'YEAR(vch_date)' => $year, 'particulars' => $name, 'status !=' => 'Trash'))->result();
                                                ?>
                                                <?php 
                                                if($credit[0]->credit > $debit[0]->debit) {
                                                $closing_balance = ($closing_balance + $credit[0]->credit - $debit[0]->debit);
                                                } else {
                                                   $closing_balance = ($closing_balance +$debit[0]->debit - $credit[0]->credit ); 
                                                }
                                                ?>

                                                
                                                    <td class="text-left"><?php $date = date('F, Y', strtotime($getdetail->vch_date)); ?>
                                                        <a href="day_report?name=<?php echo $name ?>&month=<?php echo date('F', strtotime($getdetail->vch_date)); ?>&year=<?php echo date('Y', strtotime($getdetail->vch_date)); ?>">
                                                            <?php echo $date; ?></a> 
                                                    </td>
                                                    <td class="text-right">GHS <?php echo money_format('%!i', $credit[0]->credit) ?></td>
                                                    <td class="text-right">GHS <?php echo money_format('%!i', $debit[0]->debit) ?></td>
                                                    <?php //if ($getdetail->debit > $getdetail->credit) {       ?>
                                                    <td class="text-right">GHS <?php echo money_format('%!i', $closing_balance) ?></td> 
                                                </tr>
                                                <?php
                                            }
                                           
                                            ?>
                                          <td class="text-left"><b>Total</b></td><td colspan="3" class="text-right">GHS <b><?php echo money_format('%!i', $closing_balance) ?></b></td> 
                                                
                                        </tbody>
                                    <?php } ?>
<!--<tr>
<td class="text-left"><b>Total</b></td><td colspan="3" class="text-right">GHS <b><?php echo money_format('%!i', $closing_balance) ?></b></td> 
</tr>-->
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
