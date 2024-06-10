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
                    $closing_balance = $get_closing_balance->closing_balance;
                    ?>
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
                                    <?php if ($name != "cash_a/c") { ?>
                                        <tbody>
                                            <tr>
                                                <td class="text-left"><b>Opening Balance</b></td>
                                                <td colspan="3" class="text-right"> <b> GHS <?php echo moneyformat($closing_balance) ?> Dr</b></td>
                                            </tr>
                                            <?php
                                            $closing_balance = $get_closing_balance->closing_balance;
                                            foreach ($getdetails as $getdetail) {
                                                $voucher_id = $this->input->get('voucher_id');
                                                $first_result = $this->db->select('*')->order_by('vch_date', "asc")->get_where("vouchers", array('particulars' => $voucher_id, 'status !=' => 'Trash'))->row();
                                                $date = date('m', strtotime($getdetail->vch_date));
                                                $year = date('Y', strtotime($getdetail->vch_date));
                                                $credit = $this->db->select_sum('credit')->get_where("vouchers", array('MONTH(vch_date)' => $date, 'YEAR(vch_date)' => $year, 'particulars' => $name, 'status !=' => 'Trash'))->result();
                                                $debit = $this->db->select_sum('debit')->get_where("vouchers", array('MONTH(vch_date)' => $date, 'YEAR(vch_date)' => $year, 'particulars' => $name, 'status !=' => 'Trash'))->result();
                                               
                                                
                                               $closing_balance = ($closing_balance + $credit[0]->credit - $debit[0]->debit);
                                            //    if ($first_result->debit > $first_result->credit) {
                                             //       $closing_balance = ($closing_balance + $debit[0]->debit - $credit[0]->credit);
                                            //    } else {
                                            //        $closing_balance = ($closing_balance + $credit[0]->credit - $debit[0]->debit);
                                           //     }
                                                ?>
                                                <tr><?php $date = date('F, Y', strtotime($getdetail->vch_date)); ?>
                                                    <td class="text-left"><a href="day_report?name=<?php echo $name ?>&month=<?php echo date('F', strtotime($getdetail->vch_date)); ?>&year=<?php echo date('Y', strtotime($getdetail->vch_date)); ?>">
                                                            <?php echo $date; ?></a></td>
                                                    <td class="text-right">GHS <?php echo moneyformat($credit[0]->credit) ?></td>
                                                    <td class="text-right">GHS <?php echo moneyformat( $debit[0]->debit) ?></td>
                                                    <?php //if ($getdetail->debit > $getdetail->credit) { ?>
                                                    <td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td> 
                                                    <?php //} else { ?>
                                                    <!--<td class="text-right">GHS <?php echo moneyformat( $closing_balance) . 'Cr' ?></td>-->     
                                                    <?php //} ?>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr>
                                                <?php if ($first_result->debit > $first_result->credit) { ?>
                                                    <td class="text-left"><b>Total</b></td><td colspan="3" class="text-right">GHS <b><?php echo moneyformat($closing_balance) ?>Dr</b></td> 
                                                <?php } else { ?>
                                                    <td class="text-left"><b>Total</b></td><td colspan="3" class="text-right">GHS <b><?php echo moneyformat($closing_balance) ?>Cr</b></td> 
                                                <?php } ?>
                                            </tr>
                                        </tbody>
                                    <?php
                                    } else {
                                        $closing_balance = 0;
                                        foreach ($results as $key => $result) {
                                            $closing_balance = $closing_balance + $result;
                                            ?>
                                            <tr>
                                                <td class="text-left"><?php echo $key; ?></td>
                                                <td class="text-right">GHS <?php echo moneyformat($result); ?></td>
                                                <td colspan="2" class="text-right">GHS <?php echo moneyformat( $closing_balance); ?></td>
                                            </tr>
    <?php } ?>
                                        <tr>
                                            <td class="text-left"><b>Total</b></td><td colspan="3" class="text-right">GHS <b><?php echo moneyformat($closing_balance) ?></b></td> 
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
