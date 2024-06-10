<?php
$date = date('Y-m-d');
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
                <li><a href=""><i class="icon-home2 position-left"></i>Entry</a></li>
                <li>Personal Loan Receipt</li>
                <li class="active">View PLoan Receipt</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body">
                <fieldset>
                    <legend>
                        <div class="button-style-2 invoice-button back-btn">
                            <a onclick="window.history.back();"><span class="trans-icons-3"></span>Back</a>     
                        </div>
                    </legend>
                    <div class="trans-table">
                        <div class="trans-table-head"><h4>Add PLoan Receipt</h4></div>
                        <form action="#" class="receipt-form form-validation" id="formID" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="panel panel-flat loan-panel">
                                    <div class="panel-body">
                                        <div class="form-group">
                                                <label class="col-lg-4 control-label">Rept. No</label>
                                                <div class="col-lg-8">
                                                   <div class="view"><h5> <?php echo $result->receipt_no; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Rcpt. Date</label>                                                    
                                                <div class="col-lg-8"> 
                                               <div class="view"><h5><?php echo date('d-m-Y', strtotime($result->receipt_date)); ?></h5> </div>                                                   </div>
                                                </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Rcd Upto Dt</label>                                                    
                                                <div class="col-lg-8"> 
                                                   <div class="view"><h5><?php echo date('d-m-Y', strtotime($result->int_rcvd_upto_date)); ?></h5> </div>                                              </div>
                                                </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Loan No</label>
                                                <div class="col-lg-8">
                                                   <div class="view"><h5> <?php echo $result->loan_no; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Party name</label>
                                                <div class="col-lg-8">
                                                    <div class="view"><h5> <?php echo $result->party_name; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Loan Amount (GHS )</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->loan_amt; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->int_amt; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pre Bal Int Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->pre_bal_int_amt; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Rcvd Int Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->rcvd_int_amt; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Add/Less (GHS )</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->add_less; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label"><strong>Total Amt (GHS )</strong></label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->total_amt; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pay To</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->pay_to; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Remarks</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php if(!empty($result->remarks)) echo $result->remarks;else echo '-'; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">A/c Close</label>  
                                                <div class="col-lg-8"> 
                                                     <div class="view"><h5> <?php echo $result->ac_close; ?> </h5> </div>
                                                 </div>
                                            </div>
                                     </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="panel panel-flat loan-panel">
                                    <div class="panel-body">
                                         <div class="form-group">
                                                <label class="col-lg-4 control-label">Loan Date</label>                                                    
                                                <div class="col-lg-8"> 
                                                    <div class="view"><h5><?php echo date('d-m-Y', strtotime($result->last_rcvd_date)); ?></h5> </div>
                                                </div>
                                                </div>
   <div class="form-group">
                                                <label class="col-lg-4 control-label">Loan Amount (GHS )</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->loan_amount; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Per ( % )</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->int_per; ?> </h5> </div>
                                                </div>
                                            </div>     
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Last Rcvd Dt</label>                                                    
                                                <div class="col-lg-8"> 
                                                     <div class="view"><h5><?php echo date('d-m-Y', strtotime($result->last_rcvd_date)); ?></h5> </div>
                                                </div>
                                                </div>
                                           <!-- <div class="form-group">
                                                <label class="col-lg-4 control-label">Adv Int Amt (GHS )<span>:</span></label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="adv_int_amt" id="adv_int_amt" placeholder="" class="form-control validate[required]">
                                                </div>
                                            </div>-->
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Total Days<span>:</span></label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->total_days; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Amt (GHS )<span>:</span></label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->int_amount; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Rcvd Loan Amt (GHS )<span>:</span></label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->rcvd_loan_amt; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pre Bal Int Amt (GHS )<span>:</span></label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->pre_bal_int_amt; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Bal Loan Amt (GHS )<span>:</span></label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->bal_loan_amt; ?> </h5> </div>
                                                </div>
                                            </div>
                                        <input type="hidden" name="prebal_calc" id="prebal_calc" placeholder="" class="form-control form-space">  
                                        <input type="hidden" name="rcvd_loan_calc" id="rcvd_loan_calc" placeholder="" class="form-control form-space">
                                       <input type="hidden" name="bal_loan_calc" id="bal_loan_calc" placeholder="" class="form-control form-space"> 
                                      </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </fieldset>
            </div>
            <!-- /content area -->
        </div>  
    </div>
</div>
<style>
    label{
        font-weight: bold;
        margin-bottom: 8px; 
    }
</style>
