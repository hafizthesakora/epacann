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
                             //   $year = date('Y', strtotime($yr));
                                $name = $this->input->get('name');
                                $getname = $this->db->get_where('ledger', array('ledger_id' => $name, 'status != ' => 'Trash'))->row();
                                if (!empty($getname)) {
                                    ?>
                                    <div class="trans-table-head"><h4>Ledger Monthly Summary - <span style="text-transform:uppercase"><?php echo $getname->name ?></span></h4></div>
                                <?php } else { ?>
                                    <div class="trans-table-head"><h4>Ledger Monthly Summary - <span style="text-transform:uppercase"><?php echo $name ?></span></h4></div>
                                <?php } ?><table class="transactions-table trans-margin table-striped table-bordered dataTable">
                                    <thead class="transactions-table-head">
                                        <tr>
                                            <th class="text-left">Date</th>
                                            <th class="text-left">Particulars</th>
                                            <th class="text-left">Vch. Type</th>
                                            <th class="text-right">Credit</th>
                                            <th class="text-right">Debit</th>
                                            <th class="text-right"> Balance ( GHS )</th>
                                        </tr>
                                    </thead>
                                    <?php if ($name == "loans") {
                                        $openbal= 1907350;
                                        ?>                                      
                                        <tbody>
                                             <tr>
                                        <td colspan="5" class="text-left"><b>Opening Balance</b></td>
                                        <td class="text-right">GHS <?php echo moneyformat($openbal); ?>Dr</td>
                                        
                                    </tr>
                                            <?php
                                            $closing_balance = 0;
                                            foreach ($get_tot_from_loans as $get_tot_from_loans) {
                                                // $get_sum = $this->db->order_by('pymt_date', "asc")->group_by('pymt_date')->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date' => $paidintresult->pymt_date, 'status !=' => 'Trash'))->row();
                                                $closing_balance = ($closing_balance + $get_tot_from_loans->loan_amount);
                                                ?>
                                                <?php if ($get_tot_from_loans != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_loan?loan_id=<?php echo $get_tot_from_loans->loan_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_loans->loan_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Loan no." . $get_tot_from_loans->loan_no ?></td>
                                                        <td class="text-left">Loan</td>
                                                         <td></td><td class="text-right">GHS <?php echo moneyformat( $get_tot_from_loans->loan_amount) ?></td>
                                                       <td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            }  foreach ($get_tot_from_recpt as $get_tot_from_recpt) {
                                                $closing_balance = ($closing_balance - $get_tot_from_recpt->loan_amt);
                                                ?>
                                                <?php if ($get_tot_from_recpt != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_receipt?receipt_id=<?php echo $get_tot_from_recpt->receipt_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_recpt->receipt_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Rcpt.No." . $get_tot_from_recpt->receipt_no ." </t> , "."Loan No." . $get_tot_from_recpt->loan_no?></td>
                                                        <td class="text-left">Receipt</td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $get_tot_from_recpt->loan_amt) ?></td>
                                                        <td></td><td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } ?>
                                            <tr>
                                                <td class="text-left"><b>Total</b></td>
                                                <td></td><td></td><td></td><td></td><td class="text-right"><b>GHS <?php echo moneyformat( $openbal+ $closing_balance) ?> Dr</b></td>
                                            </tr>
                                        </tbody>
                                    <?php }  else if ($name == "ploans") {
                                        ?>                                      
                                        <tbody>
                                            <?php
                                            $closing_balance = 0;
                                            foreach ($get_tot_from_ploans as $get_tot_from_ploans) {
                                                // $get_sum = $this->db->order_by('pymt_date', "asc")->group_by('pymt_date')->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date' => $paidintresult->pymt_date, 'status !=' => 'Trash'))->row();
                                                $closing_balance = ($closing_balance + $get_tot_from_ploans->loan_amount);
                                                ?>
                                                <?php if ($get_tot_from_ploans != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_ploan?personal_loan_id=<?php echo $get_tot_from_ploans->personal_loan_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_ploans->loan_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Loan no." . $get_tot_from_ploans->loan_no ?></td>
                                                        <td class="text-left">P.Loan</td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $get_tot_from_ploans->loan_amount) ?></td>
                                                        <td></td><td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            }  foreach ($get_tot_from_precpt as $get_tot_from_precpt) {
                                                $closing_balance = ($closing_balance - $get_tot_from_precpt->loan_amt);
                                                ?>
                                                <?php if ($get_tot_from_precpt != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_plreceipt?receipt_id=<?php echo $get_tot_from_precpt->receipt_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_precpt->receipt_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Rcpt.No." . $get_tot_from_precpt->receipt_no ?></td>
                                                        <td class="text-left">Receipt</td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $get_tot_from_precpt->loan_amt) ?></td>
                                                        <td></td><td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } ?>
                                            <tr>
                                                <td class="text-left"><b>Total</b></td>
                                                <td></td><td></td><td></td><td></td><td class="text-right"><b>GHS <?php echo moneyformat( $closing_balance) ?> Dr</b></td>
                                            </tr>
                                        </tbody>
                                    <?php } else if ($name == "deposits") {
                                        ?>                                      
                                        <tbody>
                                            <?php
                                            $closing_balance = 0;
                                            foreach ($get_tot_from_deposits as $get_tot_from_deposits) {
                                                // $get_sum = $this->db->order_by('pymt_date', "asc")->group_by('pymt_date')->select_sum('paid_int_amt')->get_where('replace_payments', array('pymt_date' => $paidintresult->pymt_date, 'status !=' => 'Trash'))->row();
                                                $closing_balance = ($closing_balance + $get_tot_from_deposits->dep_amount);
                                                ?>
                                                <?php if ($get_tot_from_deposits != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_deposit?deposit_id=<?php echo $get_tot_from_deposits->deposit_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_deposits->dep_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Dep no." . $get_tot_from_deposits->dep_no ?></td>
                                                        <td class="text-left">Deposit</td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $get_tot_from_deposits->dep_amount) ?></td>
                                                        <td></td><td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            }  foreach ($get_tot_from_deppay as $get_tot_from_deppay) {
                                                $closing_balance = ($closing_balance - $get_tot_from_deppay->dep_amt);
                                                ?>
                                                <?php if ($get_tot_from_deppay != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_dep_pymt?pymt_id=<?php echo $get_tot_from_deppay->pymt_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_deppay->pymt_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Pymt.No." . $get_tot_from_deppay->pymt_no ?></td>
                                                        <td class="text-left">Payment</td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $get_tot_from_deppay->dep_amt) ?></td>
                                                        <td></td><td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } ?>
                                            <tr>
                                                <td class="text-left"><b>Total</b></td>
                                                <td></td><td></td><td></td><td></td><td class="text-right"><b>GHS <?php echo moneyformat( $closing_balance) ?> Dr</b></td>
                                            </tr>
                                        </tbody>
                                    <?php }  else if ($name == "reploans") {
                                        ?>                                      
                                        <tbody>
                                            <?php
                                            $closing_balance = 0;
                                             foreach ($get_tot_from_reppay as $get_tot_from_reppay) {
                                                $closing_balance = ($closing_balance - $get_tot_from_reppay->loan_amt);
                                                ?>
                                                <?php if ($get_tot_from_reppay != "0") { ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_rep_pymt?replace_payment_id=<?php echo $get_tot_from_reppay->replace_payment_id; ?>" ><?php echo date('d-m-Y', strtotime($get_tot_from_reppay->pymt_date)); ?></a></td>
                                                        <td class="text-left"><?php echo "Pymt.No." . $get_tot_from_reppay->pymt_no ?></td>
                                                        <td class="text-left">Payment</td>
                                                        <td></td><td class="text-right">GHS <?php echo moneyformat( $get_tot_from_reppay->loan_amt) ?></td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td>
                                                    </tr>

                                                    <?php
                                                }
                                            } ?>
                                            <tr>
                                                <td class="text-left"><b>Total</b></td>
                                                <td></td><td></td><td></td><td></td><td class="text-right"><b>GHS <?php echo moneyformat( $closing_balance) ?> Dr</b></td>
                                            </tr>
                                        </tbody>
                                    <?php }?>
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
