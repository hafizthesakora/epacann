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
                <li>Deposit Payment</li>
                <li class="active">Add Deposit Payment</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat  loan-panel">
            <div class="panel-body">
                <fieldset>
                    <legend>
                        <div class="button-style-2 invoice-button back-btn">
                            <a href="deposit_pymt_display"><span class="trans-icons-3"></span>Back</a>     
                        </div>
                    </legend>
                    <div class="trans-table">
                        <div class="trans-table-head"><h4>Add Deposit Payment</h4></div>
                        <form action="#" class="receipt-form form-validation" id="formID" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="panel panel-flat loan-panel">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pymt. No</label>
                                                <div class="col-lg-8">
                                                      <div class="view"><h5> <?php echo $result->pymt_no; ?> </h5> </div>
                                                  </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pymt. Date</label>                                                    
                                                <div class="col-lg-8"> 
                                                    <div class="view"><h5> <?php echo date('d-m-Y', strtotime($result->pymt_date)); ?> </h5> </div>
                                                    
                                            </div>
                                            </div>   
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Paid Upto Dt</label>                                                    
                                                <div class="col-lg-8"> 
                                                     <div class="view"><h5> <?php echo date('d-m-Y', strtotime($result->int_paid_upto_date)); ?> </h5> </div>
                                                </div>
                                             
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Dep No</label>
                                                <div class="col-lg-8">
                                                      <div class="view"><h5> <?php echo $result->dep_no; ?> </h5> </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label class="col-lg-4 control-label">Party Name</label>
                                                <div class="col-lg-8">
                                                      <div class="view"><h5> <?php echo $result->party_name; ?> </h5> </div>
                                                </div>
                                            </div>
                                              <div class="form-group">
                                                <label class="col-lg-4 control-label">Total Deposit Amount</label>
                                                <div class="col-lg-8">
                                                      <div class="view"><h5> <?php echo $result->total_dep_amt; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Dep Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                      <div class="view"><h5> <?php echo $result->dep_amt; ?> </h5> </div>
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
                                                <label class="col-lg-4 control-label">Paid Int Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->paid_int_amt; ?> </h5> </div>
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
                                                 <div class="view"><h5> <?php if(!empty($result->remarks)) echo $result->remarks; else echo '-';?> </h5> </div>
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
                                                <label class="col-lg-4 control-label">Dep Date</label>                                                    
                                                <div class="col-lg-8"> 
                                                     <div class="view"><h5> <?php echo  date('d-m-Y', strtotime($result->dep_date)); ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Dep Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->dep_amount; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Per ( % )</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->int_per; ?> </h5> </div>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Last Paid Dt</label>                                                    
                                                <div class="col-lg-8"> 
                                                     <div class="view"><h5> <?php echo  date('d-m-Y', strtotime($result->last_paid_date)); ?> </h5> </div>
                                                    <div class="class input-group date">
                                                 </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Total Days</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->total_days; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Int Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                    <div class="view"><h5> <?php echo $result->int_amt; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Paid Dep Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->paid_dep_amt; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Pre Bal Int Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->pre_bal_int_amt; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">Bal Dep Amt (GHS )</label>
                                                <div class="col-lg-8">
                                                     <div class="view"><h5> <?php echo $result->bal_dep_amt; ?> </h5> </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="prebal_calc" id="prebal_calc" placeholder="" class="form-control form-space"> 
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
        <!-- /2 columns form -->

        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<style>
    label{
        font-weight: bold;
        margin-bottom: 8px; 
    }
</style>
