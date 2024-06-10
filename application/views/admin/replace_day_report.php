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
                                 $name = $this->input->get('name');
                                $getname = $this->db->get_where('banks', array('bank_id' => $name, 'status != ' => 'Trash'))->row();
                                if (!empty($getname)) {
                                    ?>
                                    <div class="trans-table-head"><h4>Ledger Monthly Summary - <span style="text-transform:uppercase"><?php echo $getname->bank_name ?></span></h4></div>
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
                                            <th class="text-left">Date</th>
                                            <th class="text-left">Particulars</th>
                                            <th class="text-left">Vch. Type</th>
                                            <th class="text-right">Credit</th>
                                            <th class="text-right">Debit</th>
                                            <th class="text-right"> Balance ( GHS )</th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                            <?php
                                            $closing_balance = 0;
                                            $getopenbal=$this->db->select_sum('loan_amount')->get_where('replace_loans', array('bank_name'=>$name,'date<=' => '2019-03-31', 'status !=' => 'Trash'))->row();
                                       ?> <tr>
                                            <td colspan="5" class="text-left"><b>Opening Balance</b></td>
                                            <td colspan="3" class="text-right"> <b> GHS <?php echo moneyformat($getopenbal->loan_amount) ?> Dr</b></td>
                                        </tr>
<?php
                                               foreach ($bankdetails as $bankdetail) {
                                                 $closing_balance +=$getopenbal->loan_amount + $bankdetail->loan_amount;   ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_rep_loan?replaceloan_id=<?php echo $bankdetail->replaceloan_id; ?>" ><?php echo date('d-m-Y', strtotime($bankdetail->date)); ?></a></td>
                                                          <?php $getname=$this->db->select('bank_name')->get_where('banks',array('bank_id'=>$bankdetail->bank_name, 'status!='=>'Trash'))->row(); ?>
                                                        <td class="text-left"><?php echo "Bank Loan No :\t" . $bankdetail->bank_loan_no . ",\t" . "Particulars :\t" . $getname->bank_name ?></td>
                                                        <td class="text-left">Replace Loan</td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $bankdetail->loan_amount) ?></td>
                                                        <td></td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td>
                                                    </tr>  
                                                <?php 
                                                }
                                               foreach ($pymtdetails as $pymtdetails) {
                                                 $closing_balance +=  - $pymtdetails->loan_amt;   ?>
                                                    <tr>
                                                        <td class="text-left"><a href="view_rep_pymt?payment_id=<?php echo $pymtdetails->replace_payment_id; ?>" ><?php echo date('d-m-Y', strtotime($pymtdetails->pymt_date)); ?></a></td>
                                                       <td class="text-left"><?php echo "Bank Loan No :\t" . $pymtdetails->bank_loan_no . ",\t" . "Particulars :\t" . $pymtdetails->bank_name ?></td>
                                                        <td class="text-left">Payment</td>
                                                        <td></td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $pymtdetails->loan_amt) ?></td>
                                                        <td class="text-right">GHS <?php echo moneyformat( $closing_balance) ?></td>
                                                    </tr>  
                                                <?php 
                                                }
                                            
                                            ?>
                                            <tr>
                                                <td class="text-left"><b>Total</b></td>
                                                <td colspan="5" class="text-right"><b>GHS <?php echo moneyformat( $getopenbal->loan_amount + $closing_balance) ?> Cr</b></td>
                                               
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
