<?php
$from = $this->input->get('from');
$to = $this->input->get('to');
?>
<div class="content-wrapper">
    <!-- Page header -->                
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-left52 position-left"></i> 
                    <span class="text-semibold">Form Layouts</span> - Horizontal</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group">             
                    <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>                                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>                            </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="icon-home2 position-left"></i> Accounts</a></li>
                <li class="active">Daybook Display</li>
            </ul>
            <input type="button" onclick="printDiv('example4')" class="button-style-2 submit-btn print" value="Print"/>
<!--            <input type="button" onclick="printDiv('example4')" class="button-style-2 submit-btn print" value="Print"/>-->
        </div>
    </div>
    <!-- /page header -->                <!-- Content area -->                
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <form action="<?php echo base_url('admin/daybook_date_filter') ?>" method="get" id="search" autocomplete="off">
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
                                        <button class="button-style-2 submit-btn" type="submit" name="submit" id="submit">Search </button>                                                 </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--Serach form-->
            <div class="panel-body">
                <div class="pane-search">
                    <div class="table-responsive">
                        <div class="trans-table-display">
                            <!-- <div class="trans-table">-->
                            <table class="transactions-table trans-margin table-striped table-bordered dataTable" id="example4">
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
                                            font-size:10px;
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
                                        <th>#</th>
                                        <th>Particulars</th>
                                        <th style="text-align: right">Credit (GHS)</th>
                                        <th style="text-align: right">Debit (GHS)</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $cr_tot = $dr_tot = 0;

                                    if (!empty($to)) {
                                        $begin = new DateTime($from);
                                        $end = new DateTime($to);
                                        $debitt = $creditt = 0;
                                        for ($x = $begin; $x <= $end; $x->modify('+1 day')) {
                                            $debitt = $creditt = 0;
                                            $date = $x->format("Y-m-d");
                                            ?>
                                            <tr>
                                                <?php
                                                $prevdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));

                                                $get = $this->db->select('closing_balance')->get_where('daybooks', array('status!=' => 'Trash'))->row();
