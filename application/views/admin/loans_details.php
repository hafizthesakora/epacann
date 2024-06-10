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
                                $id = $this->input->get('id');
                                $name = $this->input->get('voucher_id');
                                $getname = $this->db->get_where('ledger', array('ledger_id' => $name, 'status != ' => 'Trash'))->row();
                                if (!empty($getname)) {
                                    ?>
                                    <div class="trans-table-head"><h4>Ledger Monthly Summary - <span style="text-transform:uppercase"><?php echo $getname->name ?></span></h4></div>
                                <?php } else { ?>
                                    <div class="trans-table-head"><h4>Ledger Monthly Summary - <span style="text-transform:uppercase"><?php echo $name ?></span></h4></div>
                                <?php } ?>
                                <table class="transactions-table trans-margin table-striped table-bordered dataTable" id="print">
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
                                            <th class="text-left">Month & Year</th>
                                            <th class="text-right">Credit</th>
                                            <th class="text-right">Debit</th>
                                            <th class="text-right">Closing Balance ( GHS )</th>
                                        </tr>
                                    </thead>

                                    <?php
                                    $closing_balance = 0;
                                    if ($name == "loans") {
                                       
                                         $openbal= 1907350;
                                        ?>
                                    <tr>
                                        <td colspan="3" class="text-left"><b>Opening Balance</b></td>
                                        <td class="text-right">GHS <?php echo moneyformat($openbal); ?></td>
                                        
                                    </tr>
                                        <?php foreach ($results as $key => $result) {
                                           
                                            $debit = $credit = 0;
                                            $details = $this->db->select('*')->select_sum('loan_amount')->get_where('loans', array('MONTH(loan_date)' => date('m', strtotime('01-' . $key)), 'YEAR(loan_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $debit += $details->loan_amount;
                                            $details = $this->db->select('*')->select_sum('loan_amt')->get_where('receipts', array('MONTH(receipt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(receipt_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $credit += $details->loan_amt;
                                            $closing_balance = $openbal + $debit - $credit;
                                            ?>
                                            <tr>
                                                <td class="text-left"><a href="loan_day_report?name=<?php echo $name ?>&month=<?php echo date('m', strtotime('01-' . $key)); ?>&year=<?php echo date('Y', strtotime('01-' . $key)); ?>">
                                                        <?php echo $key; ?></a></td>
                                                <td class="text-right">GHS <?php echo moneyformat($credit); ?></td>
                                                <td class="text-right">GHS <?php echo moneyformat($debit); ?></td>
                                                <td colspan="2" class="text-right">GHS <?php echo moneyformat($closing_balance); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else if ($name == "ploans") {
                                        foreach ($presults as $key => $result) {

                                            $debit = $credit = 0;
                                            $details = $this->db->select('*')->select_sum('loan_amount')->get_where('personal_loans', array('MONTH(loan_date)' => date('m', strtotime('01-' . $key)), 'YEAR(loan_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $debit += $details->loan_amount;
                                            $details = $this->db->select('*')->select_sum('loan_amt')->get_where('personalloan_receipts', array('MONTH(receipt_date)' => date('m', strtotime('01-' . $key)), 'YEAR(receipt_date)' => date('Y', strtotime('01-' . $key)), 'status !=' => 'Trash'))->row();
                                            $credit += $details->loan_amt;
                                            $closing_balance = $closing_balance +$debit- $credit ;
                                            ?>
                                            <tr>
                                                <td class="text-left"><a href="loan_day_report?name=<?php echo $name ?>&month=<?php echo date('m', strtotime('01-' . $key)); ?>&year=<?php echo date('Y', strtotime('01-' . $key)); ?>">
                                                        <?php echo $key; ?></a></td>
                                                <td class="text-right">GHS <?php echo moneyformat($credit); ?></td>
                                                <td class="text-right">GHS <?php echo moneyformat($debit); ?></td>
                                                <td></td><td class="text-right">GHS <?php echo moneyformat($closing_balance); ?></td>
                                            </tr>   
                                            <?php
                                        }
                                    } else if ($name == "deposits") {
                                        foreach ($dresults as $key => $result) {
                                            $closing_balance = $closing_balance + $result;
                                        ?>
                                            <tr>
                                                <td class="text-left"><a href="loan_day_report?name=<?php echo $name ?>&month=<?php echo date('m', strtotime('01-' . $key)); ?>&year=<?php echo date('Y', strtotime('01-' .$key)); ?>">
                                                        <?php echo $key; ?></a></td>
                                                <td class="text-right">GHS <?php echo moneyformat($result); ?></td>
                                                <td></td><td class="text-right">GHS <?php echo moneyformat($closing_balance); ?></td>
                                            </tr>   
                                            <?php
                                        }
                                    } else if ($name == "reploans") {
                                        foreach ($rpesults as $key => $result) {
                                            
                                            $closing_balance = $closing_balance + $result;
                                            ?>
                                            <tr>
                                                <td class="text-left"><a href="loan_day_report?name=<?php echo $name ?>&month=<?php echo date('m', strtotime('01-' . $key)); ?>&year=<?php echo date('Y', strtotime('01-' . $key)); ?>">
                                                        <?php echo $key; ?></a></td>
                                                <td colspan="2"  class="text-right">GHS <?php echo moneyformat($result); ?></td>
                                                <td class="text-right">GHS <?php echo moneyformat($closing_balance); ?></td>
                                            </tr>   
                                            <?php
                                        }
                                    }
                                    ?> 
                                    <tr>
                                        <td class="text-left"><b>Total</b></td><td colspan="3" class="text-right">GHS <b><?php echo moneyformat( $closing_balance) ?></b></td> 
                                    </tr>

                                    </tbody>
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