$openbal = isset($get->closing_balance) ? $get->closing_balance : 0; // Set default value if not found

                                                if ($prevdate == "2019-03-31") {
                                                    $creditt = 0;
                                                    $debitt = 0;
                                                    $balance = $openbal;
                                                } else {
                                                    $resultq = $this->db->select_sum('loan_amount')->get_where('loans', array('loan_date<' => $date, 'loan_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->loan_amount;
                                                    $resultq = $this->db->select_sum('loan_amount')->get_where('personal_loans', array('loan_date<' => $date, 'loan_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->loan_amount;
                                                    $resultq = $this->db->select_sum('loan_amt')->get_where('receipts', array('receipt_date<' => $date, 'receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->loan_amt;
                                                    $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('receipt_date<' => $date, 'receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->rcvd_int_amt;
                                                    $resultq = $this->db->select_sum('loan_amt')->get_where('personalloan_receipts', array('receipt_date<' => $date, 'receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->loan_amt;
                                                    $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('receipt_date<' => $date, 'receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->rcvd_int_amt;
                                                    $resultq = $this->db->select_sum('dep_amount')->get_where('deposits', array('dep_date<' => $date, 'dep_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->dep_amount;
                                                    $resultq = $this->db->select_sum('dep_amt')->get_where('deposit_payments', array('pymt_date<' => $date, 'pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->dep_amt;
                                                    $resultq = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('pymt_date<' => $date, 'pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->paid_int_amt;
                                                    $resultq = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('pymt_date<' => $date, 'pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->loan_amt;
                                                    $resultq = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date<' => $date, 'pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->paid_int_amt;
                                                    $resultq = $this->db->select_sum('loan_amount')->get_where('replace_loans', array('date<' => $date, 'date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->loan_amount;
                                                    $resultq = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date<' => $date, 'date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->other_amt;
                                                    $resultq = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<' => $date, 'vch_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $debitt += $resultq->debit;
                                                    $resultq = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<' => $date, 'vch_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                    $creditt += $resultq->credit;

                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('receipts', array('receipt_date<' => $date, 'receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                    $creditt += $details->add_less;
                                                    $details = $this->db->select_sum('add_less')->get_where('receipts', array('receipt_date<' => $date, 'receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                    $debitt += -($details->add_less);

                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date<' => $date, 'receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                    $creditt += $details->add_less;
                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date<' => $date, 'receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                    $debitt += -($details->add_less);

                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date<' => $date, 'pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                    $debitt += $details->add_less;
                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date<' => $date, 'pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                    $creditt += -($details->add_less);

                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date<' => $date, 'pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                    $debitt += $details->add_less;
                                                    $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date<' => $date, 'pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                    $creditt += -($details->add_less);
                                                    $balance = $openbal + $creditt - $debitt;
                                                    //   print_r($creditt);
                                                }
                                                ?>
                                                <td> <b><?php echo (!empty($date)) ? date('d-m-Y', strtotime($date)) : '-'; ?></b></td>
                                                <td class="text-left"><b>Opening Balance1</b></td>
                                                <td></td>
                                                <td class="text-right">
                                                    <b><?php
                                                        echo  moneyformat($balance)
                                                        ?>
                                                    </b>
                                                </td>
                                            </tr>


                                            <?php
                                            $credit = $debit = 0;
                                            $resultq = $this->db->select_sum('loan_amount')->get_where('loans', array('loan_date' => $date, 'status!=' => 'Trash'))->row();
                                            $debit += $resultq->loan_amount;
                                            $resultq = $this->db->select_sum('loan_amount')->get_where('personal_loans', array('loan_date' => $date, 'status!=' => 'Trash'))->row();
                                            $debit += $resultq->loan_amount;
                                            $resultq = $this->db->select_sum('loan_amt')->get_where('receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->row();
                                            $credit += $resultq->loan_amt;
                                            $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->row();
                                            $credit += $resultq->rcvd_int_amt;
                                            $resultq = $this->db->select_sum('loan_amt')->get_where('personalloan_receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->row();
                                            $credit += $resultq->loan_amt;
                                            $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->row();
                                            $credit += $resultq->rcvd_int_amt;
                                            $resultq = $this->db->select_sum('dep_amount')->get_where('deposits', array('dep_date' => $date, 'status!=' => 'Trash'))->row();
                                            $credit += $resultq->dep_amount;
                                            $resultq = $this->db->select_sum('dep_amt')->get_where('deposit_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->row();
                                            $credit += $resultq->dep_amt;
                                            $resultq = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->row();
                                            $debit += $resultq->paid_int_amt;
                                            $resultq = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->row();
                                            $debit += $resultq->loan_amt;
                                            $resultq = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->row();
                                            $debit += $resultq->paid_int_amt;
                                            $resultq = $this->db->select_sum('loan_amount')->get_where('replace_loans', array('date' => $date, 'status!=' => 'Trash'))->row();
                                            $credit += $resultq->loan_amount;
                                            $resultq = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date' => $date, 'status!=' => 'Trash'))->row();
                                            $debit += $resultq->other_amt;
                                            $resultq = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date' => $date, 'status!=' => 'Trash'))->row();
                                            $debit += $resultq->debit;
                                            $resultq = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date' => $date, 'status!=' => 'Trash'))->row();
                                            $credit += $resultq->credit;

                                            $details = $this->db->select('*')->select_sum('add_less')->get_where('receipts', array('receipt_date' => $date, 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                            $credit += $details->add_less;
                                            $details = $this->db->select_sum('add_less')->get_where('receipts', array('receipt_date' => $date, 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                            $debit += -($details->add_less);
                                            //print_r($detailss);
                                            $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date' => $date, 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                            $credit += $details->add_less;
                                            $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date' => $date, 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                            $debit += -($details->add_less);

                                            $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date' => $date, 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                            $debit += $details->add_less;
                                            $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date' => $date, 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                            $credit += -($details->add_less);

                                            $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date' => $date, 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                            $debit += $details->add_less;
                                            $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date' => $date, 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                            $credit += -($details->add_less);

                                            $cb = $balance + $credit - $debit;
                                            $i = 1;
                                            $loans = $this->db->select('*')->get_where('loans', array('loan_date' => $date, 'status!=' => 'Trash'))->result();
                                            foreach ($loans as $res) {
                                                ?>
                                                <tr>
                                                    <?php $getname = $this->db->select('party_name')->get_where('parties', array('party_id' => $res->party_name, 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <td ><?php echo $i; ?></td>
                                                    <td  class="text-left"><a href="view_loan?loan_id=<?php echo $res->loan_id; ?>" ><?php echo $getname->party_name . "\t" . "<br><b>Loan Party</b>" . "\t" . "<br>Loan No : " . $res->loan_no ?></a></td>
                                                    <td  class="credit text-right"> <?php echo number_format(0, 2) ?></td>
                                                    <td class="debit text-right"> <?php echo moneyformat($res->loan_amount); ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            $ploans = $this->db->select('*')->get_where('personal_loans', array('loan_date' => $date, 'status!=' => 'Trash'))->result();
                                            foreach ($ploans as $res) {
                                                ?>
                                                <tr>
                                                    <?php $getname = $this->db->select('party_name')->get_where('parties', array('party_id' => $res->party_name, 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <td ><?php echo $i; ?></td>
                                                    <td  class="text-left"><a href="view_loan?loan_id=<?php echo $res->loan_id; ?>" ><?php echo $getname->party_name . "\t" . "<br><b>Loan Party</b>" . "\t" . "<br>Loan No : " . $res->loan_no ?></a></td>
                                                    <td  class="credit text-right"> <?php echo number_format(0, 2) ?></td>
                                                    <td class="debit text-right"> <?php echo moneyformat($res->loan_amount); ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            $receipts = $this->db->select('*')->get_where('receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->result();
                                            foreach ($receipts as $result) {
                                                if ($result->add_less > 0) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td> 
                                                        <td class="text-left"><a href="view_receipt?receipt_id=<?php echo $result->receipt_id; ?>" ><?php echo $result->party_name . - $result->loan_no . "\t" . "<br><b>Interest Received</b>" . "<br>Add Less " . "\t" . "<br>Rcpt. No : " . $result->receipt_no ?></a></td>
                                                        <td class="credit text-right"> <?php echo moneyformat($result->loan_amt) . "\t" . "<br> " . moneyformat($result->rcvd_int_amt) . "\t" . "<br> " . moneyformat(($result->add_less)); ?></td>
                                                        <?php //$credit += ($result->add_less);    ?>
                                                        <td class="debit text-right"> <?php echo number_format(0, 2) ?></td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td class="text-left"><a href="view_receipt?receipt_id=<?php echo $result->receipt_id; ?>" ><?php echo $result->party_name . - $result->loan_no . "\t" . "<br><b>Interest Received</b>" . "<br>Add Less " . "\t" . "<br>Rcpt. No : " . $result->receipt_no ?></a></td>
                                                        <td class="credit text-right"> <?php echo moneyformat($result->loan_amt) . "\t" . "<br> " . moneyformat($result->rcvd_int_amt); ?></td>
                                                        <td class="debit text-right"> <?php echo number_format(0, 2) . "\t" . "<br>" . "<br> " . moneyformat(-$result->add_less) ?></td>
                                                        <?php //$debit += -($result->add_less);    ?>
                                                    </tr>  
                                                    <?php
                                                }
                                                $i++;
                                            }
                                            $pl_receipts = $this->db->select('*')->get_where('personalloan_receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->result();
                                            foreach ($pl_receipts as $result) {
                                                if ($result->add_less > 0) {
                                                    ?>
                                                    <tr>
                                                        <td ><?php echo $i; ?></td>
                                                        <td class="text-left"><a href="view_plreceipt?receipt_id=<?php echo $result->receipt_id; ?>" ><?php echo $result->party_name . - $result->loan_no . "\t" . "<br><b>PL Interest Received</b>" . "<br>Add Less " . "\t" . "<br>Rcpt. No : " . $result->receipt_no ?></a></td>
                                                        <td class="credit text-right"> <?php echo moneyformat($result->loan_amt) . "\t" . "<br>" . moneyformat($result->rcvd_int_amt) . "\t" . "<br>" . moneyformat(($result->add_less)); ?></td>
                                                        <?php //$credit += ($result->add_less);    ?>
                                                        <td class="debit text-right"> <?php echo number_format(0, 2) ?></td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td ><?php echo $i; ?></td>
                                                        <td class="text-left"><a href="view_plreceipt?receipt_id=<?php echo $result->receipt_id; ?>" ><?php echo $result->party_name . - $result->loan_no . "\t" . "<br><b>PL Interest Received</b>" . "<br>Add Less " . "\t" . "<br>Rcpt. No : " . $result->receipt_no ?></a></td>
                                                        <td class="credit text-right"> <?php echo moneyformat($result->loan_amt) . "\t" . "<br>" . moneyformat($result->rcvd_int_amt); ?></td>
                                                        <?php //$debit += -($result->add_less);    ?>
                                                        <td class="debit text-right"> <?php echo number_format(0, 2) . "\t" . "<br>" . moneyformat(-$result->add_less) ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                $i++;
                                            }
                                            $deposits = $this->db->select('*')->get_where('deposits', array('dep_date' => $date, 'status!=' => 'Trash'))->result();
                                            foreach ($deposits as $result) {
                                                ?>
                                                <tr>
                                                    <?php $getname = $this->db->select('party_name')->get_where('deposit_parties', array('dep_party_id' => $result->party_name, 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <td ><?php echo $i; ?></td>
                                                    <td class="text-left"><a href="view_deposit?deposit_id=<?php echo $result->deposit_id; ?>" ><?php echo $getname->party_name . "\t" . "<br><b>Deposit Party</b>" . "\t" . "<br>Dep No : " . $result->dep_no; ?></a></td>
                                                    <td class="credit text-right"> <?php echo moneyformat($result->dep_amount); ?></td>

                                                    <td class="debit text-right"> <?php echo number_format(0, 2) ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            $deposit_payments = $this->db->select('*')->get_where('deposit_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->result();
                                            foreach ($deposit_payments as $result) {
                                                if ($result->add_less < 0) {
                                                    ?>
                                                    <tr>
                                                        <td ><?php echo $i; ?></td>
                                                        <td class="text-left"><a href="view_dep_pymt?pymt_id=<?php echo $result->pymt_id; ?>" ><?php echo $result->party_name . "\t" . "<br><b>Deposits & Interest Paid</b>" . "\t" . "<br>Pymt. No : " . $result->pymt_no . "<br>Add Less"; ?></a></td>
                                                        <td class="credit text-right"> <?php echo moneyformat($result->dep_amt) . "<br>" . moneyformat(-($result->add_less)); ?></td>
                                                        <?php //$credit += -($result->add_less);    ?>
                                                        <td class="debit text-right"> <?php echo moneyformat($result->paid_int_amt) ?></td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td ><?php echo $i; ?></td>
                                                        <td class="text-left"><a href="view_dep_pymt?pymt_id=<?php echo $result->pymt_id; ?>" ><?php echo $result->party_name . "\t" . "<br><b>Deposits & Interest Paid</b>" . "\t" . "<br>Pymt. No : " . $result->pymt_no . "<br>Add Less " ?></a></td>
                                                        <?php //$debit += ($result->add_less);    ?>
                                                        <td class="credit text-right"> <?php echo moneyformat($result->dep_amt); ?></td>
                                                        <td class="debit text-right"> <?php echo moneyformat($result->paid_int_amt) . "<br>" . moneyformat($result->add_less) ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                $i++;
                                            }
                                            $replace_payments = $this->db->select('*')->get_where('replace_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->result();
                                            foreach ($replace_payments as $result) {
                                                if ($result->add_less < 0) {
                                                    ?>
                                                    <tr>
                                                        <td ><?php echo $i; ?></td>
                                                        <td class="text-left"><a href="view_rep_pymt?replace_payment_id=<?php echo $result->replace_payment_id; ?>" ><?php echo $result->bank_name . - $result->bank_loan_no . "<br><b>Interest Paid</b>" . "<br>Add Less"; ?></a></td>
                                                        <td class="credit text-right"> <?php echo moneyformat(- ($result->add_less)) ?></td>
                                                        <?php //$credit += - ($result->add_less);    ?>
                                                        <td class="debit text-right"> <?php echo moneyformat($result->loan_amt) . "<br>" . moneyformat($result->paid_int_amt) ?></td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td ><?php echo $i; ?></td>
                                                        <td class="text-left"><a href="view_rep_pymt?replace_payment_id=<?php echo $result->replace_payment_id; ?>" ><?php echo $result->bank_name . - $result->bank_loan_no . "<br><b>Interest Paid</b>" . "<br>Add Less"; ?></a></td>
                                                        <td class="credit text-right"></td>
                                                        <td class="debit text-right"> <?php echo moneyformat($result->loan_amt) . "<br>" . moneyformat($result->paid_int_amt) . "<br>" . "\t" . moneyformat($result->add_less) ?></td>
                                                        <?php //$debit += ($result->add_less);    ?>
                                                    </tr>
                                                    <?php
                                                }
                                                $i++;
                                            }
                                            $replace_loans = $this->db->select('*')->get_where('replace_loans', array('date' => $date, 'status!=' => 'Trash'))->result();
                                            foreach ($replace_loans as $result) {
                                                ?>
                                                <tr>
                                                    <td ><?php echo $i; ?></td>
                                                    <?php $getname = $this->db->select('bank_name')->get_where('banks', array('bank_id' => $result->bank_name, 'status!=' => 'Trash'))->row(); ?>
                                                    <td class="text-left"><a href="view_rep_loan?replaceloan_id=<?php echo $result->replaceloan_id; ?>" ><?php echo "\t" . $getname->bank_name . "\t" . "<br>Bank Loan. No : " . $result->bank_loan_no . "<br>Commission Paid to Bank : "; ?></a></td>
                                                    <td class="credit text-right"> <?php echo moneyformat($result->loan_amount); ?></td>
                                                    <td class="debit text-right"> <?php echo "\t" . "<br><br>" . ' ' . moneyformat($result->other_amt); ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            $voucher = $this->db->select('*')->get_where('vouchers', array('vch_date' => $date, 'status!=' => 'Trash'))->result();
                                            foreach ($voucher as $result) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <?php $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $result->particulars, 'status!=' => 'Trash'))->row();
                                                    ?>
                                                    <td class="text-left"><a href="view_voucher?voucher_id=<?php echo $result->voucher_id; ?>" ><?php echo $getname->name . "<br>Narration : " .substr($result->narration,0,80);  ?>...</a></td>
                                                    <td  class="credit text-right"> <?php echo moneyformat($result->credit); ?></td>
                                                    <td  class="debit text-right"> <?php echo moneyformat($result->debit); ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                            <tr><td colspan="3" class="text-right"><b><?php echo moneyformat($credit) ?></b></td><td  class="text-right"><b><?php echo moneyformat($debit) ?></b></td></tr>

                                            <?php if (!empty($cb)) {
                                                ?>
                                                <tr>
                                                    <td colspan='3' class="text-right"><b>Closing balance</b></td>
                                                    <td  class='text-right'> <?php echo moneyformat($cb) ?></td>
                                                </tr>  
                                                <?php
                                            }
                                        }
                                    } else {
                                        $date = $from;
                                        ?>
                                        <tr>
                                            <?php
                                            $creditt = $debitt = 0;

                                            $prevdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
                                            $get = $this->db->select('closing_balance')->get_where('daybooks', array('status!=' => 'Trash'))->row();
                                            $openbal = $get->closing_balance;

                                            if ($prevdate == "2019-03-31") {
                                                $creditt = 0;
                                                $debitt = 0;
                                                $balance = $openbal;
                                            } else {
                                                $resultq = $this->db->select_sum('loan_amount')->get_where('loans', array('loan_date<=' => $prevdate, 'loan_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $debitt += $resultq->loan_amount;
                                                $resultq = $this->db->select_sum('loan_amount')->get_where('personal_loans', array('loan_date<=' => $prevdate, 'loan_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $debitt += $resultq->loan_amount;
                                                $resultq = $this->db->select_sum('loan_amt')->get_where('receipts', array('receipt_date<=' => $prevdate, 'receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $creditt += $resultq->loan_amt;
                                                $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('receipt_date<=' => $prevdate, 'receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $creditt += $resultq->rcvd_int_amt;
                                                $resultq = $this->db->select_sum('loan_amt')->get_where('personalloan_receipts', array('receipt_date<=' => $prevdate, 'receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $creditt += $resultq->loan_amt;
                                                $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('receipt_date<=' => $prevdate, 'receipt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $creditt += $resultq->rcvd_int_amt;
                                                $resultq = $this->db->select_sum('dep_amount')->get_where('deposits', array('dep_date<=' => $prevdate, 'dep_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $creditt += $resultq->dep_amount;
                                                $resultq = $this->db->select_sum('dep_amt')->get_where('deposit_payments', array('pymt_date<=' => $prevdate, 'pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $creditt += $resultq->dep_amt;
                                                $resultq = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('pymt_date<=' => $prevdate, 'pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $debitt += $resultq->paid_int_amt;
                                                $resultq = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('pymt_date<=' => $prevdate, 'pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $debitt += $resultq->loan_amt;
                                                $resultq = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date<=' => $prevdate, 'pymt_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $debitt += $resultq->paid_int_amt;
                                                $resultq = $this->db->select_sum('loan_amount')->get_where('replace_loans', array('date<=' => $prevdate, 'date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $creditt += $resultq->loan_amount;
                                                $resultq = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date<=' => $prevdate, 'date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $debitt += $resultq->other_amt;
                                                $resultq = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date<=' => $prevdate, 'vch_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $debitt += $resultq->debit;
                                                $resultq = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date<=' => $prevdate, 'vch_date>' => '2019-03-31', 'status!=' => 'Trash'))->row();
                                                $creditt += $resultq->credit;

                                                $details = $this->db->select('*')->select_sum('add_less')->get_where('receipts', array('receipt_date<=' => $prevdate, 'receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                $creditt += $details->add_less;
                                                $details = $this->db->select_sum('add_less')->get_where('receipts', array('receipt_date<=' => $prevdate, 'receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                $debitt += -($details->add_less);

                                                $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date<=' => $prevdate, 'receipt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                $creditt += $details->add_less;
                                                $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date<=' => $prevdate, 'receipt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                $debitt += -($details->add_less);

                                                $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date<=' => $prevdate, 'pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                $debitt += $details->add_less;
                                                $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date<=' => $prevdate, 'pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                $creditt += -($details->add_less);

                                                $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date<=' => $prevdate, 'pymt_date>' => '2019-03-31', 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                                $debitt += $details->add_less;
                                                $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date<=' => $prevdate, 'pymt_date>' => '2019-03-31', 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                                $creditt += -($details->add_less);
                                                $balance = $openbal + $creditt - $debitt;
                                            }
                                            ?>
                                            <td> <b><?php echo (!empty($date)) ? date('d-m-Y', strtotime($date)) : '-'; ?></b></td>
                                            <td class="text-left"><b>Opening Balance</b></td>
                                            <td></td>
                                            <td class="text-right"> <b><?php echo moneyformat($balance) ?></b></td>
                                        </tr>


                                        <?php
                                        $cb = $debit = $credit = 0;
                                        $resultq = $this->db->select_sum('loan_amount')->get_where('loans', array('loan_date' => $date, 'status!=' => 'Trash'))->row();
                                        $debit += $resultq->loan_amount;
                                        $resultq = $this->db->select_sum('loan_amount')->get_where('personal_loans', array('loan_date' => $date, 'status!=' => 'Trash'))->row();
                                        $debit += $resultq->loan_amount;
                                        $resultq = $this->db->select_sum('loan_amt')->get_where('receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->row();
                                        $credit += $resultq->loan_amt;
                                        $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->row();
                                        $credit += $resultq->rcvd_int_amt;
                                        $resultq = $this->db->select_sum('loan_amt')->get_where('personalloan_receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->row();
                                        $credit += $resultq->loan_amt;
                                        $resultq = $this->db->select_sum('rcvd_int_amt')->get_where('personalloan_receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->row();
                                        $credit += $resultq->rcvd_int_amt;
                                        $resultq = $this->db->select_sum('dep_amount')->get_where('deposits', array('dep_date' => $date, 'status!=' => 'Trash'))->row();
                                        $credit += $resultq->dep_amount;
                                        $resultq = $this->db->select_sum('dep_amt')->get_where('deposit_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->row();
                                        $credit += $resultq->dep_amt;
                                        $resultq = $this->db->select_sum('paid_int_amt')->get_where('deposit_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->row();
                                        $debit += $resultq->paid_int_amt;
                                        $resultq = $this->db->select_sum('loan_amt')->get_where('replace_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->row();
                                        $debit += $resultq->loan_amt;
                                        $resultq = $this->db->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->row();
                                        $debit += $resultq->paid_int_amt;
                                        $resultq = $this->db->select_sum('loan_amount')->get_where('replace_loans', array('date' => $date, 'status!=' => 'Trash'))->row();
                                        $credit += $resultq->loan_amount;
                                        $resultq = $this->db->select_sum('other_amt')->get_where('replace_loans', array('date' => $date, 'status!=' => 'Trash'))->row();
                                        $debit += $resultq->other_amt;
                                        $resultq = $this->db->select_sum('debit')->get_where('vouchers', array('vch_date' => $date, 'status!=' => 'Trash'))->row();
                                        $debit += $resultq->debit;
                                        $resultq = $this->db->select_sum('credit')->get_where('vouchers', array('vch_date' => $date, 'status!=' => 'Trash'))->row();
                                        $credit += $resultq->credit;

                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('receipts', array('receipt_date' => $date, 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                        $credit += $details->add_less;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('receipts', array('receipt_date' => $date, 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                        $debit += -($details->add_less);

                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date' => $date, 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                        $credit += $details->add_less;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('personalloan_receipts', array('receipt_date' => $date, 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                        $debit += -($details->add_less);

                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date' => $date, 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                        $debit += $details->add_less;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('replace_payments', array('pymt_date' => $date, 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                        $credit += -($details->add_less);

                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date' => $date, 'add_less >' => 0, 'status !=' => 'Trash'))->row();
                                        $debit += $details->add_less;
                                        $details = $this->db->select('*')->select_sum('add_less')->get_where('deposit_payments', array('pymt_date' => $date, 'add_less <' => 0, 'status !=' => 'Trash'))->row();
                                        $credit += -($details->add_less);

                                        $cb = $balance + $credit - $debit;
                                        // print_r($balance);

                                        $i = 1;
                                        $loans = $this->db->select('*')->get_where('loans', array('loan_date' => $date, 'status!=' => 'Trash'))->result();
                                        foreach ($loans as $res) {
                                            ?>
                                            <tr>
                                                <?php $getname = $this->db->select('party_name')->get_where('parties', array('party_id' => $res->party_name, 'status!=' => 'Trash'))->row();
                                                ?>
                                                <td ><?php echo $i; ?></td>
                                                <td  class="text-left"><a href="view_loan?loan_id=<?php echo $res->loan_id; ?>" ><?php echo $getname->party_name . "\t" . "<br><b>Loan Party</b>" . "\t" . "<br>Loan No : " . $res->loan_no ?></a></td>
                                                <td  class="credit text-right"> <?php echo number_format(0, 2) ?></td>
                                                <td class="debit text-right"> <?php echo moneyformat($res->loan_amount); ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        $ploans = $this->db->select('*')->get_where('personal_loans', array('loan_date' => $date, 'status!=' => 'Trash'))->result();
                                        foreach ($ploans as $res) {
                                            ?>
                                            <tr>
                                                <?php $getname = $this->db->select('party_name')->get_where('parties', array('party_id' => $res->party_name, 'status!=' => 'Trash'))->row();
                                                ?>
                                                <td ><?php echo $i; ?></td>
                                                <td  class="text-left"><a href="view_loan?loan_id=<?php echo $res->loan_id; ?>" ><?php echo $getname->party_name . "\t" . "<br><b>Loan Party</b>" . "\t" . "<br>Loan No : " . $res->loan_no ?></a></td>
                                                <td  class="credit text-right"> <?php echo number_format(0, 2) ?></td>
                                                <td class="debit text-right"> <?php echo moneyformat($res->loan_amount); ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        $receipts = $this->db->select('*')->get_where('receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->result();
                                        foreach ($receipts as $result) {
                                            if ($result->add_less > 0) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td> 
                                                    <td class="text-left"><a href="view_receipt?receipt_id=<?php echo $result->receipt_id; ?>" ><?php echo $result->party_name . - $result->loan_no . "\t" . "<br><b>Interest Received</b>" . "<br>Add Less " . "\t" . "<br>Rcpt. No : " . $result->receipt_no ?></a></td>
                                                    <td class="credit text-right"> <?php echo moneyformat($result->loan_amt) . "\t" . "<br> " . moneyformat($result->rcvd_int_amt) . "\t" . "<br> " . moneyformat(($result->add_less)); ?></td>
                                                    <?php //$credit += ($result->add_less);     ?>
                                                    <td class="debit text-right"> <?php echo number_format(0, 2) ?></td>
                                                </tr>
                                            <?php } else { ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td class="text-left"><a href="view_receipt?receipt_id=<?php echo $result->receipt_id; ?>" ><?php echo $result->party_name . - $result->loan_no . "\t" . "<br><b>Interest Received</b>" . "<br>Add Less " . "\t" . "<br>Rcpt. No : " . $result->receipt_no ?></a></td>
                                                    <td class="credit text-right"> <?php echo moneyformat($result->loan_amt) . "\t" . "<br> " . moneyformat($result->rcvd_int_amt); ?></td>
                                                    <td class="debit text-right"> <?php echo number_format(0, 2) . "\t" . "<br>" . "<br> " . moneyformat(-$result->add_less) ?></td>
                                                    <?php //$debit += -($result->add_less);     ?>
                                                </tr>  
                                                <?php
                                            }
                                            $i++;
                                        }
                                        $pl_receipts = $this->db->select('*')->get_where('personalloan_receipts', array('receipt_date' => $date, 'status!=' => 'Trash'))->result();
                                        foreach ($pl_receipts as $result) {
                                            if ($result->add_less > 0) {
                                                ?>
                                                <tr>
                                                    <td ><?php echo $i; ?></td>
                                                    <td class="text-left"><a href="view_plreceipt?receipt_id=<?php echo $result->receipt_id; ?>" ><?php echo $result->party_name . "\t" . "<br><b>PL Interest Received</b>" . "<br>Add Less " . "\t" . "<br>Rcpt. No : " . $result->receipt_no ?></a></td>
                                                    <td class="credit text-right"> <?php echo moneyformat($result->loan_amt) . "\t" . "<br>" . moneyformat($result->rcvd_int_amt) . "\t" . "<br>" . moneyformat(($result->add_less)); ?></td>
                                                    <?php //$credit += ($result->add_less);     ?>
                                                    <td class="debit text-right"> <?php echo number_format(0, 2) ?></td>
                                                </tr>
                                            <?php } else { ?>
                                                <tr>
                                                    <td ><?php echo $i; ?></td>
                                                    <td class="text-left"><a href="view_plreceipt?receipt_id=<?php echo $result->receipt_id; ?>" ><?php echo $result->party_name . "\t" . "<br><b>PL Interest Received</b>" . "<br>Add Less " . "\t" . "<br>Rcpt. No : " . $result->receipt_no ?></a></td>
                                                    <td class="credit text-right"> <?php echo moneyformat($result->loan_amt) . "\t" . "<br>" . moneyformat($result->rcvd_int_amt); ?></td>
                                                    <?php //$debit += -($result->add_less);     ?>
                                                    <td class="debit text-right"> <?php echo number_format(0, 2) . "\t" . "<br>" . moneyformat(-$result->add_less) ?></td>
                                                </tr>
                                                <?php
                                            }
                                            $i++;
                                        }
                                        $deposits = $this->db->select('*')->get_where('deposits', array('dep_date' => $date, 'status!=' => 'Trash'))->result();
                                        foreach ($deposits as $result) {
                                            ?>
                                            <tr>
                                                <?php $getname = $this->db->select('party_name')->get_where('deposit_parties', array('dep_party_id' => $result->party_name, 'status!=' => 'Trash'))->row();
                                                ?>
                                                <td ><?php echo $i; ?></td>
                                                <td class="text-left"><a href="view_deposit?deposit_id=<?php echo $result->deposit_id; ?>" ><?php echo $getname->party_name . "\t" . "<br><b>Deposit Party</b>" . "\t" . "<br>Dep No : " . $result->dep_no; ?></a></td>
                                                <td class="credit text-right"> <?php echo moneyformat($result->dep_amount); ?></td>

                                                <td class="debit text-right"> <?php echo number_format(0, 2) ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        $deposit_payments = $this->db->select('*')->get_where('deposit_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->result();
                                        foreach ($deposit_payments as $result) {
                                            if ($result->add_less < 0) {
                                                ?>
                                                <tr>
                                                    <td ><?php echo $i; ?></td>
                                                    <td class="text-left"><a href="view_dep_pymt?pymt_id=<?php echo $result->pymt_id; ?>" ><?php echo $result->party_name . "\t" . "<br><b>Deposits & Interest Paid</b>" . "\t" . "<br>Pymt. No : " . $result->pymt_no . "<br>Add Less"; ?></a></td>
                                                    <td class="credit text-right"> <?php echo moneyformat($result->dep_amt) . "<br>" . moneyformat(-($result->add_less)); ?></td>
                                                    <?php //$credit += -($result->add_less);     ?>
                                                    <td class="debit text-right"> <?php echo moneyformat($result->paid_int_amt) ?></td>
                                                </tr>
                                            <?php } else { ?>
                                                <tr>
                                                    <td ><?php echo $i; ?></td>
                                                    <td class="text-left"><a href="view_dep_pymt?pymt_id=<?php echo $result->pymt_id; ?>" ><?php echo $result->party_name . "\t" . "<br><b>Deposits & Interest Paid</b>" . "\t" . "<br>Pymt. No : " . $result->pymt_no . "<br>Add Less " ?></a></td>
                                                    <?php //$debit += ($result->add_less);     ?>
                                                    <td class="credit text-right"> <?php echo moneyformat($result->dep_amt); ?></td>
                                                    <td class="debit text-right"> <?php echo moneyformat($result->paid_int_amt) . "<br>" . moneyformat($result->add_less) ?></td>
                                                </tr>
                                                <?php
                                            }
                                            $i++;
                                        }
                                        $replace_payments = $this->db->select('*')->get_where('replace_payments', array('pymt_date' => $date, 'status!=' => 'Trash'))->result();
                                        foreach ($replace_payments as $result) {
                                            if ($result->add_less < 0) {
                                                ?>
                                                <tr>
                                                    <td ><?php echo $i; ?></td>
                                                    <td class="text-left"><a href="view_rep_pymt?replace_payment_id=<?php echo $result->replace_payment_id; ?>" ><?php echo $result->bank_name . - $result->bank_loan_no . "<br><b>Interest Paid</b>" . "<br>Add Less"; ?></a></td>
                                                    <td class="credit text-right"> <?php echo moneyformat(- ($result->add_less)) ?></td>
                                                    <?php //$credit += - ($result->add_less);     ?>
                                                    <td class="debit text-right"> <?php echo moneyformat($result->loan_amt) . "<br>" . moneyformat($result->paid_int_amt) ?></td>
                                                </tr>
                                            <?php } else { ?>
                                                <tr>
                                                    <td ><?php echo $i; ?></td>
                                                    <td class="text-left"><a href="view_rep_pymt?replace_payment_id=<?php echo $result->replace_payment_id; ?>" ><?php echo $result->bank_name . - $result->bank_loan_no . "<br><b>Interest Paid</b>" . "<br>Add Less"; ?></a></td>
                                                    <td class="credit text-right"></td>
                                                    <td class="debit text-right"> <?php echo moneyformat($result->loan_amt) . "<br>" . moneyformat($result->paid_int_amt) . "<br>" . "\t" . moneyformat($result->add_less) ?></td>
                                                    <?php //$debit += ($result->add_less);     ?>
                                                </tr>
                                                <?php
                                            }
                                            $i++;
                                        }
                                        $replace_loans = $this->db->select('*')->get_where('replace_loans', array('date' => $date, 'status!=' => 'Trash'))->result();
                                        foreach ($replace_loans as $result) {
                                            ?>
                                            <tr>
                                                <td ><?php echo $i; ?></td>
                                                <?php $getname = $this->db->select('bank_name')->get_where('banks', array('bank_id' => $result->bank_name, 'status!=' => 'Trash'))->row(); ?>
                                                <td class="text-left"><a href="view_rep_loan?replaceloan_id=<?php echo $result->replaceloan_id; ?>" ><?php echo "\t" . $getname->bank_name . "\t" . "<br>Bank Loan. No : " . $result->bank_loan_no . "<br>Commission Paid to Bank : "; ?></a></td>
                                                <td class="credit text-right"> <?php echo moneyformat($result->loan_amount); ?></td>
                                                <td class="debit text-right"> <?php echo "\t" . "<br><br>" . ' ' . moneyformat($result->other_amt); ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        $voucher = $this->db->select('*')->get_where('vouchers', array('vch_date' => $date, 'status!=' => 'Trash'))->result();
                                        foreach ($voucher as $result) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <?php $getname = $this->db->select('name')->get_where('ledger', array('ledger_id' => $result->particulars, 'status!=' => 'Trash'))->row();
                                                ?>
                                                <td style="width:50%" class="text-left"><a href="view_voucher?voucher_id=<?php echo $result->voucher_id; ?>" ><?php echo $getname->name . "<br>Narration : " .substr($result->narration,0,80);  ?>...</a></td>
                                                <td style="width:20%" class="credit text-right"> <?php echo moneyformat($result->credit); ?></td>
                                                <td style="width:30%" class="debit text-right"> <?php echo moneyformat($result->debit); ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                        <tr><td colspan="3" class="text-right"><b><?php echo moneyformat($credit) ?></b></td><td  class="text-right"><b><?php echo moneyformat($debit) ?></b></td></tr>
                                        <?php if (!empty($cb)) {
                                            ?>
                                            <tr>
                                                <td colspan='3'  class="text-right"><b>Closing balance</b></td>
                                                <td  class='text-right'> <?php echo moneyformat($cb) ?></td>
                                            </tr>  
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /2 columns form -->        
    </div>
    <!-- /content area -->        
</div>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    messageTop: 'Daybook',
                    exportOptions: {
                        columns: [0, 1, 2, 3] //Your Colume value those you want
                                stripHtml: false
                    }

                },
                {
                    extend: 'excel',
                            exportOptions: {
                                messageTop: 'Daybook',
                                        columns: [0, 1, 2, 3] //Your Colume value those you want
                                        stripNewlines: false
                            }
                },
            ],
        });
    });
</script>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = '<h2 style="font-size:10px;">Kundrakudian Finance</h2><h6 style="font-size:10px;">540, South car street ,</h6><h6 style="font-size:10px;">Kundrakudi .</h6><h6 class="text-right" style="position:absolute; top:50px;right:0;font-size:10px"><b>From</b> :  <?php echo (!empty($from)) ? date('d-m-Y', strtotime($from)) : "01-04-2018" ?> ,<b>To</b> :  <?php echo (!empty($to)) ? date('d-m-Y', strtotime($to)) : '-'; ?></h6><br><h5 class="text-right" style="position:absolute; top:80px;right:0;font-size:10px"><b>Print Date</b> :  <?php echo date('d-m-Y') ?></h5><h2 class="text-center" style="font-size:12px;">Daybook</h2><table style="width:100% !important;border:1px solid #ddd;padding:10px;">' + document.getElementById(divName).innerHTML + '</table>';
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<script>
    $('#loan_no').change(function () {
        var loan_no = $(this).val();
        var receipt_date = $('#receipt_date').val();
        $.ajax({
            url: "<?php echo base_url('admin/show_data') ?>",
            data: 'loan_no=' + loan_no + "&receipt_date=" + receipt_date,
            dataType: "json",
            success: function (data) {
                $('#party_name').val(data.party_name);
                $('#loan_amt').val(data.loan_amt);
                $('#int_amt').val(data.int_amt);
                $('#adv_int').val(data.adv_int);
                $('#pre_bal_int_amt').val(data.pre_bal_int_amt);
                $('#total_amt').val(data.total_amt);
                $('#loan_date').val(data.loan_date);
                $('#loan_amount').val(data.loan_amount);
                $('#int_per').val(data.int_per);
                $('#last_rcvd_date').val(data.last_rcvd_date);
                $('#adv_interest').val(data.adv_interest);
                // $('#total_days').val(data.total_days);
                $('#int_amount').val(data.int_amount);
                $('#rcvd_loan_amt').val(data.rcvd_loan_amt);
                $('#rcvd_adv_int').val(data.rcvd_adv_int);
                $('#pre_bal_int_amount').val(data.pre_bal_int_amt);
                $('#bal_loan_amt').val(data.bal_loan_amt);
                if (data.bal_loan_amt == 0) {
                    alert("Account Closed");
                }
            }
        });
    });
</script>